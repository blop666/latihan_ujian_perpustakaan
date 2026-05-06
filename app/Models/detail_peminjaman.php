<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class detail_peminjaman extends Model
{
    protected $fillable = [
        'tgl_kembali',
        'denda_perhari',
        'jumlah_terlambat',
        'bayar_denda',
        'jumlah_pinjam',
        'keterangan',
        'status_pinjam',
        'id_peminjaman',
        'id_buku'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class, 'id_buku');
    }

    public function peminjaman() {
        return $this->belongsTo(peminjaman::class, 'id_peminjam', 'id');
    }
    
}
