<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\CommonController;
use App\Model\CouponCollect;
use Illuminate\Http\Request;

class CouponCollectApiController extends CommonController
{
    public function get(Request $request,$cid = null)
    {
        $status = [
            '无','未使用','已使用','禁用'
        ];
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
            $vl['status_text'] = $status[$vl['status']];
        }
        $count = CouponCollect::where($wh)->count();
        return $this->toApi([
            'data' => $datum,
            'skip' => $skip,
            'limit' => $take,
            'count' => $count
        ]);
    }
}
