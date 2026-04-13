<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'produk_id',
        'qty',
        'price',
        'attributes'
    ];

    protected $casts = [
        'attributes' => 'array',
        'price' => 'decimal:2'
    ];

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan Product (perhatikan nama model jika 'Produk')
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    // Accessor untuk subtotal
    public function getSubtotalAttribute()
    {
        return $this->qty * $this->price;
    }

    // Method untuk format subtotal
    public function getFormattedSubtotalAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }
}