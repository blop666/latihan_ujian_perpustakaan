<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class peminjaman extends Model
{
    protected $fillable = [
        'tgl_pinjam',
        'total_pinjam',
        'total_denda',
        'id_peminjam'
        
    ];

    public function peminjam() {
        return $this->belongsTo(peminjam::class, 'id_peminjam', 'id');
    }

    public function detail_peminjaman() {
        return $this->hasMany(detail_peminjaman::class, 'id_peminjaman', 'id');
    }

    
}
