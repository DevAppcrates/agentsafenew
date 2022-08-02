<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoLocationTracking extends Model
{
    protected $table = 'video_location_tracking';
    public function getCreatedAtAttribute($date)
    {
        return date('F d, Y h:i A',strtotime($date));
    }
}
