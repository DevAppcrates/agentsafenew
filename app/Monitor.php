<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Monitor extends Model
{
    //
    protected $casts = [
    	'additional_fields'=> 'array',
    ];
    public function organizations()
    {
        return $this->hasMany(MonitorOrganization::class, 'monitor_id', 'monitor_id');
    }
    public function phone_code()
    {
        return $this->belongsTo(Countries::class, 'country_id', 'id');
    }
}
