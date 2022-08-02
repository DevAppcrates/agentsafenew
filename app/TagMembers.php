<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagMembers extends Model
{
    protected $table='tag_members';

    public function tag()
    {
        return $this->belongsTo(Tags::class,'tag_id','tag_id');
    }
}
