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
Route::get('/login', 'LoginController@login');
Route::get('/captcha', 'LoginController@captcha');
Route::post('/login/sub', 'LoginController@sub');
Route::get('/login/welcome', function () {
    return view('public.welcome');
});
Route::namespace ('admin')->group(base_path('routes/admin.php'));
Route::post('/UploadImage', 'Controller@UploadImage');
Route::namespace ('front')->group(base_path('routes/front.php'));