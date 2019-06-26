<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Model;


class Skeleton extends Model
{
    public $table = 'skeleton';

    public $fillable = ['tanggal', 'judul', 'deskripsi', 'gambar', 'slug'];
    public $dates = ['tanggal'];
    public $dateFormat = 'd F Y';

    public function getDeskripsiAttribute()
    {
        $cdn = env('CDN_URL');
        $deskripsi = str_replace($cdn, url('uploads'), $this->attributes['deskripsi']);
        return $deskripsi;
    }

    public function getGambarFileAttribute()
    {
        $cdn = env('CDN_URL') . '/';
        $gambar = str_replace($cdn, '', $this->gambar);

        if (\Storage::exists($gambar)) {
            return url('uploads/' . $gambar);
        } else return url('/uploads/placeholder.png');
    }
}
