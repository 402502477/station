<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CompleteTheOrder
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $coupon_number;
    /**
     * 订单完成事件
     * @param $coupon_number string
     * @return void
     */
    public function __construct(string $coupon_number = null)
    {
        $this -> coupon_number = $coupon_number;
    }

    public function fetchCouponNumber()
    {
        return $this->coupon_number;
    }
}
