<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Karya Mandiri Sejahtera',
            'description' => 'Toko Lele terpercaya dengan produk berkualitas dan harga terjangkau',
            'categories' => Kategori::latest()->get(),
            'featuredProducts' => Produk::with('kategori')
                ->latest()
                ->get(),

        ];


        return view('pages.home', $data);
    }

    public function produk()
    {
        return view('pages.produk', [
            'title' => 'Daftar Produk'
        ]);
    }

    public function showProduk($id)
    {
        // Logika untuk menampilkan detail produk
        return view('pages.produk-detail', [
            'title' => 'Detail Produk'
        ]);
    }

    public function kategori()
    {
        return view('pages.kategori', [
            'title' => 'Kategori Produk'
        ]);
    }

    public function promo()
    {
        return view('pages.promo', [
            'title' => 'Promo Spesial'
        ]);
    }

    public function tentang()
    {
        return view('pages.tentang', [
            'title' => 'Tentang Kami'
        ]);
    }

    public function kontak()
    {
        return view('pages.kontak', [
            'title' => 'Kontak Kami'
        ]);
    }

    public function cart()
    {
        return view('pages.cart', [
            'title' => 'Keranjang Belanja'
        ]);
    }

    public function addToCart(Request $request)
    {
        // Logika untuk menambah ke keranjang
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    private function getFeaturedProducts()
    {
        return [
            [
                'id' => 1,
                'name' => 'Smartphone XYZ',
                'price' => 3499000,
                'image' => 'https://via.placeholder.com/300x200',
                'description' => 'Smartphone canggih dengan kamera 48MP',
                'category' => 'Elektronik',
                'rating' => 4.5
            ],
            [
                'id' => 2,
                'name' => 'Laptop ABC',
                'price' => 8999000,
                'image' => 'https://via.placeholder.com/300x200',
                'description' => 'Laptop performa tinggi untuk kerja dan gaming',
                'category' => 'Elektronik',
                'rating' => 4.7
            ],
            [
                'id' => 3,
                'name' => 'Headphone Premium',
                'price' => 1299000,
                'image' => 'https://via.placeholder.com/300x200',
                'description' => 'Suara jernih dengan noise cancellation',
                'category' => 'Audio',
                'rating' => 4.3
            ],
            [
                'id' => 4,
                'name' => 'Smart Watch',
                'price' => 2199000,
                'image' => 'https://via.placeholder.com/300x200',
                'description' => 'Pantau kesehatan dan notifikasi penting',
                'category' => 'Elektronik',
                'rating' => 4.2
            ]
        ];
    }

    private function getPromotions()
    {
        return [
            [
                'title' => 'Diskon Hingga 50%',
                'description' => 'Khusus produk elektronik bulan ini',
                'end_date' => now()->addDays(7),
                'image' => 'https://via.placeholder.com/800x300'
            ]
        ];
    }

    private function getTestimonials()
    {
        return [
            [
                'name' => 'Budi Santoso',
                'text' => 'Barang sampai dengan cepat, sesuai gambar. Recommended seller!',
                'avatar' => 'https://via.placeholder.com/50'
            ],
            [
                'name' => 'Sari Dewi',
                'text' => 'Harga kompetitif, pelayanan ramah. Pasti belanja lagi di sini.',
                'avatar' => 'https://via.placeholder.com/50'
            ],
            [
                'name' => 'Ahmad Fauzi',
                'text' => 'Pengiriman tepat waktu, produk original. Puas belanja di sini.',
                'avatar' => 'https://via.placeholder.com/50'
            ]
        ];
    }

    private function getCategories()
    {
        return [
            ['id' => 1, 'name' => 'Elektronik', 'count' => 45],
            ['id' => 2, 'name' => 'Fashion', 'count' => 120],
            ['id' => 3, 'name' => 'Rumah Tangga', 'count' => 89],
            ['id' => 4, 'name' => 'Olahraga', 'count' => 56],
            ['id' => 5, 'name' => 'Kesehatan', 'count' => 34]
        ];
    }
}