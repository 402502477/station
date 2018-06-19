<?php

namespace App\Http\Controllers\Manages;

use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;

class OrderController extends CommonController
{
    public function index()
    {
        return view('orders/index',[
            'active' => 'order'
        ]);
    }
    public function info($id)
    {
        return view('orders/info',[
            'active' => ''
        ]);
    }
}
