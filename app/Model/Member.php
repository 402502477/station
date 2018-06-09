<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;

    protected $dates = 'delete_at';

    protected $table = 'member';

    protected $dateFormat = 'U';

    const CREATED_AT = 'create_at';

    const UPDATED_AT = 'update_at';

    const DELETED_AT ='delete_at';


}
