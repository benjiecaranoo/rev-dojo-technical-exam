<?php

namespace App\Http\Controllers\V1\Auth;

use App\Enums\ErrorCodes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        /** @var User $request */
        $user = User::query()->where('email', $request->email)->first();

        if (!$user) {
            return $this->respondWithError(ErrorCodes::INVALID_CREDENTIALS, Response::HTTP_UNAUTHORIZED);
        }

        $newAccessToken = $user->createToken($request->header('user-agent'));

        return $this->respondWithToken($newAccessToken->plainTextToken, UserResource::make($user), Response::HTTP_OK);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out'], Response::HTTP_OK);
    }
}
