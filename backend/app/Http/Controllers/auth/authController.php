<?php

namespace App\Http\Controllers\auth;

use App\helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\auth\loginValidation;
use App\Http\Requests\auth\registerValidation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class authController extends Controller
{
    //

    public function register(registerValidation $registerValidation)
    {
        try {
            //code...
            $email = $registerValidation->email;
            $password = $registerValidation->password;
            $name = $registerValidation->name;

            DB::beginTransaction();
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);
            DB::commit();
            $data = [
                'email' => $email,
                'name' => $name,
                'created_at' => $user->created_at,
            ];
            return ApiResponse::success($data, 'Register succesfully', 201);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return ApiResponse::error('Register failed', 500);
        }
    }

    public function login(loginValidation $loginValidation)
    {
        try {
            //code...
            $email = $loginValidation->email;
            $password = $loginValidation->password;
            $credentials = ['email' => $email, 'password' => $password];

            if (!$token = Auth::attempt($credentials)) {
                return ApiResponse::error('Email or password is incorrect.', 401);
            }

            $user = Auth::user();

            $data = [
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ];
            return $this->respondWithToken($token, $data);
        } catch (\Throwable $th) {
            //throw $th;
            return ApiResponse::error('Login failed', 500);
        }
    }

    public function logout()
    {
        try {
            //code...
            if (!Auth::check()) {
                return ApiResponse::error('Unauthorized', 401);
            }
            Auth::logout();
            return ApiResponse::success('Successfully logged out', 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ApiResponse::error('Unauthorized', 401);
        }
    }

    public function me()
    {
        try {
            //code...
            if (!Auth::check()) {
                return ApiResponse::error('Unauthorized', 401);
            }
            $user = Auth::user();

            $data = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ];
            return ApiResponse::success($data, 'Get user successfully.', 200);
        } catch (\Throwable $th) {
            //throw $th;
            return ApiResponse::error('Unauthorized', 401);
        }
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        try {
            //code...
            return $this->respondWithToken(Auth::refresh());
        } catch (\Throwable $th) {
            //throw $th;
            if ($th instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return ApiResponse::error('Token has expired', 401);
            }

            return ApiResponse::error('Unauthorized', 401);
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string  $token
     * @param  array|null  $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $user = null)
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user' => $user,
        ];

        return ApiResponse::success($data, 'Successfully', 200);
    }
}
