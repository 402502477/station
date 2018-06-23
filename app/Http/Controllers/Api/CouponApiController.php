<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CouponApiController extends CommonController
{
    public function create(Request $request)
    {
        $data = $request->input();

        Validator::make($data,[
            'title' => 'required|string|max:20',
            'type' => 'required',
            'deadline_type' => 'required',
            'deadline' => 'required',
            'discount_type' => 'required',
            'discount' => 'required',
            'introduce' => 'required',
            'stock' => 'required'
        ])->validate();


        return $this->toApi($data);
    }
}
