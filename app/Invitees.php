<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Invitees extends Model
{
    protected $table = 'invitees';

    public function user_tags()
    {
        return $this->hasMany(TagMembers::class,'user_id','id');
    }

    public function notification()
    {
        return $this->hasOne(NotificationUserStatus::class,'user_id','id');
    }

     public function getCreatedAtAttribute($date)
    {
        return date('F d, Y h:i A',strtotime($date));
    }
}
