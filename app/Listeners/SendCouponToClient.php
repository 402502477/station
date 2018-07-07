<?php

namespace App\Listeners;

use App\Events\EventCompletion;
use App\Model\Coupon;
use App\Model\CouponCollect;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendCouponToClient
{
    private $log_title = ['无','新用户注册完成发放优惠券','订单完成发放优惠券'];

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EventCompletion  $event
     * @return void
     */
    public function handle(EventCompletion $event)
    {
        $mid = $event -> fetchUserId();
        $uid = $event -> fetchOpenId();
        $type = $event -> fetchType();
        $order_number = $event -> fetchOrderNumber();
        $this->sendCoupon($mid,$uid,$type,$order_number);
    }

    private function getCoupon($type)
    {
        $where = [
            'status' => 1,
            'send_type' => $type
        ];
        $list = Coupon::where($where)->get();
        $coupon_id = [];
        foreach ($list as $ky => $vl)
        {
            $time_limit = json_decode($vl['time_limit'],true);
            if(is_array($time_limit))
            {
                if($time_limit[1]<=time()) continue;
            }

            $coupon_id[] = $vl['id'];
        }
        return $coupon_id;
    }

    private function sendCoupon(int $user_id,string $uid,int $type,$order_number)
    {

        $coupon_id = $this -> getCoupon($type);
        foreach ($coupon_id as $vl)
        {
            $res = CouponCollect::create([
                'number' => 'CN'.date('YmdHis',time()).$vl.rand(1000,9999),
                'cid' => $vl,
                'mid' => $user_id,
                'uid' => $uid
            ]);
            if($res)
            {
                $coupon = new Coupon();
                $coupon -> StockChange($vl,2);
                add_service_log($this->log_title[$type].' 成功！',LOG_TYPE_NORMAL,[['卡券ID','用户ID','订单编号'],[$vl,$user_id,$order_number??'']]);
                continue;
            }
            add_service_log($this->log_title[$type].' 失败！',LOG_TYPE_DANGER,[['卡券ID','用户ID','订单编号'],[$vl,$user_id,$order_number??'']]);
        }
    }
}
