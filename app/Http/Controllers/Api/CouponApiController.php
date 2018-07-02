<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\CommonController;
use App\Model\Coupon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CouponApiController extends CommonController
{
    protected $status = ['已删除','正常','关闭','无库存'];
    protected $discount_type = [ 1 => '￥', 2 => '%'];
    protected $send_type = [ 1 => '完成注册时发放' ,2 => '完成订单时发放' ];

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
        $select = ['id','title','promotions_detail','time_limit','status','create_at','extend','stock','send_type'];

        $datum = Coupon::where($wh)->select($select)->orderBy('create_at','desc')->skip($skip)->take($take)->get();
        foreach ($datum as &$vl)
        {
            $promotions = json_decode($vl['promotions_detail'],true);
            $time_limit = json_decode($vl['time_limit'],true);
            $vl['discount'] = '-'.$promotions['point'].$this->discount_type[$promotions['type']];
            $vl['status_text'] = $this->status[$vl['status']];
            if(is_array($time_limit))
            {
                $vl['time_limit'] = date('Y-m-d H:i:s',$time_limit[0]) . ' - ' .date('Y-m-d H:i:s',$time_limit[1]);
            }else{
                $vl['time_limit'] = '领取后 '.$time_limit.' 天失效';
            }
        }
        $count = Coupon::where($wh)->count();
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
        $row['send_type_text'] = $this->send_type[$row['send_type']];
        $promotions = json_decode($row['promotions_detail'],true);
        $time_limit = json_decode($row['time_limit'],true);
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
    public function stock(Request $request)
    {
        $num = $request -> input('num');
        $type = $request -> input('type');
        $id = $request -> input('id');

        if(in_array('',[$num,$type,$id])) return $this->toApi(['code'=> 0 ,'msg' =>'参数错误，请重试！']);
        $row = Coupon::find($id);
        if($type == 'plus')
        {
            $row->stock += $num;
        }
        if($type == 'down')
        {
            $row->stock -= $num;
        }
        if($row['stock'] < 0)
        {
            return ['code'=> 0 ,'msg' => '库存无法改变为负数！'];
        }
        $res = $row -> save();
        if($res)
        {
            return ['code' => 1,'msg' => '库存改变成功！'];
        }
        return ['code' => 0,'msg' => '库存改变失败！'];
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
            return $this->toApi(['code' => 1,'msg'=> '修改状态成功!','info'=>Coupon::find($id)]);
        }
        return $this->toApi(['code' => 0,'msg'=> '修改状态失败!']);

    }
    public function delete(Request $request)
    {
        $id = $request -> input('id','');
        if(empty($id))
        {
            return $this -> toApi(['code'=> 0 ,'msg' => '非法操作！']);
        }
        $res = Coupon::destroy($id);
        if($res)
        {
            return $this -> toApi(['code'=> 1 ,'msg' => '删除成功！']);
        }
        return $this -> toApi(['code'=> 1 ,'msg' => '删除失败！']);
    }
    public function create(Request $request)
    {
        $data = $request->input();

        Validator::make($data,[
            'title' => 'required|string|max:20|unique:coupon',
            'send_type' => 'required',
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
            'send_type' => $data['send_type'],
            'describes' => $data['introduce'],
            'promotions_detail' => $this->toJson([
                'type' => $data['discount_type'],
                'point' => $data['discount']
            ]),
            'time_limit' => $this->toJson($data['deadline']),
            'extend' => $this->toJson($data),
            'stock' => $data['stock'],
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
