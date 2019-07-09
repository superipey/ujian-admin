<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Mahasiswa extends Authenticatable implements JWTSubject
{
    use Notifiable;

    public $table = 't_mahasiswa';
    public $fillable = ['nim', 'nama_lengkap', 'id_kelas', 'password', 'remember_token', 'id_tahun_akademik'];

    public $with = ['kelas'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function tahun_akademik()
    {
        return $this->hasOne('\App\TahunAkademik', 'id', 'id_tahun_akademik');
    }

    public function kelas()
    {
        return $this->hasOne('\App\Kelas', 'id', 'id_kelas');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
