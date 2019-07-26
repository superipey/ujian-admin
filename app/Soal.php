<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    public $table = 't_soal';
    public $fillable = ['id_ujian', 'pertanyaan', 'jawaban_a', 'jawaban_b', 'jawaban_c', 'jawaban_d', 'kunci_jawaban'];

    public function getPertanyaanAttribute()
    {
        $pertanyaan = $this->attributes['pertanyaan'];
//        $pertanyaan = str_replace(env('APP_URL'), env('APP_IP'), $pertanyaan);
        $pertanyaan = str_replace("http://localhost/ujian-admin/public", "https://api.ecl.somearch.site", $pertanyaan);
        return $pertanyaan;
    }
}
