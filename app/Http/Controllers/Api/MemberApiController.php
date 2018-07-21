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
    public function receipt(Request $request)
    {
        $uid = 'oLKAB1bcmTVvKN7AHRdcEA9p5OiM';

        $title = $request->input('title');
        $content = $request->input('content');
        $is_default = $request->input('is_default', false)? true : false;
        $id = $request->input('id', null);

        $find = Member::where('uid', $uid)->first();
        $receipt = json_decode($find->receipt_info, true) ?? [];

        if ($is_default) {
            foreach ($receipt as $ky => &$vl) {
                $vl['is_default'] = false;
            }
        }
        if ($id !== null) {
            $receipt[$id] = ['title' => $title, 'content' => $content, 'is_default' => $is_default];

        } else {
            array_push($receipt, ['title' => $title, 'content' => $content, 'is_default' => $is_default]);
        }
        $find->receipt_info = json_encode($receipt);
        $res = $find -> save();
        if ($res)
        {
            return ['status'=>1 ,'msg' => '操作成功！'];
        }
        return ['status' => 0 ,'msg' => '操作失败！'];
    }
    public function getReceipt(Request $request)
    {
        $uid = 'oLKAB1bcmTVvKN7AHRdcEA9p5OiM';

        $find = Member::where('uid',$uid)->first();
        $receipt = json_decode($find -> receipt_info,true)??[];

        return $receipt;
    }
    public function changeBalance(Request $request)
    {
        $point = $request -> input('point',0);
        $mark = $request -> input('mark');
        $mid = $request -> input('mid');

        Validator::make(['point' => $point,'mark'=>$mark],[
            'point' => 'required|numeric',
            'mark' => 'required',
        ])->validate();


        $res = Member::find($mid);
        $balance = $res -> balance;
        if($mark == 'plus')
        {
            $balance = $balance + $point;
        }
        if($mark == 'less')
        {
            $balance = $balance - $point;
            if($balance < 0)
            {
                return [
                    'status' => 0,
                    'msg' => '调整后的余额不可以为0或小于0！'
                ];
            }
        }
        $res -> balance = $balance;
        $rs = $res ->save();
        if($rs)
        {
            return [
                'status' => 1,
                'msg' => '调整余额成功！',
                'balance' => $res -> balance
            ];
        }
        return [
            'status' => 1,
            'msg' => '调整余额失败！'
        ];

    }
}
