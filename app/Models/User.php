<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Kategori;

class User extends Authenticatable
{

    protected $table = 'users';
    protected $fillable = [
        'name',
        'username',
        'role',
        'status',
        'gender',
        'password',
    ];
    protected $hidden = [
        'password',
    ];
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }
    public function getCartCountAttribute()
    {
        return $this->cart()->sum('qty');
    }
    public function getCartTotalAttribute()
    {
        return $this->cart()->get()->sum('subtotal');
    }
    // Relasi dengan Order
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permissions');
    }
    // Aksesor untuk total orders
    public function getTotalOrdersAttribute()
    {
        return $this->orders()->count();
    }

    // Aksesor untuk total spent
    public function getTotalSpentAttribute()
    {
        return $this->orders()->where('status', '!=', 'cancelled')->sum('total');
    }

    // Scope untuk user dengan order aktif
    public function scopeHasActiveOrders($query)
    {
        return $query->whereHas('orders', function ($q) {
            $q->whereIn('status', ['pending', 'processing', 'shipped']);
        });
    }

    // Method untuk get recent orders
    public function getRecentOrders($limit = 5)
    {
        return $this->orders()
            ->with('items')
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getPendingOrders()
    {
        return $this->orders()
            ->where('status', 'pending')
            ->latest()
            ->get();
    }

    public function getCompletedOrders()
    {
        return $this->orders()
            ->whereIn('status', ['delivered'])
            ->latest()
            ->get();
    }


}
