<?php

namespace App\Http\Controllers\Api;

use App\Model\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberApiController extends Controller
{
    public function getMembers()
    {
        $list = Member::all();
        dd($list);
    }
}
