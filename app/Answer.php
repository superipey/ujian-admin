<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public $table = 't_answer';
    public $fillable = ['id_mahasiswa', 'id_ujian', 'jumlah_soal', 'benar', 'salah', 'score', 'answer'];

    public $hidden = ['answer'];
}
