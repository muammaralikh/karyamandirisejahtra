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
        $now = Carbon::now();
        $totalProduk = Produk::count();
        $totalKategori = Kategori::count();
        $totalUser = User::count();
        $totalPesanan = Order::count();
        $totalPendapatan = Order::where('status', 'completed')->sum('total');

        $currentMonthRevenue = Order::where('status', 'completed')
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->sum('total');

        $previousMonth = $now->copy()->subMonth();
        $previousMonthRevenue = Order::where('status', 'completed')
            ->whereYear('created_at', $previousMonth->year)
            ->whereMonth('created_at', $previousMonth->month)
            ->sum('total');

        $chartMonths = 6;
        $chartStepSize = 25000;
        $startDate = $now->copy()->startOfYear();
        $endDate = $startDate->copy()->addMonths($chartMonths);
        $chartPeriodLabel = $startDate->locale('id')->isoFormat('MMMM')
            . ' - '
            . $endDate->copy()->subMonth()->locale('id')->isoFormat('MMMM YYYY');

        $salesQuery = Order::where('status', 'completed')
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<', $endDate)
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

        for ($i = 0; $i < $chartMonths; $i++) {
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
                'chartMonths' => $chartMonths,
                'chartStepSize' => $chartStepSize,
                'chartPeriodLabel' => $chartPeriodLabel,
            ], $this->setActive('dashboard'), $this->setActive('dashboard'))
        );
    }

}
