<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationGroup extends Model
{
    protected $table = 'notification_group';
    protected $fillable = ['group_id','notification_id'];

}
