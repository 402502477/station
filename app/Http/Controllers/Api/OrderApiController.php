<?php

namespace App\Http\Controllers\Api;

use App\Events\CompleteTheOrder;
use App\Events\EventCompletion;
use App\Http\Controllers\CommonController;
use App\Model\CouponCollect;
use App\Model\Member;
use App\Model\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderApiController extends CommonController
{
    private $status = ['无','未付款','已支付'];

    public function get(Request $request)
    {
        $wh = [];
        $search = $request -> input('search','');
        if($search)
        {
            $keywords = $request -> input('keywords','');
            $wh[] = [$search,'like','%'.$keywords.'%'];
        }

        $skip = $request -> input('skip',0);
        $take = $request -> input('take',10);
        $select = ['id','mid','uid','order_id','original_point','current_point','goods_info','extend','create_at','status'];

        $datum = Order::where($wh)->select($select)->orderBy('create_at','desc')->skip($skip)->take($take)->get();
        foreach ($datum as &$vl)
        {
            if(empty($mid)) $vl['username'] = $vl->member['username'];
            $vl['status_text'] = $this->status[$vl['status']];
        }

        $count = Order::where($wh)->count();
        return [
            'data' => $datum,
            'skip' => $skip,
            'limit' => $take,
            'count' => $count
        ];
    }
    public function info($id = null)
    {
        $row = Coupon::where('id',$id)->first();
        $extend = json_decode($row['extend'],true);
        $row['extend'] = $extend;
        $promotions = json_decode($row['promotions_detail'],true);
        $time_limit = json_decode($row['time_limit'],true);
        $row['stock'] = $extend['stock'];
        $row['discount'] = '-'.$promotions['point'].$this->discount_type[$promotions['type']];
        $row['status_text'] = $this->status[$row['status']];
        if(is_array($time_limit))
        {
            $row['time_limit'] = date('Y-m-d H:i:s',$time_limit[0]) . ' - ' .date('Y-m-d H:i:s',$time_limit[1]);
        }else{
            $row['time_limit'] = '领取后 '.$time_limit.' 天失效';
        }

        return $this->toApi($row);
    }
    public function status(Request $request)
    {
        $type = [1=>2 , 2=>1];
        $id = $request -> input('id');
        $row = Coupon::find($id);
        $row -> status = $type[$row->status];
        $res = $row -> save();
        if($res)
        {
            return $this->toApi(['status' => 1,'msg'=> '修改状态成功!','info'=>Coupon::find($id)]);
        }
        return $this->toApi(['status' => 0,'msg'=> '修改状态失败!']);

    }
    public function delete(Request $request)
    {
        $id = $request -> input('id','');
        if(empty($id))
        {
            return $this -> toApi(['status'=> 0 ,'msg' => '非法操作！']);
        }
        $res = Order::destroy($id);
        if($res)
        {
            return $this -> toApi(['status'=> 1 ,'msg' => '删除成功！']);
        }
        return $this -> toApi(['status'=> 1 ,'msg' => '删除失败！']);
    }
    public function create(Request $request)
    {
        $data['coupon_no'] = $request->input('coupon');
        $data['original_point'] = $request->input('price');
        $data['current_point'] = $request->input('price');
        $data['payment'] = $request->input('payment_value');
        $data['product'] = $request->input('product');


        Validator::make($data, [
            'original_point' => 'required',
            'payment' => 'required',
        ])->validate();


        //优惠券使用信息
        if($data['coupon_no'])
        {
            $res = $this->_useCoupon($data);
            if ($res['status'] == 0)
            {
                return ['status' => 0,'msg' => $res['msg']];
            }
            $data['current_point'] = $res['currentPrice'];
        }
        //获得用户信息
        $uid = 'oLKAB1bcmTVvKN7AHRdcEA9p5OiM';//TODO 测试数据
        $member = Member::where('uid',$uid)->first();

        $order_id = 'SN'.date('YmdHis').rand(10000000,99999999);
        $create = [
            'order_id' => $order_id,
            'original_point' => $data['original_point'],
            'current_point' => $data['current_point'],
            'promotions_info' => json_encode([
                'coupon_no' => $data['coupon_no']
            ]),
            'goods_info' => $data['product'],
            'payment' => $data['payment'],
            'status' => 1,
            'uid' => $member['uid'],
            'mid' => $member['id']
        ];

        //默认余额支付状态
        $toBalance = false;
        if($data['payment'] == 'balance')
        {
            if($member->balance < $data['current_point'])
            {
                return ['status'=>0,'msg'=>'创建失败，余额不足'];
            }
            $member->balance -= $data['current_point'];
            $toBalance = $member->save();
        }
        if($toBalance) $create['status'] = 2;

        if($data['payment'] == 'weChat')
        {
            //do something to WeChat Pay
        }
        $res = Order::create($create);


        if($res)
        {
            event(new CompleteTheOrder($data['coupon_no']));
            event(new EventCompletion($member->id,$member['uid'],2,$order_id));
            // TODO
            //- 创建事件 1.改变优惠券状态 2.订单成功发放优惠券功能
            //- 事务方面 1.余额扣除
            return ['status' => 1,'msg' => '创建订单成功！'];
        }
        return ['status' => 0,'msg' => '创建订单失败！'];
    }
    public function getToMember(Request $request)
    {
        $uid = 'oLKAB1bcmTVvKN7AHRdcEA9p5OiM';//TODO 测试数据
        $wh = [
            'uid' => $uid
        ];
        $res = Order::where($wh)->get();
        if(empty(count($res)))
        {
            return ['status' => 0 ,'msg' => '暂无数据'];
        }

        foreach ($res as &$vl)
        {
            $vl['member'] = $vl->member;
            $vl['status_text'] = $this->status[$vl['status']];
        }

        return ['status' => 1 ,'data' => $res];
    }
    public function getWeeklyReport(Request $request)
    {

    }
    public function keyPoint()
    {
        //获取本周数据
        $week = Order::where('status',2)->whereBetween('create_at',$this->thisWeek)->select('current_point','create_at')->get();

        $_week = ['Monday'=>0,'Tuesday'=>0,'Wednesday'=>0,'Thursday'=>0,'Friday'=>0,'Saturday'=>0,'Sunday'=>0];
        foreach ($week as $vl)
        {
            $_week[date('l',strtotime($vl->create_at))]+= $vl->current_point;
        }
        $_week_sort = [];
        foreach ($_week as $vl)
        {
            $_week_sort[] = $vl;
        }
        $weekly = array_column($week->toArray(),'current_point');
        $weekly_count = count($weekly);
        $weekly_total = array_sum($weekly);

        //获取对比数据
        $simultaneous = Order::where('status',2)->whereBetween('create_at',$this->lastWeek)->select('current_point','create_at')->get();
        $_lastWeek = ['Monday'=>0,'Tuesday'=>0,'Wednesday'=>0,'Thursday'=>0,'Friday'=>0,'Saturday'=>0,'Sunday'=>0];
        foreach ($simultaneous as $vl)
        {
            $_lastWeek[date('l',strtotime($vl->create_at))] += $vl->current_point;
        }
        $_lastWeek_sort = [];
        foreach ($_lastWeek as $vl)
        {
            $_lastWeek_sort[] = $vl;
        }
        $simultaneous = array_column($simultaneous->toArray(),'current_point');
        $simultaneous_count = count($simultaneous);
        $simultaneous_total = array_sum($simultaneous);

        $years = Order::where('status',2)->whereBetween('create_at',$this->thisYear)->select('current_point','create_at')->get();
        $_years = ['Jan'=>0, 'Feb'=>0, 'Mar'=>0, 'Apr'=>0, 'May'=>0, 'Jun'=>0, 'Jul'=>0, 'Aug'=>0, 'Sep'=>0, 'Oct'=>0, 'Nov'=>0, 'Dec'=>0];
        foreach ($years as $vl)
        {
            $_years[date('M',strtotime($vl->create_at))] += $vl->current_point;
        }
        $_years_sort = [];
        foreach ($_years as $vl)
        {
            $_years_sort[] = $vl;
        }

        //获取关键数据
        $today = Order::where('status',2)->whereBetween('create_at',$this->today)->sum('current_point');
        $week = Order::where('status',2)->whereBetween('create_at',$this->thisWeek)->sum('current_point');
        $month = Order::where('status',2)->whereBetween('create_at',$this->thisMonth)->sum('current_point');

        return [
            'years' => $_years_sort,
            'weekly' => [
                'list' => $_week_sort,
                'count' => $weekly_count,
                'total' => $weekly_total,
                'time' => [
                    date('Y-m-d',$this->thisWeek[0]),
                    date('Y-m-d',$this->thisWeek[1])
                ]
            ],
            'comparison' => [
                'list' => $_lastWeek_sort,
                'count' => $simultaneous_count ? round($weekly_count/$simultaneous_count-1,2)*100 : 0,
                'total' => $simultaneous_total ? round($weekly_total/$simultaneous_total-1,2)*100 : 0
            ],
            'this'=>[
                'today' => $today,
                'week' => $week,
                'month' => $month
            ]
        ];
    }

    protected function _useCoupon($data)
    {
        $coupon = CouponCollect::where('number',$data['coupon_no'])->first();
        $coupon['promotions_detail'] = json_decode($coupon->coupon['promotions_detail'],true);
        $time_limit = json_decode($coupon->coupon['time_limit'],true);
        if(is_array($time_limit))
        {
            $coupon['end_time'] = $time_limit[1];
        }else{
            $coupon['end_time'] = strtotime($coupon['create_at']) + $time_limit*(60*60*24);
        }
        //判断coupon的状态
        if($coupon['end_time']<=time())
        {
            return ['status' => 0,'msg'=>'优惠券过期'];
        }
        if($coupon['status']!=1 || $coupon->coupon['status']!=1)
        {
            return ['status' => 0,'msg'=>'优惠券失效'];
        }
        //计算现价
        if($coupon['promotions_detail']['type'] == 1 )
        {
            return ['status' => 1 ,'currentPrice' => $data['original_point'] - $coupon['promotions_detail']['point']];
        }
        if($coupon['promotions_detail']['type'] == 2 )
        {
            return [
                'status' => 1 ,
                'currentPrice' => round($data['original_point'] * (0.01*$coupon['promotions_detail']['point']),2)
            ];
        }
        return null;

    }
}
