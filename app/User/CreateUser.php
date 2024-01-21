<?php

namespace App\Actions\User;

use App\Models\Role;
use App\Models\User;

class CreateUser
{
    public function execute($data): User
    {
        $data = array_filter($data, 'strlen');
        dd('create user data', $data);

        $user = User::create($data);
        $user->roles()->attach(Role::where('slug', config('user.roles.authenticated'))->first());

        return $user;
    }
}
