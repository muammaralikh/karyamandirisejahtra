<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Produk;

class Kategori extends Authenticatable
{
    protected $table = 'kategori';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id','nama', 'gambar'];
    public function produk()
    {
        return $this->hasMany(Produk::class, 'kategori_id');
    }
    
}