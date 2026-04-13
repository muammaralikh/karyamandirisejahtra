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

        $order->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui');
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $order = Order::with('items')->findOrFail($id);

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
        $filename = 'laporan pesanan.csv';

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            
            // 1. Tambahkan BOM (Byte Orderaaark) agar Excelzzzz atis membaca encoding UTF-8 dengan benar
            fputs($file, "\xEF\xBB\xBF");

            // 2. Gunakan separator titik koma (;) yang lebih ramah untuk Excel dengan region Indonesia
            $separator = ';';

            fputcsv($file, [
                'Tanggal',
                'Nama Pemesan',
                'Alamat Lengkap',
                'Nama Produk',
                'Jumlah',
                'Harga Produk',
                'Ongkir',
                'Subtotal',
                'Status Pesanan'
            ], $separator);

            $orders = Order::with(['items', 'user'])
            ->orderBy('created_at', 'desc') 
            ->get();

            foreach ($orders as $order) {
                foreach ($order->items as $item) {
                    
                    // 3. Bersihkan enter/newline dari teks alamat yang bikin baris di Excel hancur
                    $alamatLengkap = str_replace(["\r\n", "\r", "\n"], ' ', $order->shipping_address);

                    fputcsv($file, [
                        $order->created_at->format('d-m-Y'),
                        $order->user->name ?? '-', 
                        $alamatLengkap,
                        $item->product_name,
                        $item->qty,
                        $item->price,
                        $order->shipping_cost,
                        $order->subtotal,
                        strtoupper($order->status)
                    ], $separator);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}