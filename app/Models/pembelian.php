<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pembelian extends Model
{
    protected $fillable = [
        'tgl_nota',
        'id_distributor',
        'total_bayar'
    ];

    public function detail_pembelians()
    {
        return $this->hasMany(detail_pembelian::class, 'id_pembelian', 'id');
    }

    // Relasi ke tabel distributors (Many to One)
    public function distributor()
    {
        return $this->belongsTo(distributor::class, 'id_distributor', 'id');
    }
}
