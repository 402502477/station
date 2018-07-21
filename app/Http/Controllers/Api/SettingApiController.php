<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\CommonController;
use App\Model\CouponCollect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingApiController extends CommonController
{
    public function index(Request $request)
    {
        if(!file_exists('data/setting'))
        {
            return ['status' => 0];
        }
        $data = json_decode(file_get_contents('data/setting'),true);
        $type = $request -> input('type',null);
        if($data)
        {
            if($type) return ['status' => 1 ,'data' => $data[$type]];
            return ['status' => 1 ,'data' => $data];
        }
        return ['status' => 0];
    }

    public function get()
    {
        if(file_exists('data/setting'))
        {
            $info = file_get_contents('data/setting');
            return $info;
        }
        return [];
    }

    public function setting(Request $request)
    {
        $carousel = $request -> input('carousel',[]);
        $balance['switch'] = $request->input('balance',false)? true : false;
        $balance['limit'] = $request->input('balance_limit',0);
        $balance['point'] = $request->input('balance_point',0);
        $balance['type'] = $request->input('balance_type',0);

        Validator::make($balance,[
            'limit' => 'numeric|nullable',
            'point' => 'numeric|nullable'
        ])->validate();
        $_array = [];
        foreach ($carousel as $vl)
        {
            $_array[] = $vl;
        }
        $carousel = $_array;
        $product = $request -> input('product',[]);
        sort($product);
        $data = [
            'balance' => $balance,
            'logo_img' => $request->input('logo_img',''),
            'title' => $request->input('title',''),
            'carousel' => $carousel,
            'product' => $product
        ];
        $res = file_put_contents('data/setting',json_encode($data));
        if($res)
        {
            return [
                'status' => 1,
                'msg' => '设置保存成功！'
            ];
        }
        return [
            'status'=>0,
            'msg' => '设置保存失败，请重试！'
        ];
    }

    public function count(Request $request)
    {
        $price = $request -> input('price',null);
        $coupon_number = $request -> input('coupon_number',null);
        $product = $request -> input('product',null);

        if($coupon_number)
        {
            $coupon = CouponCollect::where('number',$coupon_number)->first();
            $promotion = json_decode($coupon->coupon['promotions_detail'],true);
            if($promotion['type'] == 1)
            {
                $price -= $promotion['point'];
            }
            if($promotion['type'] == 2)
            {
                $price -= $price*($promotion['point']*0.01);
            }
        }

        return round($price,2);

    }
}
