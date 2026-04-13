<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'label',
        'recipient_name',
        'recipient_phone',
        'province_id',
        'city_id',
        'district_id',
        'province_name',
        'city_name',
        'district_name',
        'postal_code',
        'street',
        'notes',
        'is_primary'
    ];

    protected $casts = [
        'is_primary' => 'boolean'
    ];

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan Province
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    // Relasi dengan City
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    // Relasi dengan District
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    // Format alamat lengkap
    public function getFullAddressAttribute()
    {
        $parts = [
            $this->street,
            $this->district_name,
            $this->city_name,
            $this->province_name
        ];
        
        $address = implode(', ', array_filter($parts));
        
        if ($this->postal_code) {
            $address .= ' ' . $this->postal_code;
        }
        
        if ($this->notes) {
            $address .= ' (Catatan: ' . $this->notes . ')';
        }
        
        return $address;
    }
    
    // Aksesor untuk nama provinsi
    public function getProvinceNameAttribute($value)
    {
        if ($this->province) {
            return $this->province->name;
        }
        return $value;
    }
    
    // Aksesor untuk nama kota
    public function getCityNameAttribute($value)
    {
        if ($this->city) {
            return $this->city->name . ($this->city->type ? ' (' . $this->city->type . ')' : '');
        }
        return $value;
    }
    
    // Aksesor untuk nama kecamatan
    public function getDistrictNameAttribute($value)
    {
        if ($this->district) {
            return $this->district->name;
        }
        return $value;
    }
}