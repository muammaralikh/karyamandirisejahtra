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
        $totalPendapatan = Order::where('status', 'completed')->sum('total');

        $currentMonthRevenue = Order::where('status', 'completed')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total');

        $previousMonthRevenue = Order::where('status', 'completed')
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->sum('total');

        $salesQuery = Order::where('status', 'completed')
            ->where('created_at', '>=', Carbon::parse('2026-01-01')->startOfMonth())
            ->where('created_at', '<', Carbon::parse('2026-01-01')->addYear()->startOfMonth())
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total) as total')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $salesByMonth = $salesQuery->mapWithKeys(function ($item) {
            return ["{$item->year}-{$item->month}" => (float) $item->total];
        });

        $chartLabels = [];
        $chartData = [];
        $startDate = Carbon::parse('2026-01-01');

        for ($i = 0; $i < 12; $i++) {
            $date = $startDate->copy()->addMonths($i);
            $label = $date->locale('id')->isoFormat('MMMM YYYY');
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
                'currentMonthRevenue' => $currentMonthRevenue,
                'previousMonthRevenue' => $previousMonthRevenue,
                'chartLabels' => $chartLabels,
                'chartData' => $chartData,
            ], $this->setActive('dashboard'), $this->setActive('dashboard'))
        );
    }

}