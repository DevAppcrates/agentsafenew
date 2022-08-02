<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    protected $table='tags';

    public function tag_members()
    {
        return $this->hasMany(TagMembers::class,'tag_id','tag_id');
    }
}
