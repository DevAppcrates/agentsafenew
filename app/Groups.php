<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    protected $table = 'groups';

    public function members()
    {
        return $this->hasMany('App\GroupMembers','group_id','id');
    }

    public function group_alerts()
    {
        return $this->hasMany('App\GroupAlerts','group_id','group_id');
    }

    public function getCreatedAtAttribute($date)
    {
       return date('F d, Y h:i A',strtotime($date));
    }


     public function getTitleAttribute($name)
    {
        return ucfirst($name);
    }

    
}
