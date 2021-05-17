<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
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

    public function render($request, \Throwable $exception)
    {
        $response = ['error' => true, 'message' => $exception->getMessage()];

        if ($exception instanceof ValidationException) {
            $response['data'] = $exception->errors();
        } else if (env('APP_DEBUG')) {
            $response['trace'] = $exception->getTrace();
        }

        $statusCode = null;

        if ($this->isHttpException($exception)) {
            $statusCode = $exception->getStatusCode();
        } else {
            $statusCode = isset($exception->status) ? $exception->status : 500;
        }

        return new JsonResponse(
            $response,
            $statusCode,
            $this->isHttpException($exception) ? $exception->getHeaders() : [],
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        );
    }
}
