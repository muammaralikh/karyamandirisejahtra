<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $rates = [
            // Kabupaten Cilacap - Rp 15.000
            ['district_name' => 'ADIPALA', 'city_name' => 'KABUPATEN CILACAP', 'tarif_ongkir' => 15000],
            ['district_name' => 'BANTARSARI', 'city_name' => 'KABUPATEN CILACAP', 'tarif_ongkir' => 15000],
            ['district_name' => 'BINANGUN', 'city_name' => 'KABUPATEN CILACAP', 'tarif_ongkir' => 15000],
            ['district_name' => 'CILACAP SELATAN', 'city_name' => 'KABUPATEN CILACAP', 'tarif_ongkir' => 15000],
            ['district_name' => 'CILACAP TENGAH', 'city_name' => 'KABUPATEN CILACAP', 'tarif_ongkir' => 15000],
            ['district_name' => 'CILACAP UTARA', 'city_name' => 'KABUPATEN CILACAP', 'tarif_ongkir' => 15000],
            ['district_name' => 'CIMANGGU', 'city_name' => 'KABUPATEN CILACAP', 'tarif_ongkir' => 15000],
            ['district_name' => 'CIPARI', 'city_name' => 'KABUPATEN CILACAP', 'tarif_ongkir' => 15000],
            ['district_name' => 'DAYEUHLUHUR', 'city_name' => 'KABUPATEN CILACAP', 'tarif_ongkir' => 15000],
            ['district_name' => 'GANDRUNGMANGU', 'city_name' => 'KABUPATEN CILACAP', 'tarif_ongkir' => 15000],
            ['district_name' => 'JERUKLEGI', 'city_name' => 'KABUPATEN CILACAP', 'tarif_ongkir' => 15000],
            ['district_name' => 'KAMPUNG LAUT', 'city_name' => 'KABUPATEN CILACAP', 'tarif_ongkir' => 15000],
            ['district_name' => 'KARANGPUCUNG', 'city_name' => 'KABUPATEN CILACAP', 'tarif_ongkir' => 15000],
            ['district_name' => 'KAWUNGANTEN', 'city_name' => 'KABUPATEN CILACAP', 'tarif_ongkir' => 15000],
            ['district_name' => 'KEDUNGREJA', 'city_name' => 'KABUPATEN CILACAP', 'tarif_ongkir' => 15000],
            ['district_name' => 'KESUGIHAN', 'city_name' => 'KABUPATEN CILACAP', 'tarif_ongkir' => 15000],
            ['district_name' => 'KROYA', 'city_name' => 'KABUPATEN CILACAP', 'tarif_ongkir' => 15000],
            ['district_name' => 'MAJENANG', 'city_name' => 'KABUPATEN CILACAP', 'tarif_ongkir' => 15000],
            ['district_name' => 'MAOS', 'city_name' => 'KABUPATEN CILACAP', 'tarif_ongkir' => 15000],
            ['district_name' => 'NUSAWUNGU', 'city_name' => 'KABUPATEN CILACAP', 'tarif_ongkir' => 15000],
            ['district_name' => 'PATIMUAN', 'city_name' => 'KABUPATEN CILACAP', 'tarif_ongkir' => 15000],
            ['district_name' => 'SAMPANG', 'city_name' => 'KABUPATEN CILACAP', 'tarif_ongkir' => 15000],
            ['district_name' => 'SIDAREJA', 'city_name' => 'KABUPATEN CILACAP', 'tarif_ongkir' => 15000],
            ['district_name' => 'WANAREJA', 'city_name' => 'KABUPATEN CILACAP', 'tarif_ongkir' => 15000],

            // Kabupaten Banyumas - Rp 10.000
            ['district_name' => 'AJIBARANG', 'city_name' => 'KABUPATEN BANYUMAS', 'tarif_ongkir' => 10000],
            ['district_name' => 'BANYUMAS', 'city_name' => 'KABUPATEN BANYUMAS', 'tarif_ongkir' => 10000],
            ['district_name' => 'BATURRADEN', 'city_name' => 'KABUPATEN BANYUMAS', 'tarif_ongkir' => 10000],
            ['district_name' => 'CILONGOK', 'city_name' => 'KABUPATEN BANYUMAS', 'tarif_ongkir' => 10000],
            ['district_name' => 'GUMELAR', 'city_name' => 'KABUPATEN BANYUMAS', 'tarif_ongkir' => 10000],
            ['district_name' => 'JATILAWANG', 'city_name' => 'KABUPATEN BANYUMAS', 'tarif_ongkir' => 10000],
            ['district_name' => 'KALIBAGOR', 'city_name' => 'KABUPATEN BANYUMAS', 'tarif_ongkir' => 10000],
            ['district_name' => 'KARANGLEWAS', 'city_name' => 'KABUPATEN BANYUMAS', 'tarif_ongkir' => 10000],
            ['district_name' => 'KEBASEN', 'city_name' => 'KABUPATEN BANYUMAS', 'tarif_ongkir' => 10000],
            ['district_name' => 'KEDUNG BANTENG', 'city_name' => 'KABUPATEN BANYUMAS', 'tarif_ongkir' => 10000],
            ['district_name' => 'KEMBARAN', 'city_name' => 'KABUPATEN BANYUMAS', 'tarif_ongkir' => 10000],
            ['district_name' => 'KEMRANJEN', 'city_name' => 'KABUPATEN BANYUMAS', 'tarif_ongkir' => 10000],
            ['district_name' => 'LUMBIR', 'city_name' => 'KABUPATEN BANYUMAS', 'tarif_ongkir' => 10000],
            ['district_name' => 'PATIKRAJA', 'city_name' => 'KABUPATEN BANYUMAS', 'tarif_ongkir' => 10000],
            ['district_name' => 'PEKUNCEN', 'city_name' => 'KABUPATEN BANYUMAS', 'tarif_ongkir' => 10000],
            ['district_name' => 'PURWOJATI', 'city_name' => 'KABUPATEN BANYUMAS', 'tarif_ongkir' => 10000],
            ['district_name' => 'PURWOKERTO BARAT', 'city_name' => 'KABUPATEN BANYUMAS', 'tarif_ongkir' => 10000],
            ['district_name' => 'PURWOKERTO SELATAN', 'city_name' => 'KABUPATEN BANYUMAS', 'tarif_ongkir' => 10000],
            ['district_name' => 'PURWOKERTO TIMUR', 'city_name' => 'KABUPATEN BANYUMAS', 'tarif_ongkir' => 10000],
            ['district_name' => 'PURWOKERTO UTARA', 'city_name' => 'KABUPATEN BANYUMAS', 'tarif_ongkir' => 10000],
            ['district_name' => 'RAWALO', 'city_name' => 'KABUPATEN BANYUMAS', 'tarif_ongkir' => 10000],
            ['district_name' => 'SOKARAJA', 'city_name' => 'KABUPATEN BANYUMAS', 'tarif_ongkir' => 10000],
            ['district_name' => 'SOMAGEDE', 'city_name' => 'KABUPATEN BANYUMAS', 'tarif_ongkir' => 10000],
            ['district_name' => 'SUMBANG', 'city_name' => 'KABUPATEN BANYUMAS', 'tarif_ongkir' => 10000],
            ['district_name' => 'SUMPIUH', 'city_name' => 'KABUPATEN BANYUMAS', 'tarif_ongkir' => 10000],
            ['district_name' => 'TAMBAK', 'city_name' => 'KABUPATEN BANYUMAS', 'tarif_ongkir' => 10000],
            ['district_name' => 'WANGON', 'city_name' => 'KABUPATEN BANYUMAS', 'tarif_ongkir' => 10000],

            // Kabupaten Purbalingga - Rp 15.000
            ['district_name' => 'BOBOTSARI', 'city_name' => 'KABUPATEN PURBALINGGA', 'tarif_ongkir' => 15000],
            ['district_name' => 'BOJONGSARI', 'city_name' => 'KABUPATEN PURBALINGGA', 'tarif_ongkir' => 15000],
            ['district_name' => 'BUKATEJA', 'city_name' => 'KABUPATEN PURBALINGGA', 'tarif_ongkir' => 15000],
            ['district_name' => 'KALIGONDANG', 'city_name' => 'KABUPATEN PURBALINGGA', 'tarif_ongkir' => 15000],
            ['district_name' => 'KALIMANAH', 'city_name' => 'KABUPATEN PURBALINGGA', 'tarif_ongkir' => 15000],
            ['district_name' => 'KARANGANYAR', 'city_name' => 'KABUPATEN PURBALINGGA', 'tarif_ongkir' => 15000],
            ['district_name' => 'KARANGJAMBU', 'city_name' => 'KABUPATEN PURBALINGGA', 'tarif_ongkir' => 15000],
            ['district_name' => 'KARANGMONCOL', 'city_name' => 'KABUPATEN PURBALINGGA', 'tarif_ongkir' => 15000],
            ['district_name' => 'KARANGREJA', 'city_name' => 'KABUPATEN PURBALINGGA', 'tarif_ongkir' => 15000],
            ['district_name' => 'KEJOBONG', 'city_name' => 'KABUPATEN PURBALINGGA', 'tarif_ongkir' => 15000],
            ['district_name' => 'KEMANGKON', 'city_name' => 'KABUPATEN PURBALINGGA', 'tarif_ongkir' => 15000],
            ['district_name' => 'KERTANEGARA', 'city_name' => 'KABUPATEN PURBALINGGA', 'tarif_ongkir' => 15000],
            ['district_name' => 'KUTASARI', 'city_name' => 'KABUPATEN PURBALINGGA', 'tarif_ongkir' => 15000],
            ['district_name' => 'MREBET', 'city_name' => 'KABUPATEN PURBALINGGA', 'tarif_ongkir' => 15000],
            ['district_name' => 'PADAMARA', 'city_name' => 'KABUPATEN PURBALINGGA', 'tarif_ongkir' => 15000],
            ['district_name' => 'PENGADEGAN', 'city_name' => 'KABUPATEN PURBALINGGA', 'tarif_ongkir' => 15000],
            ['district_name' => 'PURBALINGGA', 'city_name' => 'KABUPATEN PURBALINGGA', 'tarif_ongkir' => 15000],
            ['district_name' => 'REMBANG', 'city_name' => 'KABUPATEN PURBALINGGA', 'tarif_ongkir' => 15000],
        ];

        foreach ($rates as $rate) {
            DB::table('shipping_rates')->updateOrInsert(
                [
                    'district_name' => $rate['district_name'],
                    'city_name' => $rate['city_name'],
                ],
                [
                    'tarif_ongkir' => $rate['tarif_ongkir'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }

    public function down(): void
    {
        DB::table('shipping_rates')
            ->whereIn('city_name', [
                'KABUPATEN CILACAP',
                'KABUPATEN BANYUMAS',
                'KABUPATEN PURBALINGGA',
            ])
            ->delete();
    }
};
