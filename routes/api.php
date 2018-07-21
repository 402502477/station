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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('upload', 'CommonController@upload');

Route::group(['prefix' => 'auth'],function(){
    Route::post('set','Api\AuthApiController@set');
    Route::get('get','Api\AuthApiController@get');
});

Route::group(['prefix' => 'member'],function(){
    Route::any('get','Api\MemberApiController@get');
    Route::get('create','Api\MemberApiController@create');
    Route::post('find','Api\MemberApiController@find');
    Route::post('receipt','Api\MemberApiController@receipt');
    Route::post('getReceipt','Api\MemberApiController@getReceipt');
    Route::post('changeBalance','Api\MemberApiController@changeBalance');
});
Route::group(['prefix' => 'setting'],function(){
    Route::post('index','Api\SettingApiController@index');
    Route::post('set','Api\SettingApiController@setting');
    Route::any('get','Api\SettingApiController@get');
    Route::post('count','Api\SettingApiController@count');
});
Route::group(['prefix' => 'order'],function(){
    Route::any('get','Api\OrderApiController@get');
    Route::post('create','Api\OrderApiController@create');
    Route::post('getToMember','Api\OrderApiController@getToMember');
    Route::post('keyPoint','Api\OrderApiController@keyPoint');
});
Route::group(['prefix' => 'coupon'],function(){
    Route::group(['prefix' => 'collect'],function(){
        Route::any('get/{cid?}','Api\CouponCollectApiController@get');
        Route::any('memberToSelect','Api\CouponCollectApiController@memberToSelect');
        Route::post('pickerToCoupon','Api\CouponCollectApiController@pickerToCoupon');
        Route::post('info','Api\CouponCollectApiController@info');
    });
    Route::post('create','Api\CouponApiController@create');
    Route::any('get','Api\CouponApiController@get');
    Route::post('stock','Api\CouponApiController@stock');
    Route::get('info/{id}','Api\CouponApiController@info');
    Route::get('status','Api\CouponApiController@status');
    Route::post('delete','Api\CouponApiController@delete');
});