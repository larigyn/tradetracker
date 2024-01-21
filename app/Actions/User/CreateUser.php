<?php

namespace App\Actions\User;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Arr;

class CreateUser
{
    public function execute($data): User
    {
        $dataValueToLower = array_map('strtolower', Arr::except($data, ['password']));
        $user = array_merge(Arr::only($data, 'password'), $dataValueToLower);

        $user = User::create($data);
        $user->roles()->attach(Role::where('slug', config('user.roles.standard'))->first());

        return $user;
    }
}
