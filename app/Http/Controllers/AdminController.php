<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $data = [
            'totalProduk' => Produk::count(),
            'totalKategori' => Kategori::count(),
            'totalUser' => User::count(),
            'totalPesanan' => Order::count(),
            'totalPendapatan' => Order::where('status', 'completed')->sum('subtotal')
                - (Order::where('status', 'completed')->count() * 10000),
        ];

        return view(
            'admin.pages.dashboard',
            array_merge($data, $this->setActive('dashboard'), $this->setActive('dashboard'))
        );
    }

}