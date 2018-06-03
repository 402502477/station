<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;

class MemberController extends CommonController
{
    public function index()
    {
        return view('members/index');
    }
}
