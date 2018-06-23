<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\CommonController;
use App\Model\Coupon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CouponApiController extends CommonController
{
    public function create(Request $request)
    {
        $data = $request->input();

        Validator::make($data,[
            'title' => 'required|string|max:20',
            'type' => 'required',
            'deadline_type' => 'required',
            'deadline' => 'required',
            'discount_type' => 'required',
            'discount' => 'required',
            'introduce' => 'required',
            'stock' => 'required'
        ])->validate();

        if($data['deadline_type'] == 'range_day') $data['deadline'] = $this -> rangeTimeToInt($data['deadline']);

        $create = [
            'title' => $data['title'],
            'describes' => $data['introduce'],
            'promotions_detail' => json_encode([
                'type' => $data['discount_type'],
                'point' => $data['discount']
            ]),
            'time_limit' => $data['deadline'],
            'extend' => json_encode($data),
            'status' => 1
        ];
        $res = Coupon::create($create);
        if($res)
        {
            return ['code' => 1,'msg' => '添加优惠券成功！'];
        }
        return ['code' => 0,'msg' => '添加优惠券失败！'];
    }
}
