<?php

namespace App\Support;

use App\Enums\ErrorCodes;
use Illuminate\Http\JsonResponse;

trait ReturnResponse
{
    public function respondWithToken(string $token, $user, $statusCode = 200): JsonResponse
    {
        return response()->json([
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => now()->addMinutes(config('jwt.ttl')),
                'user' => $user,
            ],
        ], $statusCode)->header('Authorization', $token);
    }

    /**
     * @param string $errorCode
     * @param int $statusCode
     * @param string|null $message
     * @param array $metadata
     * @return JsonResponse
     */
    public function respondWithError(
        string $errorCode,
        int $statusCode = 400,
        ?string $message = null,
        array $metadata = []
    ): JsonResponse {
        $payload = [
            'message' => $message ?: ErrorCodes::getDescription($errorCode),
            'error_code' => $errorCode,
        ];

        if (filled($metadata)) {
            $payload = array_merge($payload, ['meta' => $metadata]);
        }

        return response()->json($payload, $statusCode);
    }
}
