<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    public $table = 't_kelas';
    public $fillable = ['nama_kelas', 'id_tahun_akademik'];
}
