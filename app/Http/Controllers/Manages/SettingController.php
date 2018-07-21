<?php

namespace App\Http\Controllers\Manages;

use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;

class SettingController extends CommonController
{
    public function index()
    {
        return view('settings/index',[
            'active' => 'setting'
        ]);
    }
}
