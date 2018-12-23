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
    Route::get('/homeBottomNav','HomeController@bottomNav');
    Route::get('/homeMiddleNav','HomeController@MiddleNav');
    Route::get('/homeShopList','HomeController@homeShopList');
    Route::get('/homeGoods','HomeController@goodsList');
    Route::get('/shopList','HomeController@shopList');
    Route::get('/searchGoods','HomeController@searchGoods');
    Route::get('/shopDetail','HomeController@shopDetail');
    Route::get('/market/slide','HomeController@marketSlide');

    Route::get('/goods/detail','GoodsController@detail');
    Route::get('/goods/addCollection','GoodsController@addCollection');
    Route::get('/goods/cancelCollection','GoodsController@cancelCollection');
    
});