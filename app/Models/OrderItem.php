<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'qty',
        'price',
        'attributes',
        'weight',
        'sku'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'qty' => 'integer',
        'attributes' => 'array',
        'weight' => 'decimal:2'
    ];

    // Relasi dengan Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi dengan Product
    public function product()
    {
        return $this->belongsTo(Produk::class);
    }

    // Scope untuk filter berdasarkan order
    public function scopeByOrder($query, $orderId)
    {
        return $query->where('order_id', $orderId);
    }

    // Scope untuk filter berdasarkan product
    public function scopeByProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    // Aksesor untuk subtotal
    public function getSubtotalAttribute()
    {
        return $this->qty * $this->price;
    }

    // Aksesor untuk formatted subtotal
    public function getFormattedSubtotalAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    // Aksesor untuk formatted price
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    // Aksesor untuk total weight
    public function getTotalWeightAttribute()
    {
        return $this->weight * $this->qty;
    }

    // Aksesor untuk attributes text
    public function getAttributesTextAttribute()
    {
        if (empty($this->attributes) || !is_array($this->attributes)) {
            return null;
        }
        
        $texts = [];
        foreach ($this->attributes as $key => $value) {
            $texts[] = ucfirst($key) . ': ' . $value;
        }
        
        return implode(', ', $texts);
    }

    // Method untuk get product image
    public function getProductImageAttribute()
    {
        if ($this->product && $this->product->gambar) {
            return asset('storage/' . $this->product->gambar);
        }
        
        return asset('assets/images/product-default.jpg');
    }

    // Method untuk get product slug
    public function getProductSlugAttribute()
    {
        return $this->product ? $this->product->slug : null;
    }

    // Method untuk get product URL
    public function getProductUrlAttribute()
    {
        if ($this->product) {
            return route('produk.show', $this->product->slug);
        }
        
        return '#';
    }

    // Method untuk update quantity
    public function updateQuantity($qty)
    {
        if ($qty < 1) {
            throw new \Exception('Quantity must be at least 1');
        }
        
        $this->qty = $qty;
        $this->save();
        
        // Update order total
        $this->order->update([
            'subtotal' => $this->order->items->sum('subtotal'),
            'total' => $this->order->items->sum('subtotal') + $this->order->shipping_cost
        ]);
        
        return $this;
    }

    // Method untuk cek apakah product masih tersedia
    public function isProductAvailable()
    {
        if (!$this->product) {
            return false;
        }
        
        // Cek jika produk masih aktif
        if (isset($this->product->is_active) && !$this->product->is_active) {
            return false;
        }
        
        // Cek stok jika ada
        if (isset($this->product->stok) && $this->product->stok < $this->qty) {
            return false;
        }
        
        return true;
    }

    // Method untuk refund item (jika dibatalkan)
    public function refund()
    {
        // Kembalikan stok jika ada
        if ($this->product && isset($this->product->stok)) {
            $this->product->increment('stok', $this->qty);
        }
        
        return $this;
    }
}
