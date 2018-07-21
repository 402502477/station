<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CouponCollect extends Model
{
    use SoftDeletes;

    protected $table = 'coupon_collect';

    protected $guarded = [];

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

    public function member()
    {
        return $this->belongsTo('App\Model\Member', 'mid');
    }

    public function coupon()
    {
        return $this->belongsTo('App\Model\Coupon','cid');
    }
}
