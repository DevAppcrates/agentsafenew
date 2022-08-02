<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeletedTip extends Model
{
    protected $table = 'del_tip_user';
    protected $fillable = ['user_id','video_id'];
    

}
