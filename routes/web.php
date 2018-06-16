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

Route::get('/', 'Manages\HomeController@index')->name('home');

Route::group(['prefix' => 'Manages/members'],function(){
    Route::get('index','Manages\MemberController@index');
    Route::get('detail/{uid}','Manages\MemberController@detail');
});

Route::group(['prefix' => 'Manages/coupons'],function(){
    Route::get('index','Manages\CouponController@index');
});

Route::group(['prefix' => 'Manages/orders'],function(){
    Route::get('index','Manages\OrderController@index');
});