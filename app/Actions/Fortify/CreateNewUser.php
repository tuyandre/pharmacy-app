<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'phone_no' => ['required', 'numeric',  'unique:users'],
            'location' => ['required', 'string'],
            'role' => ['required', 'string'],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'fname' => $input['fname'],
            'lname' => $input['lname'],
            'location' => $input['location'],
            'phone_no' => $input['phoneNo'],
            'role' => $input['role'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
