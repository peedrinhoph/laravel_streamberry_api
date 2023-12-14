<?php

namespace App\Traits;

use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

trait HttpResponses
{

    public function response(string $message, string|int $status, array|Model|JsonResource $data = [])
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'status_code' => $status,
            'data' => $data
        ], $status);
    }

    public function error(string $message, string|int $status, array|MessageBag $errors = [], array $data = [])
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'status_code' => $status,
            'errors' => $errors,
            'data' => $data
        ], $status);
    }
}
