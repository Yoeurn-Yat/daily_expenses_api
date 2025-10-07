<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $input = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $token = $user->createToken('auth_token')->accessToken;

        return response()->json([
            'data' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
            'message' => 'User created successfully',
            'status' => 201
        ], 201);
    }

    public function login(Request $request, AuthService $authService)
    {
        $input = $request->validate([
            'email' => ['nullable', 'email'],
            'password' => ['required', 'string'],
            'name' => ['required_without:email', 'string']
        ]);

        if (!Auth::attempt($input))
        {
            return response()->json([
                'message' => 'Unauthorized',
                'status' => 401
            ], 401);
        }

        $user = Auth::user();
        $user = $authService->authService($user, 'Login successfully');
        return $user;
    }

    public function logout()
    {
        auth()->user()->token()->revoke();
        return response()->json([
            'message' => 'Logout successfully',
            'status' => 200
        ], 200);
    }

    public function me()
    {
        $user = auth()->user();
        return response()->json([
            'data' => $user,
            'message' => 'Success',
            'status' => 200
        ], 200);
    }
}
