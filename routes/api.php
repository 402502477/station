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
Route::get('/member','Api\MemberApiController@getMembers');

Route::group(['prefix' => 'coupon'],function(){
    Route::post('create','Api\CouponApiController@create');
    Route::any('get/{id?}','Api\CouponApiController@get');
    Route::post('delete','Api\CouponApiController@delete');
});