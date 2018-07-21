<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\CommonController;
use App\User;
use Illuminate\Http\Request;

class AuthApiController extends CommonController
{
    public function get(Request $request)
    {
        $uid = $request->input('uid',null);
        if(empty($uid))
        {
            return ['status' => 0 ,'msg' => '获取信息失败，请刷新页面重试！'];
        }
        $user = User::find($uid);
        $user = $user -> toArray();
        $user['info'] = json_decode($user['info'],true);
        $gender = ['未知','男','女'];
        $user['info']['gender'] = $user['info']['gender'] ? $gender[1] : $gender[0];
        return ['status' => 1,'data' => $user];
    }
    public function set(Request $request)
    {
        $uid = $request -> input('uid',null);
        if(empty($uid))
        {
            return [];
        }
        $data = [
            'address' => $request -> input('address',null),
            'avatar' => $request -> input('avatar',null),
            'real_name' => $request -> input('real_name',null),
            'desc' => $request -> input('desc',null),
            'gender' => $request -> input('gender',null),
            'contact' => $request -> input('contact',null),
        ];
        $user = User::find($uid);
        $user -> info = json_encode($data);
        $res = $user -> save();
        if($res)
        {
            return ['status' => 1 ,'msg' => '更新信息成功！'];
        }
        return ['status' => 1 ,'msg' => '更新信息失败！'];
    }
}
