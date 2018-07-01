<?php

namespace App\Http\Controllers\Api;

use App\Events\MemberWasRegistration;
use App\Http\Controllers\CommonController;
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
            event(new MemberWasRegistration($res->id,$info['openid']));
            return ['status' => 1,'msg' => '添加用户成功！'];
        }
        return ['status' => 0,'msg' => '添加用户失败！'];
    }
}
