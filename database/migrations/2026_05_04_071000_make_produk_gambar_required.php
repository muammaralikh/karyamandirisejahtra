<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('produk') && Schema::hasColumn('produk', 'gambar')) {
            DB::table('produk')->whereNull('gambar')->update(['gambar' => '']);
            DB::statement('ALTER TABLE `produk` MODIFY `gambar` VARCHAR(255) NOT NULL');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('produk') && Schema::hasColumn('produk', 'gambar')) {
            DB::statement('ALTER TABLE `produk` MODIFY `gambar` VARCHAR(255) NULL');
        }
    }
};
