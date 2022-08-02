<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Notifications extends Model
{
	//use SoftDeletes;
	protected $casts = [
			'is_archive' => 'boolean',
	];

    protected $table = 'notifications';

    public function organization()
    {
        return $this->belongsTo(Organizations::class, 'organization_id', 'organization_id')->where('type',1);
    }

    public function sent_by()
    {
        return $this->belongsTo(Organizations::class, 'admin_id', 'id');
    }

    public function groups()
    {
        return $this->belongsToMany(Groups::class, 'notification_group','notification_id' ,'group_id');
    }


    public function getCreatedAtAttribute($date)
    {
        return date('F d, Y h:i A',strtotime($date));
    }

     public function getPublishedAtAttribute($date)
    {
        if($date != null):
            return date('F d, Y h:i A',strtotime($date));
        endif;
    }
    public function getNotificationAttribute($notification)
    {
        return stripslashes( $notification);
    }
    public function setNotificationAttribute($notification)
    {
        $this->attributes['notification'] = addslashes($notification);
    }
     public function getStatusAttribute($status)
     {
        if($status == 1):
            return 'Sent';
        elseif($status == 0):
            return "Pending";
        endif;
     }
}
