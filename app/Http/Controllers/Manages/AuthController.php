<?php

namespace App\Http\Controllers\Manages;

use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Auth;

class AuthController extends CommonController
{
    function profile($id)
    {
        return view('auth/profile',[
            'active'=>'',
            'uid' => $id
        ]);
    }
    function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
