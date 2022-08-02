<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserDeletedNotification extends Pivot
{
    protected $table = 'del_notification_user';
    
}
