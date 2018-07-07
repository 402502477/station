<?php

namespace App\Http\Controllers\Manages;

use App\Http\Controllers\CommonController;
use App\Model\Order;
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
        $row = Order::find($id);
        return view('orders/info',[
            'row' => $row,
            'active' => ''
        ]);
    }
}
