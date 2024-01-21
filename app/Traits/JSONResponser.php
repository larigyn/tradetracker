<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait JSONResponser
{
    /**
     * Build json success
     *
     * @param array $data
     * @param int $code
     * @return JsonResponse
     */
    public function successResponse($data, $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json($data, $code);
    }

    /**
     * Build error json object
     *
     * @param array $error
     * @param int $code
     * @return JsonResponse
     */
    public function errorResponse(array $error, $code): JsonResponse
    {
        return response()->json([
            'errors' => [
                "field" => $error['field'],
                "messages" => $error['messages']
            ]
        ], $code);
    }

    /**
     * Build json message
     *
     * @param string$message
     * @param int $code
     * @return JsonResponse
     */
    public function messageResponse($message, $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json(['message' => $message], $code);
    }

    /**
     * Build json response
     *
     * @param mixed $data
     * @param int $code
     * @return JsonResponse
     */
    public function jsonResponse($data, $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json($data, $code);
    }

    public function exceptionResponse($exception, $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        return response()->json($exception, $code);
    }
}
