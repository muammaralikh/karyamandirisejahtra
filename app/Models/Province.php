<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name'];
    
    // Relasi ke cities
    public function cities()
    {
        return $this->hasMany(City::class);
    }
    
    // Scope untuk search
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%");
    }
}