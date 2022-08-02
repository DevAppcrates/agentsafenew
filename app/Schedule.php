<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedule';

    protected $fillable = ['admin_id','organization_id','day_id','open_time','close_time','open_time_format','close_time_format','status'];

    public function days()
    {
        return $this->hasOne(Days::class, 'id', 'day_id')->orderBy('id','asc');
    }
    public function start_time()
    {
        return $this->hasOne(Hours::class, 'id', 'open_time');
    }
     public function close_time()
    {
        return $this->hasOne(Hours::class, 'id', 'close_time');

    }
    public function admin(){
        return $this->hasOne(Organizations::class, 'id', 'admin_id')->orderBy('id','asc');
    }
}
