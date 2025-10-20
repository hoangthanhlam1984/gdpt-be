<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Auth\Actions\UpdateProfileAction;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Http\Requests\UpdateProfileRequest;
use Modules\Auth\Http\Resources\AuthTokenResource;
use Modules\Auth\Actions\LoginAction;
use Modules\User\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Handle user login and return Sanctum token.
     */
    public function login(
        LoginRequest $request,
        LoginAction $loginAction
    ): JsonResponse
    {
        $token = $loginAction->execute($request->email, $request->password);

        $expiresIn = config('sanctum.expiration');
        $expiresIn = $expiresIn ? $expiresIn * 60 : null;

        return AuthTokenResource::make([
                'token'      => $token->plainTextToken,
                'expires_in' => $expiresIn,
            ])
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function me(Request $request): JsonResponse
    {
        return UserResource::make($request->user())
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function updateProfile(
        UpdateProfileRequest $request,
        UpdateProfileAction $updateProfileAction
    ): JsonResponse
    {
        $user = $updateProfileAction->execute($request->user(), $request->validated());

        return UserResource::make($user)
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
