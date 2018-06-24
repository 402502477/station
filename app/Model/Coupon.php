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
}
