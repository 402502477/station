<?php

namespace App\Http\Controllers\Manages;

use App\Http\Controllers\CommonController;
use App\Model\CouponCollect;
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
        $status = [
            '',
            '<span class="label label-danger">未支付</span>',
            '<span class="label label-success">已付款</span>'
        ];
        $payment = [
            'WeChat' => '微信支付',
            'balance' => '余额支付'
        ];
        $row = Order::find($id);
        $row['status_text'] = $status[$row['status']];

        $promotion = json_decode($row['promotions_info'],true);
        $row['promotion'] = null;
        if($promotion['coupon_no'])
        {
            $coupon = CouponCollect::where('number',$promotion['coupon_no'])->first()->coupon;
            $coupon['promotions_detail'] = json_decode($coupon['promotions_detail'],true);
            $account = null;
            if($coupon['promotions_detail']['type'] == 1)
            {
                $account = '- '.$coupon['promotions_detail']['point'] .' ￥';
            }
            if($coupon['promotions_detail']['type'] == 2)
            {
                $account = '- '.$coupon['promotions_detail']['point'] .' %';
            }
            $row['promotion'] = [
                'id' => $coupon['id'],
                'number' => $promotion['coupon_no'],
                'title' => $coupon['title'],
                'account' => $account,
            ];
        }


        $row['payment_text'] = $payment[$row['payment']];

        return view('orders/info',[
            'member' => $row->member,
            'row' => $row,
            'active' => ''
        ]);
    }
}
