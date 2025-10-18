<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Http\Resources\AuthTokenResource;
use Modules\Auth\Actions\LoginAction;

class AuthController extends Controller
{
    public function __construct(private LoginAction $loginAction) {}

    /**
     * Handle user login and return Sanctum token.
     */
    public function login(LoginRequest $request)
    {
        $token = $this->loginAction->execute($request->email, $request->password);

        $expiresIn = config('sanctum.expiration');
        $expiresIn = $expiresIn ? $expiresIn * 60 : null;

        return new AuthTokenResource([
            'token'      => $token->plainTextToken,
            'expires_in' => $expiresIn,
        ]);
    }
}
