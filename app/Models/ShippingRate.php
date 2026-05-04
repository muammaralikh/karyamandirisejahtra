<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'district_name',
        'city_name',
        'tarif_ongkir',
    ];

    protected $casts = [
        'tarif_ongkir' => 'decimal:2',
    ];

    public static function findForAddress(Address $address): ?self
    {
        $districtName = trim((string) $address->district_name);
        $cityName = trim((string) $address->city_name);

        if ($districtName !== '' && $cityName !== '') {
            $rate = self::query()
                ->where('district_name', $districtName)
                ->where('city_name', $cityName)
                ->first();

            if ($rate) {
                return $rate;
            }
        }

        if ($districtName !== '') {
            $rate = self::query()
                ->where('district_name', $districtName)
                ->whereNull('city_name')
                ->first();

            if ($rate) {
                return $rate;
            }
        }

        if ($cityName !== '') {
            return self::query()
                ->whereNull('district_name')
                ->where('city_name', $cityName)
                ->first();
        }

        return null;
    }
}
