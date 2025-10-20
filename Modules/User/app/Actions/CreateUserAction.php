<?php

namespace Modules\User\Actions;

use App\Models\User;

class CreateUserAction
{
    public function execute(string $name, string $email, string $password): User
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password, // hashed via model cast
        ]);
    }
}
