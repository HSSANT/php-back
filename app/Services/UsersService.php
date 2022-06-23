<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class UsersService
{
   /**
     * Create a new Service instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Create a new User
     *
     * @param App\Models\Users $user
     */
    public function create($user)
    {
        $verifyUser = User::where('email',$user->email)->first();
        if($verifyUser){
            throw ValidationException::withMessages(['E-mail already registered']);
        }
        $user->save();
        $role    = Role::findByName('client','api');
        $user->assignRole($role);

        return $user;
    }


}
