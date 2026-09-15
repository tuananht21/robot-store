<?php

namespace App\helpers;

class ApiResponse
{
    public static function success($data = [], $message = 'success', $statusCode = 200)
    {
        return response()->json([
            'status' => true,
            'statusCode' => $statusCode,
            'message' => $message,
            'data' => $data,
        ], $statusCode, [], JSON_UNESCAPED_UNICODE)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public static function error($message = 'error', $statusCode = 400)
    {
        return response()->json([
            'status' => false,
            'statusCode' => $statusCode,
            'message' => $message,
        ], $statusCode, [], JSON_UNESCAPED_UNICODE)->header('Content-Type', 'application/json; charset=utf-8');
    }
}
