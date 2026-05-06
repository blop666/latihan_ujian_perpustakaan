<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class detail_pembelian extends Model
{
    protected $guarded = ['id'];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'id_pembelian');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'id_buku');
    }
}
