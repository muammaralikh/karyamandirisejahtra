<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('produk') && ! Schema::hasColumn('produk', 'stok')) {
            Schema::table('produk', function (Blueprint $table) {
                $table->unsignedInteger('stok')->default(0)->after('harga');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('produk') && Schema::hasColumn('produk', 'stok')) {
            Schema::table('produk', function (Blueprint $table) {
                $table->dropColumn('stok');
            });
        }
    }
};
