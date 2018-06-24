<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\CommonController;
use App\Model\Coupon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CouponApiController extends CommonController
{
    protected $status = ['已删除','正常','过期','无库存'];
    protected $discount_type = [ 1 => '￥', 2 => '%'];

    public function get(Request $request,$id = null)
    {
        $wh = [];
        $skip = $request -> input('skip',0);
        $take = $request -> input('take',10);
        $select = ['id','title','promotions_detail','time_limit','status','create_at','extend'];

        $datum = Coupon::where($wh)->select($select)->orderBy('create_at','desc')->skip($skip)->take($take)->get();
        foreach ($datum as &$vl)
        {
            $extend = json_decode($vl['extend'],true);
            $promotions = json_decode($vl['promotions_detail'],true);
            $time_limit = json_decode($vl['time_limit'],true);
            $vl['stock'] = $extend['stock'];
            $vl['discount'] = '-'.$promotions['point'].$this->discount_type[$promotions['type']];
            $vl['status_text'] = $this->status[$vl['status']];
            if(is_array($time_limit))
            {
                $vl['time_limit'] = date('Y-m-d H:i:s',$time_limit[0]) . ' - ' .date('Y-m-d H:i:s',$time_limit[1]);
            }else{
                $vl['time_limit'] = $time_limit.'天';
            }
        }
        return $this->toApi($datum);
    }
    public function create(Request $request)
    {
        $data = $request->input();

        Validator::make($data,[
            'title' => 'required|string|max:20|unique:coupon',
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
            'promotions_detail' => $this->toJson([
                'type' => $data['discount_type'],
                'point' => $data['discount']
            ]),
            'time_limit' => $this->toJson($data['deadline']),
            'extend' => $this->toJson($data),
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
