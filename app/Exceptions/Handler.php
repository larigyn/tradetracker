<?php

namespace App\Exceptions;

use Throwable;
use BadMethodCallException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        // dd($exception);
        // set default error code
        $code = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500;
        $error = $exception->getMessage();

        // handle API exceptions
        if ($request->expectsJson()) {

            if ($exception instanceof AuthenticationException) {
                $code = 401;
            }

            if ($exception instanceof ValidationException) {
                $error = $exception->errors();
                $code = 422;
            }


            if ($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException) {
                $code = 404;
            }

            if ($exception instanceof BadMethodCallException) {
                $code = 405;
            }

            return response()->json(
                [
                    'code' => $code,
                    'error' => $error,
                ],
                $code
            );
        }

        return parent::render($request, $exception);
    }
}
