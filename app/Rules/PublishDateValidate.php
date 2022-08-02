<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use \Carbon\Carbon;
use \DateTime;
use \DateTimeZone;
class PublishDateValidate implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $timestamp;
    protected $timezone;
    protected $schedule;
    public function __construct($timestamp,$timezone,$schedule)
    {
        $this->schedule = $schedule;
        $this->timezone = $timezone;
        $this->timestamp = $timestamp; 
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {   
        if($this->schedule == 0)
        {
        return true;
        }else{
         
        ini_set('app.timezone',$this->timezone);
        
        $current_time = new DateTime('now',new DateTimeZone('UTC'));
       
        $timestamp = new DateTime($this->timestamp,new DateTimeZone($this->timezone));

        $current_time->setTimezone(new DateTimeZone($this->timezone));

            if($timestamp  < $current_time):
                return false;
            else:
                return true;
            endif;
        }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'selected Date must be of today or later one.';
    }
}
