<?php

namespace App\Helpers;

class ApiResponse
{
    public static function success($data, $metadata = [], $links = [])
    {
        return response()->json([
            'status' => true,
            'data' => $data,
            'metadata' => $metadata,
            'links' => $links
        ], 200);
    }

    public static function error($message, $code = 400, $details = [])
    {
        return response()->json([
            'status' => false,
            'error' => [
                'code' => $code,
                'message' => $message,
                'details' => $details
            ],
            'metadata' => [
                'timestamp' => now(),
            ]
        ], $code);
    }
}