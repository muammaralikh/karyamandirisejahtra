<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Order;

class AdminController extends Controller
{
    private function setActive($page)
    {
        return [
            'Dashboard' => $page,
            'DashboardActive' => true,
        ];
    }
    public function index()
    {
        $totalProduk = Produk::count();
        $totalKategori = Kategori::count();
        $totalUser = User::count();
        $totalPesanan = Order::count();
        $totalPendapatan = Order::where('status', 'completed')->sum('subtotal')
            - (Order::where('status', 'completed')->count() * 10000);

        $salesQuery = Order::where('status', 'completed')
            ->where('created_at', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'month')
            ->get();

        $salesByMonth = $salesQuery->mapWithKeys(function ($item) {
            return ["{$item->year}-{$item->month}" => (float) $item->total];
        });

        $chartLabels = [];
        $chartData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $label = $date->format('M Y');
            $key = $date->year . '-' . $date->month;

            $chartLabels[] = $label;
            $chartData[] = $salesByMonth[$key] ?? 0;
        }

        return view(
            'admin.pages.dashboard',
            array_merge([
                'totalProduk' => $totalProduk,
                'totalKategori' => $totalKategori,
                'totalUser' => $totalUser,
                'totalPesanan' => $totalPesanan,
                'totalPendapatan' => $totalPendapatan,
                'chartLabels' => $chartLabels,
                'chartData' => $chartData,
            ], $this->setActive('dashboard'), $this->setActive('dashboard'))
        );
    }

}