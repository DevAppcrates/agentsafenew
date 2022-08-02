<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupAlerts extends Model
{
    public function user_detail()
    {
        return $this->belongsTo('App\Users','user_id','user_id');
    }

    public function getCreatedAtAttribute($date)
    {
        return date('F d, Y h:i A',strtotime($date));
    }
}
