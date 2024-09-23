<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use App\Models\Doctor; // Import the Doctor model
use App\Models\UserDetails;

//this is to register a new user/doctor

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'type' => 'doctor',
            // 'type' => $input['type'], //we add this to differentiate between user and doctor
            'password' => Hash::make($input['password']),
        ]);
        // if($input['type'] == 'doctor') {
        $doctorInfo = Doctor::create([
            'doc_id' => $user->id,
            'status' => 'active',
        ]);
        // }
        // else if($input['type'] == 'user'){
        //     $userInfo = UserDetails::create([
        //         'user_id' => $user->id,
        //         'status' => 'active',
        //     ]);
        // }
        return $user;
    }
}
