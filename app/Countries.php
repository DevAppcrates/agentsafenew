<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    protected $table = 'countries';
    public function organizations()
    {
        return $this->hasMany(Organizations::class, 'country_id', 'id');
    }
}
