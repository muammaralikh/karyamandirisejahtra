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
        Schema::create('produk', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('kategori_id');
            $table->string('nama');
            $table->string('gambar')->nullable();
            $table->decimal('harga', 12, 2);
            $table->text('deskripsi')->nullable();
            $table->integer('stok')->default(0);
            $table->timestamps();

            // Foreign key
            $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
