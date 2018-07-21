<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\CommonController;
use App\Model\CouponCollect;
use Illuminate\Http\Request;

class CouponCollectApiController extends CommonController
{
    private $status = [
        '无','未使用','已使用','已过期'
    ];
    public function get(Request $request,$cid = null)
    {
        $wh = [];
        if($cid) $wh['cid'] = $cid;
        $search = $request -> input('search','');
        if($search)
        {
            $keywords = $request -> input('keywords','');
            $wh[] = [$search,'like','%'.$keywords.'%'];
        }
        $mid = $request -> input('mid','');
        if($mid)
        {
            $wh['mid'] = $mid;
        }

        $skip = $request -> input('skip',0);
        $take = $request -> input('take',10);
        $select = ['id','number','mid','cid','extend','status','create_at'];

        $datum = CouponCollect::where($wh)->select($select)->orderBy('create_at','desc')->skip($skip)->take($take)->get();
        foreach ($datum as &$vl)
        {
            if(empty($mid)) $vl['username'] = $vl->member['username'];
            $vl['status_text'] = $this->status[$vl['status']];
        }
        $count = CouponCollect::where($wh)->count();
        return [
            'data' => $datum,
            'skip' => $skip,
            'limit' => $take,
            'count' => $count
        ];
    }
    public function memberToSelect(Request $request)
    {
        $status = $request->input('status',1);
        $skip = $request->input('skip',0);
        $take = $request->input('take',10);

        //增加优惠券使用权限
        $uid = 'oLKAB1bcmTVvKN7AHRdcEA9p5OiM';//TODO 测试数据
        $wh [] = ['uid',$uid];
        if($status != 3)$wh [] = ['status',$status];
        $res = CouponCollect::where($wh)->skip($skip)->take($take)->orderBy('create_at','desc')->get();
        foreach ($res as $key => &$vl)
        {
            $time = json_decode($vl['coupon']['time_limit'],true);
            if($status == 1)
            {
                //删除禁用的优惠券
                if($vl['coupon']['status'] != 1)
                {
                    unset($res[$key]);
                    continue;
                }
                //判断是否在使用日期内或是否过期
                if(is_array($time))
                {
                    if(time() < $time[0] || time()> $time[1])
                    {
                        unset($res[$key]);
                        continue;
                    }
                }else{
                    if(time() > strtotime($vl['create_at']) + $time*60*60*24 )
                    {
                        unset($res[$key]);
                        continue;
                    }
                }
            }
            if($status == 3)
            {
                if(is_array($time))
                {
                    if(time() >= $time[0] && time()<= $time[1])
                    {
                        unset($res[$key]);
                        continue;
                    }
                }else{
                    if(time() <= strtotime($vl['create_at']) + $time*60*60*24 )
                    {
                        unset($res[$key]);
                        continue;
                    }
                }
            }
        }
        if(count($res) == 0)
        {
            return ['status' => 0 ,'msg'=>'暂无数据！'];
        }
        foreach ($res as $key => &$vl)
        {
            $vl['status_text'] = $this -> status[$vl['status']];
            $vl['member'] = $vl->member;
            $vl['coupon'] = $vl->coupon;
            $promotions_detail = json_decode($vl['coupon']['promotions_detail'],true);
            if($promotions_detail['type'] == 1)
            {
                $vl['price'] = $promotions_detail['point'];
            }
            if($promotions_detail['type'] == 2)
            {
                $vl['price'] = $promotions_detail['point'].'% OFF';
            }
            $time = json_decode($vl['coupon']['time_limit'],true);
            if(is_array($time))
            {
                $vl['time'] = '<p>'.date('Y-m-d',$time[0]) .'</p><p>至</p><p>'.date('Y-m-d',$time[1]).'</p>';
                continue;
            }
            $vl['time'] = date('Y-m-d',strtotime($vl['create_at'].' + '.$time.' day ')).'前';
            if($vl->member['status'] != 1)
            {
                unset($res[$key]);
            }
        }

        $count = CouponCollect::where($wh)->count();
        $pages = $count / $take;
        return ['status' => 1 ,'data' => $res ,'pages' => ceil($pages)];
    }
    public function pickerToCoupon(Request $request)
    {
        $product = $request -> input('product',null);
        $price = $request -> input('price',null);
        $uid = $request -> input('uid',null);
        $uid = 'oLKAB1bcmTVvKN7AHRdcEA9p5OiM';//TODO 测试数据

        $wh = [
            ['uid',$uid],
            ['status',1]
        ];
        $list = CouponCollect::where($wh)->orderBy('create_at','desc')->get();
        $data = [];
        foreach ($list as $key => $vl)
        {
            //删除禁用的优惠券
            if(in_array($vl['coupon']['status'],[0,2])) continue;
            //判断是否在使用日期内或是否过期
            $time = json_decode($vl['coupon']['time_limit'],true);
            if(is_array($time))
            {
                if(time() < $time[0] || time()> $time[1]) continue;
            }else{
                if(time() > strtotime($vl['create_at']) + $time*60*60*24 ) continue;
            }
            //判断是否是可用的商品
            if($vl['coupon']['object'] && $vl['coupon']['object'] != $product) continue;
            if($vl['coupon']['use_limit'] > $price) continue;
            $data[$key]['coupon'] = $vl->coupon;
            $data[$key] = $vl;
        }
        sort($data);
        if(count($data))
        {
            return ['data' => $data ,'status'=>1];
        }
        return ['data'=> [],'status'=>0];
    }
    public function info(Request $request)
    {
        $id = $request -> input('id',null);
        $info = CouponCollect::find($id);
        if($info)
        {
            $info['coupon'] = $info -> coupon;
            $info['product'] = $info -> coupon['object']?$info -> coupon['object']:'通用';
            $info['use_limit'] = $info -> coupon['use_limit']?$info -> coupon['use_limit']:'无限制';
            $time = json_decode($info -> coupon['time_limit'],true);
            if(is_array($time))
            {
                $time = date('Y-m-d',$time[0]) .' 至 '.date('Y-m-d',$time[1]);
            }else{
                $time = date('Y-m-d',strtotime($info['create_at'])+ $time*60*60*24).' 前';
            }
            $info['time'] = $time;
            $price = json_decode($info -> coupon['promotions_detail'],true);

            $promotion = '';
            if($price['type'] == 1 )
            {
                $promotion = '- '.$price['point'].' ￥';
            }
            if($price['type'] == 2 )
            {
                $promotion = '- '.$price['point'].' %';
            }

            $info['price'] = $promotion;
            return ['status' => 1 ,'data' => $info];
        }
        return ['status' => 0 ,'msg' => '无法获取优惠券信息'];
    }
}
