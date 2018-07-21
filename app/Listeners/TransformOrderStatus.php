<?php

namespace App\Listeners;

use App\Events\CompleteTheOrder;
use App\Model\CouponCollect;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransformOrderStatus
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  CompleteTheOrder  $event
     * @return void
     */
    public function handle(CompleteTheOrder $event)
    {
        $number = $event->fetchCouponNumber();
        if(empty($number)) return null;
        $this -> transformStatus($number);
    }
    public function transformStatus($number)
    {
        $row = CouponCollect::where('number',$number)->first();
        $row -> status = 2;
        $res = $row -> save();
        if($res)
        {
            add_service_log('订单完成，销毁优惠券 成功！',LOG_TYPE_NORMAL,[['卡券编号','用户ID'],[$number,$row->uid]]);
            return;
        }
        add_service_log('订单完成，核销优惠券 失败！',LOG_TYPE_DANGER,[['卡券编号','用户ID'],[$number,$row->uid]]);
    }
}
