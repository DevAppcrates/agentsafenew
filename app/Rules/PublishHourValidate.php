<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PublishHourValidate implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        if(date('H:i:s',strtotime($value)) <= date('H:i:s')):
            return false;
        else:
            return true;
        endif;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Selected time should be greater than current time..';
    }
}
