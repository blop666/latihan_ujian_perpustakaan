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
        Schema::create('peminjams', function (Blueprint $table) {
            $table->id();
            $table->string('nama_peminjam', 30);
            $table->enum('jk', ['L', 'P']);
            $table->string('alamat', 200);
            $table->string('no_telpon', 15);
            $table->string('email', 255);
            $table->string('password', 255);
            $table->enum('status', ['siswa', 'guru', 'tendik', 'umum']);
            $table->string('foto', 255);
            $table->string('nip', 20);
            $table->string('nisn', 20);
            $table->string('kelas', 15);
            $table->string('tahun_ajaran', 15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjams');
    }
};
