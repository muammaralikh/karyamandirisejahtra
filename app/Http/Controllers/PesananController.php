<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Order;
use App\Models\ActivityLog;

class PesananController extends Controller
{
    private const PAYMENT_PROOF_DIRECTORY = 'payment-proofs';

    private function setActive($page)
    {
        return [
            'activePesanan' => $page,
            'pesananActive' => true,
        ];
    }
    public function index(Request $request)
    {
        $this->cancelExpiredPendingOrders();

        $query = Order::with(['items.product', 'user']);
        if ($request->search) {
            $search = trim((string) $request->search);

            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('recipient_name', 'like', "%{$search}%")
                    ->orWhere('recipient_phone', 'like', "%{$search}%")
                    ->orWhere('shipping_address', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('username', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('items', function ($itemQuery) use ($search) {
                        $itemQuery->where('product_name', 'like', "%{$search}%");
                    });
            });
        }

        $pesanan = $query->paginate(10)->withQueryString();

        return view('admin.pages.pesanan', compact('pesanan'), $this->setActive('pesanan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ], [
            'payment_proof.required' => 'Bukti transfer wajib diupload sebelum pesanan ditandai lunas.',
            'payment_proof.mimes' => 'Bukti transfer harus berupa file JPG, JPEG, PNG, atau PDF.',
            'payment_proof.max' => 'Ukuran bukti transfer maksimal 4MB.',
        ]);

        $order = Order::findOrFail($id);

        if ($order->isExpiredPendingPayment()) {
            self::cancelOrderAsExpired($order);

            return redirect()->back()->with('error', 'Pesanan sudah melewati batas 1x24 jam dan otomatis dibatalkan.');
        }

        if (! $order->isPendingPayment()) {
            return redirect()->back()->with('error', 'Hanya pesanan Pending yang bisa dikonfirmasi Lunas.');
        }

        $oldValues = $order->only(['status', 'paid_at', 'payment_proof']);
        $paymentProofPath = $this->storePaymentProof($request->file('payment_proof'));
        $order->markAsPaid($paymentProofPath);

        ActivityLog::record(
            'konfirmasi_lunas',
            $order,
            $oldValues,
            $order->only(['status', 'paid_at', 'payment_proof']),
            "Pesanan {$order->order_number} dikonfirmasi lunas.",
            $order->order_number
        );

        return redirect()->back()->with('success', 'Pesanan berhasil dikonfirmasi Lunas.');
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $order = Order::with('items')->findOrFail($id);
            $oldValues = [
                'order_number' => $order->order_number,
                'status' => $order->status,
                'total' => $order->total,
                'recipient_name' => $order->recipient_name,
                'recipient_phone' => $order->recipient_phone,
            ];

            if (! in_array(strtolower((string) $order->status), ['pending', 'cancelled'], true)) {
                DB::rollBack();

                return redirect()
                    ->back()
                    ->with('error', 'Pesanan hanya dapat dihapus sebelum dikonfirmasi Lunas atau setelah dibatalkan.');
            }

            if ($order->isPendingPayment()) {
                $order->releaseStock();
            }

            // Hapus item pesanan dulu
            $order->items()->delete();

            // Hapus order
            $order->delete();
            ActivityLog::record(
                'hapus_pesanan',
                $order,
                $oldValues,
                [],
                "Pesanan {$order->order_number} dihapus.",
                $order->order_number
            );

            DB::commit();

            return redirect()
                ->route('pesanan.index')
                ->with('success', 'Pesanan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus pesanan');
        }
    }
    public function exportExcel()
    {
        $this->cancelExpiredPendingOrders();

        $filename = 'laporan-pesanan-' . now()->format('Y-m-d_His') . '.xls';
        $orders = Order::with(['items', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();
        ActivityLog::record(
            'export_pesanan',
            null,
            [],
            ['filename' => $filename, 'jumlah_pesanan' => $orders->count()],
            'Laporan pesanan diexport ke Excel.'
        );

        return response()
            ->view('exports.pesanan_excel', compact('orders'))
            ->header('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
            ->header('Content-Disposition', "attachment; filename={$filename}");
    }

    private function storePaymentProof($file): string
    {
        $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs(self::PAYMENT_PROOF_DIRECTORY, $filename, 'public');

        $this->syncPublicStorageFile($path);

        return $path;
    }

    private function syncPublicStorageFile(string $path): void
    {
        $source = storage_path('app/public/' . $path);
        $destination = public_path('storage/' . $path);

        if (! File::exists($source)) {
            return;
        }

        File::ensureDirectoryExists(dirname($destination));
        File::copy($source, $destination);
    }

    public static function cancelExpiredPendingOrders(): int
    {
        $expiredOrders = Order::with('items.product')
            ->where('status', 'pending')
            ->where('created_at', '<=', now()->subDay())
            ->get();

        foreach ($expiredOrders as $order) {
            self::cancelOrderAsExpired($order);
        }

        return $expiredOrders->count();
    }

    private static function cancelOrderAsExpired(Order $order): void
    {
        if (! $order->isPendingPayment()) {
            return;
        }

        $oldValues = $order->only(['status', 'cancelled_at', 'cancellation_reason']);
        $order->cancel('Batal - tidak ada konfirmasi pembayaran dalam 1x24 jam.');

        ActivityLog::record(
            'auto_batal_pesanan',
            $order,
            $oldValues,
            $order->only(['status', 'cancelled_at', 'cancellation_reason']),
            "Pesanan {$order->order_number} otomatis batal karena melewati 1x24 jam.",
            $order->order_number
        );
    }
}
