<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //

    protected $fillable = [
        'judul',
        'jenis',
        'tahun_terbit',
        'penulis',
        'penerbit',
        'stok'
    ];

    public function detail_pembelian() {
        return $this->hasMany(detail_pembelian::class);
    }

    public function detail_peminjaman() {
        return $this->hasMany(detail_peminjaman::class);
    }
}
