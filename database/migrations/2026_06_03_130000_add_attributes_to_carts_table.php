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
        if (Schema::hasTable('carts')) {
            Schema::table('carts', function (Blueprint $table) {
                if (!Schema::hasColumn('carts', 'attributes')) {
                    $table->json('attributes')->nullable()->after('price')->comment('JSON attributes like variant selection');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('carts')) {
            Schema::table('carts', function (Blueprint $table) {
                if (Schema::hasColumn('carts', 'attributes')) {
                    $table->dropColumn('attributes');
                }
            });
        }
    }
};
