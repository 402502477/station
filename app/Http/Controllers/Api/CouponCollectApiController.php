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


        $uid = 'oLKAB1bcmTVvKN7AHRdcEA9p5OiM';//TODO 测试数据
        $wh = [
            ['uid',$uid],
            ['status',$status]
        ];
        $res = CouponCollect::where($wh)->skip($skip)->take($take)->orderBy('create_at','desc')->get();
        if(count($res) == 0)
        {
            return ['status' => 0 ,'msg'=>'暂无数据！'];
        }

        foreach ($res as &$vl)
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
        }

        $count = CouponCollect::where($wh)->count();
        $pages = $count / $take;
        return ['status' => 1 ,'data' => $res ,'pages' => ceil($pages)];
    }
}
