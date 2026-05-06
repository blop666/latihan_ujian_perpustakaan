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
        Schema::create('peminjamen', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tgl_pinjam')->nullable();
            $table->unsignedBigInteger('id_peminjam');
            $table->foreign('id_peminjam')->references('id')->on('peminjams');
            $table->integer('total_pinjam')->default(0);
            $table->integer('total_denda')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};
