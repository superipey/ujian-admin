<?php

namespace App;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    public $table = 't_ujian';
    public $fillable = ['nama_ujian', 'tanggal_mulai', 'tanggal_selesai', 'status', 'token', 'password'];

    protected $dates = ['tanggal_mulai', 'tanggal_selesai'];

    public $appends = ['jumlah_soal', 'score'];

    public function setTanggalMulaiAttribute($date) {
        $this->attributes['tanggal_mulai'] = \Carbon\Carbon::createFromDate($date)->format('Y-m-d H:i:s');
    }

    public function setTanggalSelesaiAttribute($date) {
        $this->attributes['tanggal_selesai'] = \Carbon\Carbon::createFromDate($date)->format('Y-m-d H:i:s');
    }

    public function soal()
    {
        return $this->hasMany('\App\Soal', 'id_ujian', 'id');
    }

    public function getJumlahSoalAttribute()
    {
        return $this->soal()->count();
    }

    public function answer()
    {
        return $this->hasMany('\App\Answer', 'id_ujian', 'id');
    }

    public function getScoreAttribute()
    {
        $answer = $this->answer()->where('id_mahasiswa', auth()->user()->id)->orderByDesc('created_at')->first();
        if (!empty($answer)) return $answer->score;
        return '-';
    }
}
