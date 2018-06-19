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
    public function create()
    {
        return view('coupons/create',[
            'active' => '',
        ]);
    }
    public function info()
    {
        return view('coupons/info',[
            'active' => '',
        ]);
    }
}
