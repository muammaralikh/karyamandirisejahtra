<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $rates = [
            // Kabupaten Banjarnegara - Rp 20.000
            ['district_name' => 'SUSUKAN', 'city_name' => 'KABUPATEN BANJARNEGARA', 'tarif_ongkir' => 20000],
            ['district_name' => 'PURWAREJA KLAMPOK', 'city_name' => 'KABUPATEN BANJARNEGARA', 'tarif_ongkir' => 20000],
            ['district_name' => 'MANDIRAJA', 'city_name' => 'KABUPATEN BANJARNEGARA', 'tarif_ongkir' => 20000],
            ['district_name' => 'PURWANEGARA', 'city_name' => 'KABUPATEN BANJARNEGARA', 'tarif_ongkir' => 20000],
            ['district_name' => 'BAWANG', 'city_name' => 'KABUPATEN BANJARNEGARA', 'tarif_ongkir' => 20000],
            ['district_name' => 'BANJARNEGARA', 'city_name' => 'KABUPATEN BANJARNEGARA', 'tarif_ongkir' => 20000],
            ['district_name' => 'PAGEDONGAN', 'city_name' => 'KABUPATEN BANJARNEGARA', 'tarif_ongkir' => 20000],
            ['district_name' => 'SIGALUH', 'city_name' => 'KABUPATEN BANJARNEGARA', 'tarif_ongkir' => 20000],
            ['district_name' => 'MADUKARA', 'city_name' => 'KABUPATEN BANJARNEGARA', 'tarif_ongkir' => 20000],
            ['district_name' => 'BANJARMANGU', 'city_name' => 'KABUPATEN BANJARNEGARA', 'tarif_ongkir' => 20000],
            ['district_name' => 'WANADADI', 'city_name' => 'KABUPATEN BANJARNEGARA', 'tarif_ongkir' => 20000],
            ['district_name' => 'RAKIT', 'city_name' => 'KABUPATEN BANJARNEGARA', 'tarif_ongkir' => 20000],
            ['district_name' => 'PUNGGELAN', 'city_name' => 'KABUPATEN BANJARNEGARA', 'tarif_ongkir' => 20000],
            ['district_name' => 'KARANGKOBAR', 'city_name' => 'KABUPATEN BANJARNEGARA', 'tarif_ongkir' => 20000],
            ['district_name' => 'PAGENTAN', 'city_name' => 'KABUPATEN BANJARNEGARA', 'tarif_ongkir' => 20000],
            ['district_name' => 'PEJAWARAN', 'city_name' => 'KABUPATEN BANJARNEGARA', 'tarif_ongkir' => 20000],
            ['district_name' => 'BATUR', 'city_name' => 'KABUPATEN BANJARNEGARA', 'tarif_ongkir' => 20000],
            ['district_name' => 'WANAYASA', 'city_name' => 'KABUPATEN BANJARNEGARA', 'tarif_ongkir' => 20000],
            ['district_name' => 'KALIBENING', 'city_name' => 'KABUPATEN BANJARNEGARA', 'tarif_ongkir' => 20000],
            ['district_name' => 'PANDANARUM', 'city_name' => 'KABUPATEN BANJARNEGARA', 'tarif_ongkir' => 20000],

            // Kabupaten Kebumen - Rp 20.000
            ['district_name' => 'AYAH', 'city_name' => 'KABUPATEN KEBUMEN', 'tarif_ongkir' => 20000],
            ['district_name' => 'BUAYAN', 'city_name' => 'KABUPATEN KEBUMEN', 'tarif_ongkir' => 20000],
            ['district_name' => 'PURING', 'city_name' => 'KABUPATEN KEBUMEN', 'tarif_ongkir' => 20000],
            ['district_name' => 'PETANAHAN', 'city_name' => 'KABUPATEN KEBUMEN', 'tarif_ongkir' => 20000],
            ['district_name' => 'KLIRONG', 'city_name' => 'KABUPATEN KEBUMEN', 'tarif_ongkir' => 20000],
            ['district_name' => 'BULUSPESANTREN', 'city_name' => 'KABUPATEN KEBUMEN', 'tarif_ongkir' => 20000],
            ['district_name' => 'AMBAL', 'city_name' => 'KABUPATEN KEBUMEN', 'tarif_ongkir' => 20000],
            ['district_name' => 'MIRIT', 'city_name' => 'KABUPATEN KEBUMEN', 'tarif_ongkir' => 20000],
            ['district_name' => 'BONOROWO', 'city_name' => 'KABUPATEN KEBUMEN', 'tarif_ongkir' => 20000],
            ['district_name' => 'PREMBUN', 'city_name' => 'KABUPATEN KEBUMEN', 'tarif_ongkir' => 20000],
            ['district_name' => 'PADURESO', 'city_name' => 'KABUPATEN KEBUMEN', 'tarif_ongkir' => 20000],
            ['district_name' => 'KUTOWINANGUN', 'city_name' => 'KABUPATEN KEBUMEN', 'tarif_ongkir' => 20000],
            ['district_name' => 'ALIAN', 'city_name' => 'KABUPATEN KEBUMEN', 'tarif_ongkir' => 20000],
            ['district_name' => 'PONCOWARNO', 'city_name' => 'KABUPATEN KEBUMEN', 'tarif_ongkir' => 20000],
            ['district_name' => 'KEBUMEN', 'city_name' => 'KABUPATEN KEBUMEN', 'tarif_ongkir' => 20000],
            ['district_name' => 'PEJAGOAN', 'city_name' => 'KABUPATEN KEBUMEN', 'tarif_ongkir' => 20000],
            ['district_name' => 'SRUWENG', 'city_name' => 'KABUPATEN KEBUMEN', 'tarif_ongkir' => 20000],
            ['district_name' => 'ADIMULYO', 'city_name' => 'KABUPATEN KEBUMEN', 'tarif_ongkir' => 20000],
            ['district_name' => 'KUWARASAN', 'city_name' => 'KABUPATEN KEBUMEN', 'tarif_ongkir' => 20000],
            ['district_name' => 'ROWOKELE', 'city_name' => 'KABUPATEN KEBUMEN', 'tarif_ongkir' => 20000],
            ['district_name' => 'SEMPOR', 'city_name' => 'KABUPATEN KEBUMEN', 'tarif_ongkir' => 20000],
            ['district_name' => 'GOMBONG', 'city_name' => 'KABUPATEN KEBUMEN', 'tarif_ongkir' => 20000],
            ['district_name' => 'KARANGANYAR', 'city_name' => 'KABUPATEN KEBUMEN', 'tarif_ongkir' => 20000],
            ['district_name' => 'KARANGGAYAM', 'city_name' => 'KABUPATEN KEBUMEN', 'tarif_ongkir' => 20000],
            ['district_name' => 'SADANG', 'city_name' => 'KABUPATEN KEBUMEN', 'tarif_ongkir' => 20000],
            ['district_name' => 'KARANGSAMBUNG', 'city_name' => 'KABUPATEN KEBUMEN', 'tarif_ongkir' => 20000],
        ];

        foreach ($rates as $rate) {
            $existing = DB::table('shipping_rates')
                ->where('district_name', $rate['district_name'])
                ->where('city_name', $rate['city_name'])
                ->first();

            if ($existing) {
                DB::table('shipping_rates')
                    ->where('id', $existing->id)
                    ->update([
                        'tarif_ongkir' => $rate['tarif_ongkir'],
                        'updated_at' => now(),
                    ]);
            } else {
                DB::table('shipping_rates')->insert([
                    'district_name' => $rate['district_name'],
                    'city_name' => $rate['city_name'],
                    'tarif_ongkir' => $rate['tarif_ongkir'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        DB::table('shipping_rates')
            ->whereIn('city_name', [
                'KABUPATEN BANJARNEGARA',
                'KABUPATEN KEBUMEN',
            ])
            ->delete();
    }
};
