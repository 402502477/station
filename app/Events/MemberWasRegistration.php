<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MemberWasRegistration
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $userId;

    private $openId;


    /**
     * Create a new event instance.
     * @param int $userId
     * @param string $openId
     */
    public function __construct(int $userId, string $openId)
    {

        $this -> userId = $userId;
        $this -> openId = $openId;
    }

    public function fetchUserId()
    {
        return $this -> userId;
    }
    public function fetchOpenId()
    {
        return $this -> openId;
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
