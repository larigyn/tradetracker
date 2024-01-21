<?php

namespace App\Actions\User;

use App\Models\User;
use App\Services\TokenManager;
use Illuminate\Support\Facades\DB;

class LoginUser
{
    protected $tokenManager;

    public function __construct(TokenManager $tokenManager)
    {
        $this->tokenManager = $tokenManager;
    }

    public function execute($data)
    {
        $user = User::where('email', $data['email'])->firstOrFail();
        $roles = $user->roles->pluck('slug')->all();
        $tokenData = DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->first();

        return is_null($tokenData) ? $this->tokenManager->createToken($user, $roles)->plainTextToken : $this->tokenManager->refreshToken($user);
    }
}
