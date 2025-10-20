<?php

namespace Modules\Auth\Actions; // adjust namespace path

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\NewAccessToken;

class LoginAction
{
    /**
     * Attempt to authenticate and generate token.
     *
     * @param string $email
     * @param string $password
     * @return NewAccessToken
     */
    public function execute(string $email, string $password): NewAccessToken
    {
        if (! Auth::attempt(['email' => $email, 'password' => $password])) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Delete previous tokens (optional for security)
        $user->tokens()->delete();

        $user->update([
            'last_logged_in_at' => now(),
        ]);

        return $user->createToken('api-token');
    }
}
