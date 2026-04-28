<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Produk;

class Kategori extends Model
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