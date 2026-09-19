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
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class authController extends Controller
{
    public function register(registerValidation $registerValidation)
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $registerValidation->name,
                'email' => $registerValidation->email,
                'password' => Hash::make($registerValidation->password),
            ]);

            DB::commit();

            $data = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at,
            ];

            return ApiResponse::success($data,'Register successfully.',201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return ApiResponse::error('Register failed.',500);
        }
    }

    public function login(loginValidation $loginValidation)
    {
        try {
            $credentials = [
                'email' => $loginValidation->email,
                'password' => $loginValidation->password,
            ];

            if (!$token = Auth::attempt($credentials)) {
                return ApiResponse::error('Email or password is incorrect.',401);
            }

            $user = Auth::user();

            return $this->respondWithToken($token, $user);
        } catch (\Throwable $th) {
            return ApiResponse::error('Login failed.',500);
        }
    }

    public function logout()
    {
        try {
            Auth::logout();

            return ApiResponse::success(null,'Successfully logged out.',200);
        } catch (\Throwable $th) {
            return ApiResponse::error('Logout failed.',500);
        }
    }

    public function me()
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return ApiResponse::error('Unauthorized.',401);
            }

            $data = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ];

            return ApiResponse::success($data,'Get user successfully.',200);
        } catch (\Throwable $th) {
            return ApiResponse::error('Unauthorized.',401);
        }
    }

    public function refresh()
    {
        try {
            $token = Auth::refresh();
            $user = Auth::user();

            return $this->respondWithToken($token, $user);
        } catch (TokenExpiredException $th) {
            return ApiResponse::error('Token has expired.',401);
        } catch (\Throwable $th) {
            return ApiResponse::error('Unauthorized.',401);
        }
    }

    protected function respondWithToken($token, $user = null)
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user' => $user,
        ];

        return ApiResponse::success($data,'Successfully.',200);
    }
}