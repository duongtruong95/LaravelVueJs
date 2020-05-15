<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckRoleAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(JWTAuth::user()->level != 1){
            return response()->json([
                'status' => false,
                'code' => Response::HTTP_FORBIDDEN,
                'message' => 'Permisstion Required!',
            ], Response::HTTP_FORBIDDEN);
        }
        return $next($request);
    }
}
