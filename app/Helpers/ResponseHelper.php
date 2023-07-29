<?php
namespace App\Helpers;

use \Illuminate\Http\JsonResponse;

class ResponseHelper {

    public static function success(): JsonResponse
    {
        return response()->json([
           'status' => 'success'
        ], CREATED);
    }

    public static function successWithMessage($message): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message
        ], OK);
    }

    public static function successWithMessageAndData($message, $data): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], OK);
    }

    public static function error($statusCode): JsonResponse
    {
        return response()->json([
            'status' => 'error'
        ], $statusCode);
    }

    public static function errorWithMessage($message, $statusCode): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $statusCode);
    }

    public static function errorWithMessageAndData($message, $data, $statusCode): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }
}
