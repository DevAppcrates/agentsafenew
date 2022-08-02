<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table = 'user_address';

    public function getCreatedAtAttribute($date)
    {
       return date('F d, Y h:i A',strtotime($date));
    }

}
