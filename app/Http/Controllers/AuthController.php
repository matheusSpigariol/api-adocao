<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\Endereco;
use App\Models\User;
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

        $usuario = Users::with('endereco')
            ->find(auth()->user()->id);


        return response()->json([
            'user' => $usuario,
            'token' => $token->plainTextToken
        ]);
    }
    public function register(RegisterUserRequest $request)
    {
        try {
            $endereco = Endereco::create(
                [
                    "rua" => $request->rua,
                    "numero" => $request->numero,
                    "complemento" => $request->complemento,
                    "bairro" => $request->bairro,
                    "cidade" => $request->cidade,
                    "estado" => $request->estado,
                    "cep" => $request->cep,
                ]
            );
        } catch (\Throwable $th) {
            return response()->json([
                "erro" => "Não foi possível cadastrar o endereço"
            ], 500);
        }

        $user = Users::create(
            [
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password, ['rounds' => 12]),
                "endereco " => $endereco->id,
                "foto" => $request->foto,
                "data_aniversairo" => $request->data_aniversairo,
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
