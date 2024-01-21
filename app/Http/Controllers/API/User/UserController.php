<?php

namespace App\Http\Controllers\API\User;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Actions\User\CreateUserAction;
use App\Actions\User\SearchUserAction;
use App\Http\Resources\User\UserResource;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\SearchUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\SearchUserRequest  $request
     * @param  SearchUserAction $action
     * @return \Illuminate\Http\Response
     */
    public function index(SearchUserRequest $request, SearchUserAction $action): JsonResponse
    {
        try {
            $transportation = $action->execute($request->validated());
            $this->response['data'] = UserResource::collection($transportation);
        } catch (Throwable $e) {
            $this->response = [
                'error' => $e->getMessage(),
                'code' =>  $e->getCode(),
            ];
        }

        return response()->json($this->response, $this->response['code']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CreateUserRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateUserRequest $request, CreateUserAction $action): JsonResponse
    {
        $request->validated();

        try {
            $user = $action->execute($request->all());
            $this->response['data'] = new UserResource($user);
        } catch (Throwable $e) {
            $this->response = [
                'error' => $e->getMessage(),
                'code' =>  $e->getCode(),
            ];
        }

        return response()->json($this->response, $this->response['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
