<?php

namespace App\Http\Controllers\Manages;

use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;

class HomeController extends CommonController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home',[
            'active' => 'home'
        ]);
    }
}
