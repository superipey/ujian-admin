<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_mahasiswa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nim', 10);
            $table->string('nama_lengkap', 150);
            $table->tinyInteger('id_kelas');
            $table->string('password', 255);
            $table->string('remember_token', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_mahasiswa');
    }
}
