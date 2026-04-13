<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('label', 50);
            $table->string('recipient_name');
            $table->string('recipient_phone', 20);
            
            // Foreign keys untuk wilayah
            $table->foreignId('province_id')->nullable()->constrained('provinces')->onDelete('set null');
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('set null');
            $table->foreignId('district_id')->nullable()->constrained('districts')->onDelete('set null');
            
            // Backup nama wilayah (jika data wilayah dihapus)
            $table->string('province_name')->nullable();
            $table->string('city_name')->nullable();
            $table->string('district_name')->nullable();
            
            $table->string('postal_code', 10);
            $table->text('street');
            $table->text('notes')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};