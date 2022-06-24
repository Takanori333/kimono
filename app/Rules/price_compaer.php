<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class price_compaer implements Rule
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
        return (int)$value['max']>(int)$value['min'];
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '最低料金は最高料金より小さい値を入力してください';
    }
}
