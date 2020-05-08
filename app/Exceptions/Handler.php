<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpFoundation\Response;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof UnauthorizedHttpException) {
            $preException = $exception->getPrevious();
            if ($preException instanceof
                \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json([
                    'status'  => false,
                    'code'    => Response::HTTP_UNAUTHORIZED,
                    'message' => 'TOKEN_EXPIRED',
                ], Response::HTTP_UNAUTHORIZED);
            } else if ($preException instanceof
                \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json([
                    'status'  => false,
                    'code'    => Response::HTTP_UNAUTHORIZED,
                    'message' => 'TOKEN_INVALID',
                ], Response::HTTP_UNAUTHORIZED);
            } else if ($preException instanceof
                \Tymon\JWTAuth\Exceptions\TokenBlacklistedException) {
                return response()->json([
                    'status'  => false,
                    'code'    => Response::HTTP_FORBIDDEN,
                    'message' => 'TOKEN_BLACKLISTED',
                ], Response::HTTP_FORBIDDEN);
            }
            if ($exception->getMessage() === 'Token not provided') {
                return response()->json([
                    'status'  => false,
                    'code'    => Response::HTTP_BAD_REQUEST,
                    'message' => 'Token not provided',
                ], Response::HTTP_BAD_REQUEST);
            }
        }
        return parent::render($request, $exception);
    }
}
