<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
class PesananController extends Controller
{
    private function setActive($page)
    {
        return [
            'activePesanan' => $page,
            'pesananActive' => true,
        ];
    }
    public function index(Request $request)
    {
        $query = Order::with('items.product');
        if ($request->search) {
            $query->where('order_number', 'like', '%' . $request->search . '%');
        }

        $pesanan = $query->paginate(10)->withQueryString();

        return view('admin.pages.pesanan', compact('pesanan'), $this->setActive('pesanan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        $order = Order::findOrFail($id);
        $previousStatus = $order->status;
        $newStatus = $request->status;

        if ($previousStatus !== 'cancelled' && $newStatus === 'cancelled') {
            $order->cancel();

            return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui');
        }

        $order->update([
            'status' => $newStatus
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui');
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $order = Order::with('items')->findOrFail($id);

            if ($order->status !== 'cancelled') {
                $order->releaseStock();
            }

            // Hapus item pesanan dulu
            $order->items()->delete();

            // Hapus order
            $order->delete();

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
        $filename = 'laporan-pesanan-' . now()->format('Y-m-d_His') . '.xls';
        $orders = Order::with(['items', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()
            ->view('exports.pesanan_excel', compact('orders'))
            ->header('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
            ->header('Content-Disposition', "attachment; filename={$filename}");
    }
}
