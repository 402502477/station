<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EventCompletion
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $userId;

    private $openId;

    private $type;

    private $order_number;

    /**
     * EventCompletion constructor.
     * @param int $userId
     * @param string $openId
     * @param int $type 事件类型  1 注册完成时 2 订单完成时
     * @param string $order_number
     */
    public function __construct(int $userId, string $openId , int $type ,string $order_number = null)
    {

        $this -> userId = $userId;
        $this -> openId = $openId;
        $this -> type = $type;
        $this -> order_number = $order_number;
    }

    public function fetchUserId()
    {
        return $this -> userId;
    }
    public function fetchOpenId()
    {
        return $this -> openId;
    }
    public function fetchType()
    {
        return $this -> type;
    }
    public function fetchOrderNumber()
    {
        return $this -> order_number;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    /*public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }*/
}
