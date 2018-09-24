<?php
use Illuminate\Contracts\Routing\Registrar as RouteRegisterContract;
use Illuminate\Support\Facades\Route;
Route::group([
    'middleware' => [
        'admin',
    ],
], function (RouteRegisterContract $route) {
    Route::get('/admin', 'HomeController@index');
    Route::get('/loginOut', 'HomeController@loginOut');
    Route::get('/home/pwd', 'HomeController@pwd');
    Route::post('/home/pwdSave', 'HomeController@save');

    Route::get('/staff', 'StaffController@index');
    Route::get('/staff/add', 'StaffController@add');
    Route::post('/staff/save', 'StaffController@save');
    Route::get('/staff/edit/{id}/{act}', 'StaffController@edit')->where(['id' => '^[0-9]+', 'act' => '^[browse|edit]+']);
    Route::get('/staff/pageData', 'StaffController@pageData');
    Route::get('/staff/deleteStaff/{id}', 'StaffController@deleteStaff')->where(['id' => '^[0-9]+']);
    Route::get('/staff/setJob/{id}', 'StaffController@set')->where(['id' => '^[0-9]+']);
    Route::post('/staff/setSave', 'StaffController@setSave');
    Route::post('/staff/upload', 'StaffController@upload');
    Route::get('/staff/file', 'StaffController@file');

    Route::get('/job', 'JobController@index');
    Route::get('/job/add', 'JobController@add');
    Route::post('/job/save', 'JobController@save');
    Route::get('/job/edit/{id}/{act}', 'JobController@edit')->where(['id' => '^[0-9]+', 'act' => '^[browse|edit]+']);
    Route::get('/job/pageData', 'JobController@pageData');
    Route::get('/job/deleteJob/{id}', 'JobController@deleteJob')->where(['id' => '^[0-9]+']);
    Route::get('/job/set/{id}', 'JobController@set')->where(['id' => '^[0-9]+']);
    Route::post('/job/setSave', 'JobController@setSave');

    Route::get('/func', 'FuncController@index');
    Route::get('/func/pageData', 'FuncController@pageData');
    Route::get('/func/add', 'FuncController@add');
    Route::post('/func/save', 'FuncController@save');
    Route::get('/func/edit/{id}/{act}', 'FuncController@edit')->where(['id' => '^[a-zA-Z]+', 'act' => '^[browse|edit]+']);
    Route::get('/func/deleteFunc/{id}', 'FuncController@deleteKey')->where(['id' => '^[a-zA-Z]+']);
    Route::get('/func/set/{key}', 'FuncController@set')->where(['key' => '^[a-zA-Z]+']);
    Route::post('/func/setSave', 'FuncController@setSave');

    Route::get('/menu', 'MenuController@index');
    Route::get('/menu/pageData', 'MenuController@pageData');
    Route::post('/menu/childMenu', 'MenuController@childMenu');
    Route::get('/menu/add/{id}', 'MenuController@add')->where(['id' => '^[0-9]+']);
    Route::get('/menu/edit/{id}/{act}', 'MenuController@edit')->where(['id' => '^[0-9]+', 'act' => '^[browse|edit]+']);
    Route::get('/menu/deleteMenu/{id}', 'MenuController@deleteMenu')->where(['id' => '^[0-9]+']);
    Route::post('/menu/save', 'MenuController@save');

    Route::get('/article', 'ArticleController@index');
    Route::get('/article/pageData', 'ArticleController@pageData');
    Route::get('/article/add', 'ArticleController@add');
    Route::get('/article/edit/{id}/{act}', 'ArticleController@edit')->where(['id' => '^[0-9]+', 'act' => '^[browse|edit]+']);
    Route::get('/article/deleteArticle/{id}', 'ArticleController@deleteArticle')->where(['id' => '^[0-9]+']);
    Route::post('/article/save', 'ArticleController@save');
    Route::get('/article/type', 'ArticleController@type');
    Route::get('/article/typeData', 'ArticleController@typeData');
    Route::post('/article/typeSave', 'ArticleController@typeSave');
    Route::get('/article/deleteArticleType/{id}', 'ArticleController@deleteArticleType')->where(['id' => '^[1-9]+']);

    Route::get('/slide', 'SlideController@index');
    Route::get('/slide/pageData', 'SlideController@pageData');
    Route::get('/slide/add', 'SlideController@add');
    Route::get('/slide/edit/{id}/{act}', 'SlideController@edit')->where(['id' => '^[0-9]+', 'act' => '^[browse|edit]+']);
    Route::get('/slide/deleteSlide/{id}', 'SlideController@deleteSlide')->where(['id' => '^[0-9]+']);
    Route::post('/slide/save', 'SlideController@save');
    Route::get('/slide/type', 'SlideController@type');
    Route::get('/slide/typeData', 'SlideController@typeData');
    Route::post('/slide/typeSave', 'SlideController@typeSave');
    Route::get('/slide/deleteSlideType/{id}', 'SlideController@deleteSlideType')->where(['id' => '^[1-9]+']);
});
