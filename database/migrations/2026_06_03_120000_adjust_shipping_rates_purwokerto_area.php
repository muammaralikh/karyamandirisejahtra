<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Area Purwokerto Banyumas (radius ≤ 5km) - Rp 5.000/kg
        $purwokertoArea = [
            'PURWOKERTO UTARA',
            'PURWOKERTO TIMUR',
            'PURWOKERTO BARAT',
            'PURWOKERTO SELATAN',
            'KEMBARAN',
            'SUMBANG',
            'SOKARAJA',
            'AJIBARANG', // termasuk area Purwokerto
        ];

        foreach ($purwokertoArea as $district) {
            DB::table('shipping_rates')->updateOrInsert(
                [
                    'district_name' => $district,
                    'city_name' => 'KABUPATEN BANYUMAS',
                ],
                [
                    'tarif_ongkir' => 5000,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        // Banyumas - area lain (> 5km) - Rp 10.000/kg (default)
        $otherBanyumas = [
            'BATURRADEN',
            'CILONGOK',
            'GUMELAR',
            'JATILAWANG',
            'KALIBAGOR',
            'KARANGLEWAS',
            'KEBASEN',
            'KEDUNG BANTENG',
            'KEMRANJEN',
            'LUMBIR',
            'PATIKRAJA',
            'PEKUNCEN',
            'PURWOJATI',
            'RAWALO',
            'SOMAGEDE',
            'SUMPIUH',
            'TAMBAK',
            'WANGON',
            'BANYUMAS',
        ];

        foreach ($otherBanyumas as $district) {
            DB::table('shipping_rates')->updateOrInsert(
                [
                    'district_name' => $district,
                    'city_name' => 'KABUPATEN BANYUMAS',
                ],
                [
                    'tarif_ongkir' => 10000,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        // Update Banjarnegara dari 20.000 ke 15.000/kg (via ekspedisi)
        DB::table('shipping_rates')
            ->where('city_name', 'KABUPATEN BANJARNEGARA')
            ->update([
                'tarif_ongkir' => 15000,
                'updated_at' => now(),
            ]);

        // Update Kebumen dari 20.000 ke 15.000/kg (via ekspedisi)
        DB::table('shipping_rates')
            ->where('city_name', 'KABUPATEN KEBUMEN')
            ->update([
                'tarif_ongkir' => 15000,
                'updated_at' => now(),
            ]);

        // Cilacap sudah 15.000/kg, tidak perlu diupdate

        // Purbalingga - pastikan 15.000/kg
        DB::table('shipping_rates')
            ->where('city_name', 'KABUPATEN PURBALINGGA')
            ->update([
                'tarif_ongkir' => 15000,
                'updated_at' => now(),
            ]);

        // Tambah Kabupaten Pemalang - Rp 15.000/kg (via ekspedisi)
        $pemalangDistricts = [
            'BELIK',
            'COMALAK',
            'KOTAKARANG',
            'MOJO',
            'PEMALANG',
            'PETARUKAN',
            'PULOSARI',
            'RANDUDONGKAL',
            'SALAMAN',
            'SIRAMPOG',
            'TAMAN',
            'TANGKESARI',
            'TANJUNGSARI',
            'ULUJAMI',
            'WARUNGASEM',
            'WATUKEBO',
        ];

        foreach ($pemalangDistricts as $district) {
            DB::table('shipping_rates')->updateOrInsert(
                [
                    'district_name' => $district,
                    'city_name' => 'KABUPATEN PEMALANG',
                ],
                [
                    'tarif_ongkir' => 15000,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }

    public function down(): void
    {
        // Revert Banjarnegara ke 20.000
        DB::table('shipping_rates')
            ->where('city_name', 'KABUPATEN BANJARNEGARA')
            ->update(['tarif_ongkir' => 20000]);

        // Revert Kebumen ke 20.000
        DB::table('shipping_rates')
            ->where('city_name', 'KABUPATEN KEBUMEN')
            ->update(['tarif_ongkir' => 20000]);

        // Revert Banyumas area Purwokerto ke 10.000
        $purwokertoArea = ['PURWOKERTO UTARA', 'PURWOKERTO TIMUR', 'PURWOKERTO BARAT', 
                          'PURWOKERTO SELATAN', 'KEMBARAN', 'SUMBANG', 'SOKARAJA', 'AJIBARANG'];
        DB::table('shipping_rates')
            ->where('city_name', 'KABUPATEN BANYUMAS')
            ->whereIn('district_name', $purwokertoArea)
            ->update(['tarif_ongkir' => 10000]);

        // Hapus Pemalang
        DB::table('shipping_rates')
            ->where('city_name', 'KABUPATEN PEMALANG')
            ->delete();
    }
};
