<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

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
        if ($request->expectsJson()) {
            if($exception->getMessage() == 'Unauthenticated.'){
                return response()->json([
                    'status'   => false,
                    'status_code'   => 401,
                    'message' => 'Unauthenticated user!'
                ]);
            } else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException){
                    return response()->json([
                    'status'   => false,
                    'status_code'   => 404,
                    'message' => 'End point not found!'
                ]);
            } else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException){
                    return response()->json([
                    'status'   => false,
                    'status_code'   => 405,
                    'message' => 'Method not allowed!'
                ]);
            }
        }
        return parent::render($request, $exception);
    }
}
