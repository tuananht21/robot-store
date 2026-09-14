<?php

namespace App\helpers;

class ApiResponse
{
    public static function success($data = [], $message = 'success', $statusCode = 200)
    {
        return response()->json([
            'message' => $message,
            'status' => true,
            'statusCode' => $statusCode,
            'data' => $data,
        ], $statusCode, [], JSON_UNESCAPED_UNICODE)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public static function error($message = 'error', $statusCode = 'error')
    {
        return response()->json([
            'message' => $message,
            'status' => false,
            'statusCode' => $statusCode,
        ], $statusCode, [], JSON_UNESCAPED_UNICODE)->header('Content-Type', 'application/json; charset=utf-8');
    }
}
