<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Videos extends Model
{
        use SoftDeletes;
    protected $table = 'videos';
    protected $dates = ['deleted_at'];
    protected $casts = ['message' => 'Array','lost_person' => 'Array'];

    public function user()
    {
        return $this->belongsTo('App\Users','user_id','user_id');
    }

    public function user_address()
    {
        return $this->belongsTo('App\UserAddress','user_id','user_id');
    }

    public function user_medical_info()
    {
        return $this->belongsTo('App\UserMedicalInfo','user_id','user_id');
    }

      public function getCreatedAtAttribute($date)
    {
       return date('F d, Y h:i A',strtotime($date));
    }
   
}
