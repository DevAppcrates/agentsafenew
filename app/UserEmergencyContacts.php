<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserEmergencyContacts extends Model
{
    protected $table = 'user_emergency_contacts';

    public function getCreatedAtAttribute($date)
    {
        return date('F d, Y h:i A',strtotime($date));
    }

      public function getNameAttribute($name)
    {
        return ucfirst($name);
    }
     public function getRelationAttribute($name)
    {
        return ucfirst($name);
    }
}
