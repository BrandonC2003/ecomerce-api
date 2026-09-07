<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponseTrait
{
    /**
     * Return a successful API response.
     */
    protected function successResponse(
        mixed $data = null,
        string $message = 'Operación exitosa.',
        int $status = 200
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * Return an authentication response with token metadata.
     */
    protected function authResponse(
        string $token,
        mixed $user = null,
        string $message = 'Autenticación exitosa.',
        int $status = 200
    ): JsonResponse {
        $data = [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60, // Token expiration time in seconds
        ];

        if ($user !== null) {
            $data['user'] = $user;
        }

        return $this->successResponse($data, $message, $status);
    }

    /**
     * Return an empty API response.
     */
    protected function noContentResponse(int $status = 204): Response
    {
        return response()->noContent($status);
    }

    /**
     * Return a failed API response.
     *
     * @param  array<string, mixed>  $errors
     */
    protected function errorResponse(
        string $message,
        array $errors = [],
        int $status = 400
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
}
