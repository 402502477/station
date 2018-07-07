<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';

    protected $guarded = [];

    const CREATED_AT = 'create_at';

    const UPDATED_AT = 'update_at';

    const DELETED_AT = 'delete_at';


    public function getDateFormat()
    {
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

    public function member()
    {
        return $this->belongsTo('App\Model\Member', 'mid');
    }
}
