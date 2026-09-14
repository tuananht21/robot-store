<?php

namespace App\Http\Middleware\auth;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class adminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {

            //kiểm tra token
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user || $user->role !== 1) {
                return response()->json([
                    'message' => 'Forbidden',
                ], 403);
            }
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $th) {

            return response()->json([
                'message' => 'Token is invalid missing',
            ], 401);
        }
        return $next($request);
    }
}
