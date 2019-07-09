<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TahunAkademik extends Model
{
    public $table = 't_tahun_akademik';
    public $fillable = ['tahun_akademik', 'status'];
}
