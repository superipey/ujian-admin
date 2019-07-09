<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTAnswerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_answer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_mahasiswa');
            $table->bigInteger('id_ujian');
            $table->integer('jumlah_soal');
            $table->integer('benar');
            $table->integer('salah');
            $table->float('score');
            $table->json('answer');
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
        Schema::dropIfExists('t_answer');
    }
}
