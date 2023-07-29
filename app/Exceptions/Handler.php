<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Encryption\MissingAppKeyException;
use App\Helpers\ResponseHelper;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return ResponseHelper::errorWithMessage(
                'You are not authenticated. Please login to have access',
                UNAUTHORIZED
            );
        }
    }

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


        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            if ($request->is('api/*')) {
                return ResponseHelper::errorWithMessage(
                    'Unauthorized access. You do not have permission to visit this route.',
                    BAD_REQUEST
                );
            }
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return ResponseHelper::errorWithMessage(
                    'Resource not found',
                    NOT_FOUND
                );
            }
        });


        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            if ($request->is('api/*')) {
                return ResponseHelper::errorWithMessage(
                    $e->getMessage(),
                    BAD_REQUEST
                );
            }
        });

        $this->renderable(function (MissingAppKeyException $e, $request) {
            if ($request->is('api/*')) {
                return ResponseHelper::errorWithMessage(
                    $e->getMessage(),
                    INTERNAL_SERVER_ERROR
                );
            }
        });
    }
}
