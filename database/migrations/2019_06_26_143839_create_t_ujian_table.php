<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTUjianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_ujian', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_ujian', 150);
            $table->datetime('tanggal_mulai');
            $table->datetime('tanggal_selesai');
            $table->tinyInteger('status')->default(0);
            $table->string('token', 5);
            $table->string('password', 5);
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
        Schema::dropIfExists('t_ujian');
    }
}
