<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class WednesdayStartTime implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $status;
    public function __construct($status)
    {
        $this->status = $status;
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
        if($this->status == 'active' && empty($value))
        {
            return false;
        }else{
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Wednesday start time must be set if status is active';
    }
}
