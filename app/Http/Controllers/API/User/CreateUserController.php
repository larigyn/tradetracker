<?php

namespace App\Http\Controllers\API\User;

use Exception;
use App\Actions\User\CreateUser;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Http\Requests\User\CreateUserRequest;


class CreateUserController extends Controller
{
    public function __invoke(CreateUserRequest $request, CreateUser $action): JsonResponse
    {
        $request->validated();

        try {
            $userData = $action->execute($request->all());
            $this->response['data'] = new UserResource($userData);
        } catch (Exception $e) {
            $this->response = [
                'error' => $e->getMessage(),
                'code' =>  $e->getCode(),
            ];
        }

        return response()->json($this->response, $this->response['code']);
    }
}
