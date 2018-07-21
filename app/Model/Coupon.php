<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $table = 'coupon';

    const CREATED_AT = 'create_at';

    const UPDATED_AT = 'update_at';

    const DELETED_AT = 'delete_at';

    public function freshTimestamp()
    {
        return time();
    }
    public function fromDateTime($value)
    {
        return $value;
    }

    /**
     * Coupon changes the stock
     * @param int $id
     * @param int $type 1 increment 2 decrement
     * @param int $quantity
     */
    public function StockChange(int $id, int $type = 1, int $quantity = 1)
    {
        $coupon = new Coupon();

        $info = $coupon->find($id);
        if($type == 1)
        {
            $coupon->where('id',$id)->increment('stock',$quantity);
            if($info->stock + $quantity > 0)
            {
                $info->status = 1;
                $info->save();
            }
        }
        if($type == 2)
        {
            if($info->stock - $quantity < 0)
            {
                return ['status' => 0 ,'msg' => '调整后的数量不可小于0'];
            }
            $coupon->where('id',$id)->decrement('stock',$quantity);
            $info = $coupon->find($id);
            //当库存等于0时 状态改变
            if($info->stock <= 0)
            {
                $info->status = 3;
                $info->save();
            }
        }
        $info = $coupon->find($id);
        return ['status' => 1,'msg' => '库存调整成功', 'current' => $info->stock];
    }
}
