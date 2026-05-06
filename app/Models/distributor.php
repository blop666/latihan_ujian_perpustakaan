<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class distributor extends Model
{
    protected $fillable = [
        'nama_distributor',
        'alamat',
        'no_telpon'
    ];

    public function pembelian() {
        return $this->hasOne(pembelian::class);
    }
}
