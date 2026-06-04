<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('produk')) {
            Schema::table('produk', function (Blueprint $table) {
                if (!Schema::hasColumn('produk', 'berat')) {
                    $table->integer('berat')->default(0)->after('stok')->comment('Berat produk dalam gram');
                }
                if (!Schema::hasColumn('produk', 'varian')) {
                    $table->text('varian')->nullable()->after('berat')->comment('Varian produk, pisahkan dengan koma');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('produk')) {
            Schema::table('produk', function (Blueprint $table) {
                if (Schema::hasColumn('produk', 'berat')) {
                    $table->dropColumn('berat');
                }
                if (Schema::hasColumn('produk', 'varian')) {
                    $table->dropColumn('varian');
                }
            });
        }
    }
};
