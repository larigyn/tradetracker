<?php

namespace App\Http\Controllers\API\User;

use Exception;
use App\Actions\User\LoginUser;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginUserRequest;

class LoginUserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param LoginUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(LoginUserRequest $request, LoginUser $action): JsonResponse
    {
        try {
            $token = $action->execute($request->validated());
            $this->response['token'] = $token;
        } catch (Exception $e) {
            $this->response = [
                'error' => $e->getMessage(),
                'code' =>  $e->getCode(),
            ];
        }

        return response()->json($this->response, $this->response['code']);
    }
}
