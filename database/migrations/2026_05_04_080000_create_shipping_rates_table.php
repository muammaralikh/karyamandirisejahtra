<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_rates', function (Blueprint $table) {
            $table->id();
            $table->string('district_name')->nullable();
            $table->string('city_name')->nullable();
            $table->decimal('tarif_ongkir', 12, 2)->default(0);
            $table->timestamps();

            $table->index(['district_name', 'city_name']);
        });

        if (Schema::hasTable('addresses')) {
            $addresses = DB::table('addresses')
                ->select('district_name', 'city_name')
                ->where(function ($query) {
                    $query->whereNotNull('district_name')
                        ->orWhereNotNull('city_name');
                })
                ->distinct()
                ->get();

            foreach ($addresses as $address) {
                DB::table('shipping_rates')->insert([
                    'district_name' => $address->district_name,
                    'city_name' => $address->city_name,
                    'tarif_ongkir' => 10000,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_rates');
    }
};
