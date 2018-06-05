<?php

namespace App\Http\Controllers\Manages;

use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;

class CouponController extends CommonController
{
    public function index()
    {
        return view('coupons/index',[
           'active' => 'coupon'
        ]);
    }
}
