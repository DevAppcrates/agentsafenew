<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class NotificationUserStatus extends Model
{
    protected $table='notification_user_status';

    public function getSmsAttribute($value) {
        if($value!=0){
            return \Carbon\Carbon::parse($value)->format('m/d/Y, h:i A');
        }
    }

    public function getEmailAttribute($value) {
        if($value!=0){
            return \Carbon\Carbon::parse($value)->format('m/d/Y, h:i A');
        }
    }

    public function getNotificationAttribute($value) {
        if($value!=0){
            return \Carbon\Carbon::parse($value)->format('m/d/Y, h:i A');
        }
    }
}
