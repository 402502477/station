<?php

namespace App\Http\Controllers\Manages;

use App\Events\MemberWasRegistration;
use App\Http\Controllers\CommonController;
use App\Model\Coupon;
use App\Model\CouponCollect;
use App\Model\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;

class MemberController extends CommonController
{
    public function index()
    {
        return view('members/index',[
            'active' => 'user'
        ]);
    }
    public function detail($mid)
    {
        $level = ['无','普卡','银卡','金卡'];
        $gender = ['未知','男','女'];
        $info = Member::find($mid);
        $info['contact'] = $info['contact']??'无';
        $info['info'] = json_decode($info['info'],true);
        $info['extend'] = json_decode($info['extend'],true);
        $info['receipt_info'] = json_decode($info['receipt_info'],true);
        $info['gender'] = $gender[$info['info']['sex']];
        $info['level_text'] = $level[$info['level']];

        return view('members/detail',[
            'active' => '',
            'info' => $info,
            'mid' => $mid
        ]);
    }
}
