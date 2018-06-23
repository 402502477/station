<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController extends Controller
{
    protected function toApi($var)
    {
        echo json_encode($var);
    }
    protected function toJson($var):string
    {
        return json_encode($var);
    }
    protected function rangeTimeToInt(string $string)
    {
        $times = explode(' - ',$string);
        foreach ($times as &$vl)
        {
            $vl = strtotime($vl);
        }
        return $times;
    }
}
