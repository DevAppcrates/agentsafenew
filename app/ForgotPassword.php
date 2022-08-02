<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForgotPassword extends Model
{
    protected $table='password_resets';
    public $timestamps = false;

}
