<?php
use Illuminate\Contracts\Routing\Registrar as RouteRegisterContract;
use Illuminate\Support\Facades\Route;
Route::group([
    'middleware' => [
        'admin',
    ],
], function (RouteRegisterContract $route) {

    Route::get('/nav', 'NavController@index');
    Route::get('/nav/pageData','NavController@pageData');
    Route::get('/nav/add', 'NavController@add');
    Route::get('/nav/edit/{id}/{act}', 'NavController@edit')->where(['id' => '^[0-9]+', 'act' => '^[browse|edit]+']);
    Route::get('/nav/deletenav/{id}', 'NavController@deletenav')->where(['id' => '^[0-9]+']);
    Route::post('/nav/save', 'NavController@save');
    Route::get('/nav/type', 'NavController@type');
    Route::get('/nav/typeData', 'NavController@typeData');
    Route::post('/nav/typeSave', 'NavController@typeSave');
    Route::get('/nav/deletenavType/{id}', 'NavController@deletenavType')->where(['id' => '^[1-9]+']);

    Route::get('/shop', 'ShopController@index');
    Route::get('/shop/pageData','ShopController@pageData');
    Route::get('/shop/add', 'ShopController@add');
    Route::get('/shop/edit/{id}/{act}', 'ShopController@edit')->where(['id' => '^[0-9]+', 'act' => '^[browse|edit]+']);
    Route::get('/shop/deletenav/{id}', 'ShopController@deleteData')->where(['id' => '^[0-9]+']);
    Route::post('/shop/save', 'ShopController@save');
    Route::get('/shop/type', 'ShopController@type');
    Route::get('/shop/typeData', 'ShopController@typeData');
    Route::post('/shop/typeSave', 'ShopController@typeSave');
    Route::get('/shop/deleteShopType/{id}', 'ShopController@deleteShopType')->where(['id' => '^[1-9]+']);

    Route::get('/goods', 'GoodsController@index');
    Route::get('/goods/pageData', 'GoodsController@pageData');
    Route::get('/goods/add', 'GoodsController@add');
    Route::get('/goods/edit/{id}/{act}', 'GoodsController@edit')->where(['id' => '^[0-9]+', 'act' => '^[browse|edit]+']);
    Route::get('/goods/deleteData/{id}', 'GoodsController@deleteData')->where(['id' => '^[0-9]+']);
    Route::post('/goods/save', 'GoodsController@save');
    Route::get('/goods/type', 'GoodsController@type');
    Route::get('/goods/typeData', 'GoodsController@typeData');
    Route::post('/goods/typeSave', 'GoodsController@typeSave');
    Route::get('/goods/deleteGoodsType/{id}', 'GoodsController@deleteGoodsType')->where(['id' => '^[1-9]+']);

    Route::get('goods/tag', 'TagController@index');
    Route::get('goods/tag/pageData', 'TagController@pageData');
    Route::get('goods/tag/add', function () {
        return view('front.tag.add', ['action' => 'add']);
    });
    Route::get('goods/tag/edit/{id}/{act}', function ($id, $act) {
        $data['action'] = $act;
        $data['data']   = App\models\front\tag::find($id);
        return view('front.tag.add', $data);
    })->where(['id' => '^[0-9]+', 'act' => '^[browse|edit]+']);
    Route::post('goods/tag/save', 'TagController@save');
    Route::get('goods/tag/deleteData/{id}', 'TagController@deleteData')->where(['id' => '^[0-9]+']);

    Route::get('/goods/classify', 'ClassifyController@index');
    Route::get('/front/classify/pageData', 'ClassifyController@pageData');
    Route::get('/front/classify/add/{id}', 'ClassifyController@add')->where(['id' => '^[0-9]+']);
    Route::post('front/classify/save', 'ClassifyController@save');
    Route::get('/front/classify/edit/{id}/{act}', 'ClassifyController@edit')->where(['id' => '^[0-9]+', 'act' => '^[browse|edit]+']);
    Route::get('/front/classify/deleteClassify/{id}', 'ClassifyController@deleteClassify')->where(['id' => '^[0-9]+']);
    Route::post('/front/classify/childData', 'ClassifyController@childData');

});