<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Kategori;

class Produk extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'produk';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'nama',
        'gambar',
        'kategori_id',
        'harga',
        'deskripsi',
    ];
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
    // Relasi dengan OrderItem
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Aksesor untuk total sold
    public function getTotalSoldAttribute()
    {
        return $this->orderItems()
            ->whereHas('order', function ($q) {
                $q->where('status', '!=', 'cancelled');
            })
            ->sum('qty');
    }

    // Aksesor untuk total revenue
    public function getTotalRevenueAttribute()
    {
        return $this->orderItems()
            ->whereHas('order', function ($q) {
                $q->where('status', '!=', 'cancelled');
            })
            ->get()
            ->sum('subtotal');
    }

    // Method untuk get best selling products
    public static function getBestSelling($limit = 10)
    {
        return self::withCount([
            'orderItems as total_sold' => function ($query) {
                $query->select(DB::raw('SUM(qty)'))
                    ->whereHas('order', function ($q) {
                        $q->where('status', '!=', 'cancelled');
                    });
            }
        ])
            ->orderBy('total_sold', 'desc')
            ->limit($limit)
            ->get();
    }
    public function updateStockAfterOrder($qty)
    {
        if ($this->stock !== null) {
            if ($this->stock < $qty) {
                throw new \Exception('Insufficient stock');
            }

            $this->decrement('stock', $qty);
        }

        return $this;
    }
    public function restoreStock($qty)
    {
        if ($this->stock !== null) {
            $this->increment('stock', $qty);
        }

        return $this;
    }


}
