<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'city_id', 'name'];
    
    // Relasi ke city
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    
    // Scope untuk search
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%");
    }
    
    // Scope untuk filter by city
    public function scopeByCity($query, $cityId)
    {
        return $query->where('city_id', $cityId);
    }
}