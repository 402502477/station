<?php

namespace App\Listeners;

use App\Events\MemberWasRegistration;
use App\Model\Coupon;
use App\Model\CouponCollect;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendCouponToNewMember
{
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
     * @param  MemberWasRegistration  $event
     * @return void
     */
    public function handle(MemberWasRegistration $event)
    {
        $mid = $event -> fetchUserId();
        $uid = $event -> fetchOpenId();
        $this->sendCoupon($mid,$uid);
    }

    private function sendCoupon(int $user_id,string $uid)
    {
        $where = [
            'status' => 1,
            'send_type' => 1
        ];
        $list = Coupon::where($where)->get();
        $coupon_id = [];
        foreach ($list as $ky => $vl)
        {
            $time_limit = json_decode($vl['time_limit'],true);
            if(empty(is_array($time_limit)))
            {
                continue;
            }
            if($time_limit[1]<=time())
            {
                continue;
            }
            $coupon_id[] = $vl['id'];
        }

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
                add_service_log('新会员发放优惠券成功！',LOG_TYPE_NORMAL,[['卡券ID','用户ID'],[$vl,$user_id]]);
                continue;
            }
            add_service_log('新会员发放优惠券失败！',LOG_TYPE_DANGER,[['卡券ID','用户ID'],[$vl,$user_id]]);
        }
    }

}
