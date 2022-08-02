<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organizations extends Model
{
    protected $table = 'organizations';
    protected $casts = [
    			"additional_fields" => 'array'
    	];
    protected $fillable = ['timezone_id','code'];
    protected $hidden = [
        'password',
    ];
    public function time_zone()
    {
        return $this->belongsTo(TimeZone::class, 'timezone_id', 'id');
    }
    public function getCreatedAtAttribute($date)
    {
         return date('F d, Y h:i A',strtotime($date));
    }
      public function getNameAttribute($name)
    {
        return ucfirst($name);
    }

    public function schedule()
    {
        return $this->hasMany(Schedule::class, 'admin_id', 'id');
    }
    public function country()
    {
        return $this->hasOne(Countries::class, 'id','country_id');
    }
}
