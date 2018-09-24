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
Route::group(['prefix' => 'v1','namespace' => 'api','middleware'=>['miniApiCheck']],function () {
   Route::post('/login','LoginController@login');
   Route::get('/homeBanner','HomeController@banner');
});