<?php

namespace App\Http\Middleware\auth;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class adminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json([
                    'message' => 'Unauthorized.',
                ], 401);
            }

            if ($user->role != 1) {
                return response()->json([
                    'message' => 'Forbidden.',
                ], 403);
            }

            return $next($request);

        } catch (JWTException $e) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 401);
        }
    }
}