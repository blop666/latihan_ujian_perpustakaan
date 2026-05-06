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
        Schema::create('detail_peminjamen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_peminjaman');
            $table->foreign('id_peminjaman')->references('id')->on('peminjamen');
            $table->foreignId('id_buku');
            $table->foreign('id_buku')->references('id')->on('books');
            $table->date('tgl_kembali');
            $table->integer('denda_perhari')->default(0);
            $table->integer('jumlah_terlambat')->default(0);
            $table->integer('bayar_denda')->default(0);
            $table->integer('jumlah_pinjam')->default(0);
            $table->enum('status_pinjam', ['P', 'K']);
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_peminjamen');
    }
};
