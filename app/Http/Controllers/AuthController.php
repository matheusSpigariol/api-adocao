<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if(!auth()->attempt($credentials))
            return response()->json("Credenciais invalidas", 401);
        
        $token = auth()->user()->createToken('auth_token');

        return response()->json([
            'user' => auth()->user(),
            'token' => $token->plainTextToken
        ]);
    }
    public function register(RegisterUserRequest $request)
    {
        $user = Users::create(
            [
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password, ['rounds' => 12])
            ]
        );

        $credentials = $request->only('email', 'password');

        if(!auth()->attempt($credentials))
            return response()->json("Credenciais invalidas", 401);
        
        $token = auth()->user()->createToken('auth_token');

        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken
        ], 201);
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json([], 204);
    }
}
