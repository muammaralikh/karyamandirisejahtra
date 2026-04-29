<?php

namespace Tests\Feature;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_are_accessible(): void
    {
        $kategori = Kategori::create([
            'id' => 'K-TEST01',
            'nama' => 'Kategori Test',
            'gambar' => 'kategori/test.jpg',
        ]);

        Produk::create([
            'id' => 'P-TEST01',
            'kategori_id' => $kategori->id,
            'nama' => 'Produk Test',
            'gambar' => 'produk/test.jpg',
            'harga' => 12000,
            'deskripsi' => 'Produk untuk smoke test',
            'stok' => 5,
        ]);

        $this->get(route('home'))->assertStatus(200);
        $this->get(route('produk.showall'))->assertStatus(200);
        $this->get(route('produk.kategori', $kategori->id))->assertStatus(200);
        $this->get(route('tentang'))->assertStatus(200);
        $this->get(route('login'))->assertStatus(200);
        $this->get(route('register'))->assertStatus(200);
    }
}
