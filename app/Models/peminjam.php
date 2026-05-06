<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class peminjam extends Authenticatable
{
    protected $table = 'peminjams';
    use Notifiable;

    protected $fillable = [
        'nama_peminjam',
        'jk',
        'alamat',
        'no_telpon',
        'email',
        'password',
        'status',
        'foto',
        'nip',
        'nisn',
        'kelas',
        'tahun_ajaran',

    ];

    protected $hidden = [
        'password'
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function peminjaman()
    {
        return $this->hasMany(peminjaman::class);
    }

    
}
