<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");

Route::post('/login', 'MahasiswaController@login');

Route::group(['middleware' => ['auth:api', 'jwt.verify']], function () {
    Route::get('/user', 'MahasiswaController@detail');
    Route::get('/ujian', 'UjianController@getAll');
    Route::get('/ujian/{id}', 'UjianController@getOne');
    Route::post('/ujian/{id}', 'UjianController@getSoal');
    Route::post('/ujian/submit/{id}', 'UjianController@submit');
});

Route::fallback(function () {
    return response()->json(['message' => 'Mau kemana?'], 404);
});