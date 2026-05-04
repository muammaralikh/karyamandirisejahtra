<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('produk') && Schema::hasColumn('produk', 'gambar')) {
            Schema::table('produk', function (Blueprint $table) {
                $table->string('gambar')->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('produk') && Schema::hasColumn('produk', 'gambar')) {
            DB::table('produk')->whereNull('gambar')->update(['gambar' => '']);

            Schema::table('produk', function (Blueprint $table) {
                $table->string('gambar')->nullable(false)->change();
            });
        }
    }
};
