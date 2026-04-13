<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'province_id', 'name', 'type'];
    
    // Relasi ke province
    public function province()
    {
        return $this->belongsTo(Province::class);
    }
    
    // Relasi ke districts
    public function districts()
    {
        return $this->hasMany(District::class);
    }
    
    // Scope untuk search
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%");
    }
    
    // Scope untuk filter by province
    public function scopeByProvince($query, $provinceId)
    {
        return $query->where('province_id', $provinceId);
    }
}