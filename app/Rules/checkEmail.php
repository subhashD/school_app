<?php

namespace App\Rules;

use EmailValidator;
use Illuminate\Contracts\Validation\Rule;

class checkEmail implements Rule
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
        return EmailValidator::verify($value)->isValid()[0];
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Email id is not Valid.';
    }
}
