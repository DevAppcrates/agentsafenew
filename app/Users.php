<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';

    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $fillable = ['device_token'];

    public function user_address()
    {
        return $this->hasOne('App\UserAddress','user_id','user_id');
    }

    public function user_medical_info()
    {
        return $this->hasOne('App\UserMedicalInfo','user_id','user_id');
    }

    public function user_emergency_contacts()
    {
        return $this->hasMany('App\UserEmergencyContacts','user_id','user_id');
    }

    public function organization()
    {
        return $this->belongsTo('App\Organizations','organization_id','organization_id')->where('type','1');
    }

    public function member()
    {
        return $this->belongsTo('App\GroupMembers','user_id','user_id');

    }

    public function user_tags()
    {
      return $this->hasMany(TagMembers::class,'user_id','user_id');
    }

    public function notification()
    {
        return $this->hasOne(NotificationUserStatus::class,'user_id','user_id');
    }

    public function getCreatedAtAttribute($date)
    {
       return date('F d, Y h:i A',strtotime($date));
    }

    
     public function getFirstNameAttribute($name)
    {
        return ucfirst($name);
    }
    public function getLastNameAttribute($name)
    {
        return ucfirst($name);
    }
}
