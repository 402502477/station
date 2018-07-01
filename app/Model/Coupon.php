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

    public function getDateFormat() {
        return date('Y-m-d H:i');
    }
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
        if($type == 1)
        {
            $coupon->where('id',$id)->increment('stock',$quantity);
        }
        if($type == 2)
        {
            $coupon->where('id',$id)->decrement('stock',$quantity);
        }
    }
}
