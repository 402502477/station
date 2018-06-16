<?php

namespace App\Http\Controllers\Manages;

use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;

class MemberController extends CommonController
{
    public function index()
    {
        return view('members/index',[
            'active' => 'user'
        ]);
    }
    public function detail($uid)
    {
        return view('members/detail',[
            'active' => '',
        ]);
    }
}
