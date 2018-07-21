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

Route::group(['middleware' => ['auth']], function () {

    Route::get('/', 'Manages\HomeController@index')->name('home');
    Route::group(['prefix' => 'Manages/auths'],function(){
        Route::get('profile/{id}','Manages\AuthController@profile');
        Route::get('logout','Manages\AuthController@logout');
    });
    Route::group(['prefix' => 'Manages/members'],function(){
        Route::get('index','Manages\MemberController@index');
        Route::get('detail/{mid}','Manages\MemberController@detail');
    });

    Route::group(['prefix' => 'Manages/coupons'],function(){
        Route::get('index','Manages\CouponController@index');
        Route::get('create','Manages\CouponController@create');
        Route::get('info/{cid}','Manages\CouponController@info');
    });

    Route::group(['prefix' => 'Manages/orders'],function(){
        Route::get('index','Manages\OrderController@index');
        Route::get('info/{oid}','Manages\OrderController@info');
    });
    Route::group(['prefix' => 'Manages/setting'],function(){
        Route::get('index','Manages\SettingController@index');
    });
});