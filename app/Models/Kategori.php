<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Produk;

class Kategori extends Model
{
    private const DEFAULT_CATEGORY_IMAGE = 'data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 480 320%27%3E%3Crect width=%27480%27 height=%27320%27 fill=%27%23f4f7f5%27/%3E%3Cpath d=%27M125 230l70-80 56 62 42-46 62 64H125z%27 fill=%27%23c7d8cd%27/%3E%3Ccircle cx=%27185%27 cy=%27122%27 r=%2728%27 fill=%27%23c7d8cd%27/%3E%3Ctext x=%2750%25%27 y=%2786%25%27 text-anchor=%27middle%27 font-size=%2724%27 fill=%27%236b7c72%27 font-family=%27Arial,sans-serif%27%3EGambar kategori%3C/text%3E%3C/svg%3E';

    protected $table = 'kategori';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id','nama', 'gambar'];
    public function produk()
    {
        return $this->hasMany(Produk::class, 'kategori_id');
    }

    public function getGambarUrlAttribute(): string
    {
        $gambar = trim((string) $this->gambar);

        if ($gambar === '') {
            return self::DEFAULT_CATEGORY_IMAGE;
        }

        if (str_starts_with($gambar, 'http://') || str_starts_with($gambar, 'https://')) {
            return $gambar;
        }

        if (str_starts_with($gambar, 'storage/')) {
            return asset($gambar);
        }

        if (str_starts_with($gambar, 'kategori/')) {
            return asset('storage/' . $gambar);
        }

        return asset('storage/kategori/' . $gambar);
    }
    
}
