<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Auth\User;

class EmailRule implements Rule
{
    public $email = '';
    public $id = '';
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($email, $id)
    {
        $this->email = $email;
        $this->id = $id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($id, $email)
    {
        $user = User::where(
            [
                ['email', $email],
                ['id', '!=', session()->get('id')]
            ]
        )->get();

        return count($user) == 0 ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The email : ' .  $this->id . ' has already been taken.';
    }
}
