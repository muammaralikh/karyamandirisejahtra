<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'subtotal',
        'shipping_cost',
        'total',
        'shipping_method',
        'payment_method',
        'notes',
        'recipient_name',
        'recipient_phone',
        'shipping_address',
        'province',
        'city',
        'district',
        'postal_code',
        'paid_at',
        'shipped_at',
        'delivered_at',
        'cancelled_at',
        'cancellation_reason',
        'payment_proof',
        'tracking_number',
        'estimated_delivery',
        'discount_amount',
        'tax_amount'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'estimated_delivery' => 'date'
    ];

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan OrderItem
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scope untuk filter status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk order terbaru
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Scope untuk order aktif (belum selesai)
    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['delivered', 'cancelled']);
    }

    // Scope untuk search order
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('order_number', 'like', "%{$search}%")
              ->orWhere('recipient_name', 'like', "%{$search}%")
              ->orWhere('recipient_phone', 'like', "%{$search}%");
        });
    }

    // Aksesor untuk status badge color
    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'warning',
            'processing' => 'info',
            'shipped' => 'primary',
            'delivered' => 'success',
            'cancelled' => 'danger'
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    // Aksesor untuk status text
    public function getStatusTextAttribute()
    {
        $texts = [
            'pending' => 'Menunggu Pembayaran',
            'processing' => 'Sedang Diproses',
            'shipped' => 'Dikirim',
            'delivered' => 'Selesai',
            'cancelled' => 'Dibatalkan'
        ];

        return $texts[$this->status] ?? $this->status;
    }

    // Aksesor untuk formatted date
    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d M Y, H:i');
    }

    // Aksesor untuk formatted total
    public function getFormattedTotalAttribute()
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }

    // Aksesor untuk formatted subtotal
    public function getFormattedSubtotalAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    // Aksesor untuk formatted shipping cost
    public function getFormattedShippingCostAttribute()
    {
        return 'Rp ' . number_format($this->shipping_cost, 0, ',', '.');
    }

    // Method untuk cek apakah order bisa dibatalkan
    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'processing']);
    }

    // Method untuk cek apakah order sudah dibayar
    public function isPaid()
    {
        return $this->paid_at !== null;
    }

    // Method untuk cek apakah order sudah dikirim
    public function isShipped()
    {
        return $this->shipped_at !== null;
    }

    // Method untuk cek apakah order sudah diterima
    public function isDelivered()
    {
        return $this->delivered_at !== null;
    }

    // Method untuk cek apakah order dibatalkan
    public function isCancelled()
    {
        return $this->cancelled_at !== null;
    }

    // Method untuk update status
    public function updateStatus($status, $notes = null)
    {
        $this->status = $status;
        
        switch ($status) {
            case 'processing':
                $this->paid_at = now();
                break;
            case 'shipped':
                $this->shipped_at = now();
                break;
            case 'delivered':
                $this->delivered_at = now();
                break;
            case 'cancelled':
                $this->cancelled_at = now();
                $this->cancellation_reason = $notes;
                break;
        }
        
        $this->save();
        
        // TODO: Kirim notifikasi ke user
        return $this;
    }

    // Method untuk attach tracking number
    public function attachTracking($trackingNumber, $shippingMethod = null)
    {
        $this->tracking_number = $trackingNumber;
        if ($shippingMethod) {
            $this->shipping_method = $shippingMethod;
        }
        $this->status = 'shipped';
        $this->shipped_at = now();
        $this->save();
        
        return $this;
    }

    // Method untuk mark as delivered
    public function markAsDelivered()
    {
        $this->status = 'delivered';
        $this->delivered_at = now();
        $this->save();
        
        return $this;
    }

    // Method untuk cancel order
    public function cancel($reason = null)
    {
        if ($this->status !== 'cancelled') {
            $this->releaseStock();
        }

        $this->status = 'cancelled';
        $this->cancelled_at = now();
        $this->cancellation_reason = $reason;
        $this->save();
        
        return $this;
    }

    // Method untuk upload payment proof
    public function uploadPaymentProof($path)
    {
        $this->payment_proof = $path;
        $this->save();
        
        return $this;
    }

    // Method untuk hitung jumlah item
    public function getItemsCountAttribute()
    {
        return $this->items->sum('qty');
    }

    // Method untuk get payment method text
    public function getPaymentMethodTextAttribute()
    {
        $methods = [
            'bank_transfer' => 'Transfer Bank',
            'ewallet' => 'E-Wallet',
            'cod' => 'Cash on Delivery',
            'credit_card' => 'Kartu Kredit'
        ];
        
        return $methods[$this->payment_method] ?? $this->payment_method;
    }

    public function reserveStock()
    {
        $this->loadMissing('items.product');

        foreach ($this->items as $item) {
            $product = $item->product;

            if (!$product) {
                throw new \RuntimeException("Produk untuk item {$item->id} tidak ditemukan.");
            }

            if ($product->stok < $item->qty) {
                throw new \RuntimeException("Stok {$product->nama} tidak mencukupi.");
            }

            $product->decrement('stok', $item->qty);
        }

        return $this;
    }

    public function releaseStock()
    {
        $this->loadMissing('items.product');

        foreach ($this->items as $item) {
            if ($item->product) {
                $item->product->increment('stok', $item->qty);
            }
        }

        return $this;
    }
}
