<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::group(['middleware' => ['auth:web']], function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::put('tahun_akademik/{id}', 'TahunAkademikController@store');
    Route::resource('tahun_akademik', 'TahunAkademikController');

    Route::put('mahasiswa/{id}', 'MahasiswaController@store');
    Route::get('mahasiswa/reset/{id}', 'MahasiswaController@reset')->name('mahasiswa.reset');
    Route::post('mahasiswa/import', 'MahasiswaController@import')->name('mahasiswa.import');
    Route::resource('mahasiswa', 'MahasiswaController');

    Route::put('atur_ujian/{id}', 'UjianController@store');
    Route::resource('atur_ujian', 'UjianController');

    Route::get('soal/{ujian_id}', 'SoalController@index');
    Route::get('soal/create/{id}', 'SoalController@create');
    Route::post('soal/{ujian_id}', 'SoalController@store');
    Route::put('soal/{ujian_id}/{id}', 'SoalController@store');
    Route::get('soal/{ujian_id}/{id}/edit', 'SoalController@edit');
    Route::delete('soal/{ujian_id}/{id}', 'SoalController@destroy');
});