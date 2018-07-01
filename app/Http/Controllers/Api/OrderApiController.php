<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\CommonController;
use App\Model\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderApiController extends CommonController
{
    public function get(Request $request)
    {
        $wh = [];
        $search = $request -> input('search','');
        if($search)
        {
            $keywords = $request -> input('keywords','');
            $wh[] = [$search,'like','%'.$keywords.'%'];
        }

        $skip = $request -> input('skip',0);
        $take = $request -> input('take',10);
        //$select = ['id','title','promotions_detail','time_limit','status','create_at','extend'];

        $datum = Order::where($wh)->orderBy('create_at','desc')->skip($skip)->take($take)->get();

        $count = Order::where($wh)->count();
        return $this->toApi([
            'data' => $datum,
            'skip' => $skip,
            'limit' => $take,
            'count' => $count
        ]);
    }
    public function info($id = null)
    {
        $row = Coupon::where('id',$id)->first();
        $extend = json_decode($row['extend'],true);
        $row['extend'] = $extend;
        $promotions = json_decode($row['promotions_detail'],true);
        $time_limit = json_decode($row['time_limit'],true);
        $row['stock'] = $extend['stock'];
        $row['discount'] = '-'.$promotions['point'].$this->discount_type[$promotions['type']];
        $row['status_text'] = $this->status[$row['status']];
        if(is_array($time_limit))
        {
            $row['time_limit'] = date('Y-m-d H:i:s',$time_limit[0]) . ' - ' .date('Y-m-d H:i:s',$time_limit[1]);
        }else{
            $row['time_limit'] = '领取后 '.$time_limit.' 天失效';
        }

        return $this->toApi($row);
    }
    public function status(Request $request)
    {
        $type = [1=>2 , 2=>1];
        $id = $request -> input('id');
        $row = Coupon::find($id);
        $row -> status = $type[$row->status];
        $res = $row -> save();
        if($res)
        {
            return $this->toApi(['status' => 1,'msg'=> '修改状态成功!','info'=>Coupon::find($id)]);
        }
        return $this->toApi(['status' => 0,'msg'=> '修改状态失败!']);

    }
    public function delete(Request $request)
    {
        $id = $request -> input('id','');
        if(empty($id))
        {
            return $this -> toApi(['status'=> 0 ,'msg' => '非法操作！']);
        }
        $res = Coupon::destroy($id);
        if($res)
        {
            return $this -> toApi(['status'=> 1 ,'msg' => '删除成功！']);
        }
        return $this -> toApi(['status'=> 1 ,'msg' => '删除失败！']);
    }
    public function create(Request $request)
    {
        $data = $request->input();

        Validator::make($data,[
            'original_point' => 'require',
        ])->validate();

        $order_id = 'SN'.date('YmdHis').rand(10000000,99999999);
        $create = [
            'order_id' => $order_id,
            'original_point' => $data['original_point'],
            'current_point' => $data['current_point'],
            'promotions_info' => json_encode([
                'coupon_id' => $data['coupon_id'],
                'coupon_no' => $data['coupon_no'],
                'promotions_point' => $data['promotions_point'],
            ])
        ];
        $res = Order::create($create);
        if($res)
        {
            return ['status' => 1,'msg' => '创建订单成功！'];
        }
        return ['status' => 0,'msg' => '创建订单失败！'];
    }
}
