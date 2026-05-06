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
        Schema::create('detail_pembelians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pembelian');
            $table->foreign('id_pembelian')->references('id')->on('pembelians')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_buku');
            $table->foreign('id_buku')->references('id')->on('books')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('jumlah_beli')->default(0);
            $table->integer('harga_beli')->default(0);
            $table->integer('subtotal')->default(0);
            $table->timestamps();
        });
    }

    /**        
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pembelians');
    }
};
