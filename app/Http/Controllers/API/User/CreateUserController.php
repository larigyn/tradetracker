<?php

namespace App\Http\Controllers\API\User;

use App\Actions\User\CreateUser;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Controllers\API\AbstractController;


class CreateUserController extends AbstractController
{
    public function __invoke(CreateUserRequest $request, CreateUser $action)
    {
        $user = $action->execute($request->all());

        return $this->okJsonResponse();
    }
}
