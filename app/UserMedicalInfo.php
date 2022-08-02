<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMedicalInfo extends Model
{
    protected $table = 'user_medical_info';

    public function getCreatedAtAttribute($date)
    {
        return date('F d, Y h:i A',strtotime($date));
    }
}
