<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function createUser(array $userData): User
    {
        return User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password'])
        ]);
    }

    public function tryLogin(array $userData): bool
    {
        $credentials = ['email' => $userData['email'], 'password' => $userData['password']];
        return Auth::attempt($credentials);
    }

    public function createInvalidLoginMessage(): array
    {
        return [
            'status' => false,
            'message' => 'Email or Password does not match with our record.',
        ];
    }
}
