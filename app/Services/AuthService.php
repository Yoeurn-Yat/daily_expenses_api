<?php

namespace App\Services;

class AuthService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function authService($user, $message = null)
    {
        $token = $user->createToken('auth_token')->accessToken;
        return response()->json([
            'data' => $user,
            'token_type' => 'Bearer',
            'token' => $token,
            'message' => $message,
            'status' => 200
        ]);
    }
}
