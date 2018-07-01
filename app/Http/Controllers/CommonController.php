<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CommonController extends Controller
{
    protected $access_token;

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

    public function __construct()
    {
        $this -> access_token = $this -> wxGetAccessToken();
    }

    /**
     * @param $url
     * @param null $data
     * @return mixed
     */
    protected function doGet($url, $data = null)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $output = curl_exec($ch);

        curl_close($ch);

        return $output;
    }

    /**
     * @param string $url
     * @param array $data
     * @param array | boolean $header
     * @return mixed
     */
    protected function doPost($url,$data = null,$header = null)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }

    /**
     * @return mixed|null
     */
    protected function wxGetAccessToken()
    {
        if(Cache::has('access_token'))
        {
            return Cache::get('access_token');
        }
        $api_url = 'https://api.weixin.qq.com/cgi-bin/token';
        $data = [
            'grant_type' => 'client_credential',
            'appid' => env('WX_APP_ID'),
            'secret' => env('WX_APP_SECRET')
        ];
        $wx_token = json_decode($this -> doGet($api_url,$data),true);
        $minutes = ($wx_token['expires_in']-50)/60;
        Cache::put('access_token',$wx_token['access_token'],$minutes);
        return $wx_token['access_token'];
    }
    protected function wxGetCode($redirect,$state=null)
    {
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize';
        $url .= '?appid='.env('WX_APP_ID').'&redirect_uri='.urlencode($redirect).'&response_type=code&scope=snsapi_userinfo&state='.$state.'#wechat_redirect';
        return json_decode($this -> doGet($url),true);
    }
    protected function wxGetOpenId($key,$code = null)
    {
        if(Cache::has($key))
        {
            return [
                'session_id' => $key,
                'open_id' => Cache::get($key)
            ];
        }
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token';
        $data = [
            'appid' => env('WX_APP_ID'),
            'secret' => env('WX_APP_SECRET'),
            'code' => $code,
            'grant_type' => 'authorization_code'
        ];
        $res = json_decode($this -> doGet($url,$data),true);
        $key = 'wx'.time().rand(10000,99999);
        Cache::put($key,$res['openid'],120);
        return [
            'session_id' => $key,
            'open_id' => $res['openid']
        ];
    }
    protected function wxGetUserInfo($open_id)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info';
        $data = [
            'access_token' => $this -> access_token,
            'openid' => $open_id
        ];
        $wx_info = json_decode($this->doGet($url,$data),true);
        return $wx_info;
    }
}
