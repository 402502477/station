<?php

namespace App\Http\Controllers\Api;

use App\Events\EventCompletion;
use App\Events\MemberWasRegistration;
use App\Http\Controllers\CommonController;
use App\Model\Coupon;
use App\Model\CouponCollect;
use App\Model\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberApiController extends CommonController
{
    private $member_level_text = [
        '无','初级会员','中级会员','高级会员'
    ];
    private $member_status_text = [
        '无','正常','禁用'
    ];
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
        $list = Member::where($wh)->orderBy('create_at','desc')->skip($skip)->take($take)->get();
        foreach ($list as &$vl)
        {
            $vl['contact'] = $vl['contact']?? '无';
            $vl['level_text'] = $this -> member_level_text[$vl['level']];
            $vl['status_text'] = $this -> member_status_text[$vl['status']];
        }
        $count = Member::where($wh)->count();
        return $this -> toApi([
            'data' => $list,
            'skip' => $skip,
            'limit' => $take,
            'count' => $count
        ]);
    }
    public function create(Request $request)
    {
        $data = $request->input();
        $info = $this->wxGetUserInfo('oLKAB1bcmTVvKN7AHRdcEA9p5OiM');
        $data['username'] = $info['nickname'];
        Validator::make($data,[
            'username' => 'required',
        ])->validate();

        $create = [
            'uid' => $info['openid'],
            'username' => $info['nickname'],
            'info' => json_encode($info)
        ];
        $res = Member::create($create);
        if($res)
        {
            event(new EventCompletion($res->id,$info['openid'],1));
            return ['status' => 1,'msg' => '添加用户成功！'];
        }
        return ['status' => 0,'msg' => '添加用户失败！'];
    }
    public function find()
    {
        $uid = 'oLKAB1bcmTVvKN7AHRdcEA9p5OiM';
        $res = Member::where('uid',$uid)->first();
        if(empty($res))
        {
            return ['status' => 2 ,'msg' => '用户信息获取失败，请重试！'];
        }
        $gender = ['未知','男','女'];
        $res['info'] = json_decode($res['info'],true);
        $res['balance'] = number_format($res['balance'],2);
        $res['coupon_total'] = CouponCollect::where('uid',$uid)->count();
        $res['area'] = $res['info']['country'].' '.$res['info']['province'].' '.$res['info']['city'];
        $res['gender'] = $gender[$res['info']['sex']];
        return ['status' => 1 ,'data' => $res];
    }
}
