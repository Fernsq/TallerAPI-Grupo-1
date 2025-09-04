<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\Response;

class AuthController extends Controller
{
public function login(Request $request)
    {
        $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
        ]);

    if(Auth::attempt($credentials))
    {
        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer'
        ], Response::HTTP_OK);
    }
    else
    {
        return response([
            "message" => "Credenciales incorrectas"
        ], Response::HTTP_UNAUTHORIZED);
    }

    }


    public function logout(Request $request)
{
    $user = Auth::user();
    $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
    return response()->json([
        "message" => "Sesión cerrada exitosamente",
    ], Response::HTTP_OK);
}

public function register(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed', 
    ]);

   
    $user = \App\Models\User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
    ]);

    // Generar el token
    $token = $user->createToken('token')->plainTextToken;

    return response()->json([
        'user' => $user,
        'token' => $token,
        'token_type' => 'Bearer',
        "message" => "Usuario registrado correctamente"
    ], Response::HTTP_CREATED);
}

}
