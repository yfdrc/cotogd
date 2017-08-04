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

// 需要账户登录验证才能操作
Route::group(['middleware' => 'auth'], function () {
    Route::group(['namespace' => 'Tools'], function () {
        Route::resource('delsel', 'DelselController');
        Route::resource('upload', 'UploadController');
    });

    Route::group(['namespace' => 'Tongji'], function () {
        Route::resource('tjmake', 'TjmakeController');
        Route::resource('tjkouke', 'KoukeController');
        Route::put('tjkouke', 'KoukeController@index');
    });

    Route::group(['namespace' => 'Jcsj'], function () {
        Route::resource('jiazhang', 'JiazhangController');
        Route::resource('xueyuan', 'XueyuanController');
        Route::resource('xieyi', 'XieyiController');
        Route::resource('kouke', 'KoukeController');
        Route::put('jiazhang', 'JiazhangController@index');
        Route::put('xueyuan', 'XueyuanController@index');
        Route::put('xieyi', 'XieyiController@index');
        Route::put('kouke', 'KoukeController@index');
    });

    Route::group(['namespace' => 'Xtgl'], function () {
        Route::resource('dianpu', 'DianpuController');
        Route::resource('user', 'UserController');
        Route::resource('yonggong', 'YonggongController');
        Route::resource('kecheng', 'KechengController');
        Route::put('yonggong', 'YonggongController@index');
        Route::put('kecheng', 'KechengController@index');
    });

    Route::group(['namespace' => 'Temp'], function () {
        Route::resource('tempyonggong', 'YonggongController');
        Route::resource('tempkecheng', 'KechengController');
        Route::resource('tempjiazhang', 'JiazhangController');
        Route::resource('tempxueyuan', 'XueyuanController');
        Route::resource('tempxieyi', 'XieyiController');
        Route::resource('tempkouke', 'KoukeController');
        Route::put('tempyonggong', 'YonggongController@index');
        Route::put('tempkecheng', 'KechengController@index');
        Route::put('tempjiazhang', 'JiazhangController@index');
        Route::put('tempxueyuan', 'XueyuanController@index');
        Route::put('tempxieyi', 'XieyiController@index');
        Route::put('tempkouke', 'KoukeController@index');
    });

    Route::group(['namespace' => 'Sjdr'], function () {
        Route::resource('createform', 'FormController');
        Route::resource('excelTodb', 'ExcelController');

        Route::resource('yssjzbjz', 'YssjzbjzController');
        Route::resource('yssjzbxy', 'YssjzbxyController');
        Route::resource('yssjkkb', 'YssjkkbController');
        Route::put('yssjzbjz', 'YssjzbjzController@index');
        Route::put('yssjzbxy', 'YssjzbxyController@index');
        Route::put('yssjkkb', 'YssjkkbController@index');
    });
});

Route::group(['namespace' => 'Auth'], function () {
    // 需要账户guest才能操作
    Route::group(['middleware' => 'guest'], function () {
        Route::get('auth/login', 'LoginController@showLoginForm')->name('login');
        Route::post('auth/login', 'LoginController@login')->name('postLogin');

        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'ResetPasswordController@reset');
    });
// 需要账户登录验证才能操作
    Route::group(['middleware' => 'auth'], function () {
        Route::get('auth/logout', 'LoginController@logout')->name('getLogout');
    });
});

Route::group(['namespace' => 'Home'], function () {
// 不管登录与否都能操作
    Route::get('/', 'HomeController@index')->name('getHome');
    Route::get('/home', 'HomeController@index')->name('getHome');
    Route::get('contact', 'HomeController@contact')->name('getContact');
    Route::get('about', 'HomeController@about')->name('getAbout');
});


Route::group(['namespace' => 'Wechat'], function () {
    Route::any('wechat', 'wechatController@index');

    Route::group(['namespace' => 'Api'], function () {
//        Route::resource('wechatshow', 'showmenuController');
        Route::resource('wechatapiuser', 'userController');
        Route::resource('wechatapigroup', 'usergroupController');
        Route::resource('wechatapiqr', 'qrcodeController');
        Route::resource('wechatapimenu', 'menuController');
        Route::resource('wechatapicast', 'broadcastController');
        Route::resource('wechatapinotice', 'noticeController');
        Route::resource('wechatapitag', 'usertagController');
    });
});


Route::group(['namespace' => 'Mobile'], function () {
    Route::resource('/example', 'ExampleController');
});


Route::get('/drc', function () {  Artisan::call('drc:initdb'); });
