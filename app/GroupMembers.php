<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMembers extends Model
{
    protected $table = 'group_members';
    protected $fillable = ['user_id','group_id','created_at','type'];
    public function getCreatedAtAttribute($date)
    {
        return date('F d, Y h:i A',strtotime($date));
    }
    
    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id', 'user_id');
    }
}
