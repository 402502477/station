<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController extends Controller
{
    function toApi($var)
    {
        echo json_encode($var);
    }
    function toAjax($var)
    {
        return json_encode($var);
    }
}
