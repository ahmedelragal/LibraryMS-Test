<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function successResponse($data, $status)
    {
        return response()->json([
            'status' => $status,
            'data' => $data
        ], $status);
    }

    public function errorResponse($message, $status)
    {
        return response()->json([
            'status' => $status,
            'message' => $message
        ], $status);
    }
}
