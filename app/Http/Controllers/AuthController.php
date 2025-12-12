<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $credentials = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone_number' => 'required|string',
        ]);

        $user = User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password']),
            'phone_number' => $credentials['phone_number']
        ]);

        return response()->json([
            'message' => 'Usuário criado com sucesso'
        ], 201);

    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $credentials['email'])->first();
            $token = $user->createToken('api')->plainTextToken;

            return response()->json([
                'message' => 'Login realizado com sucesso',
                'token' => $token
            ]);
        }

        return response()->json([
            'message' => 'As credenciais fornecidas estão inválidas'
        ], 401);

    }

    public function logout(Request $request)
    {
        $request->user()->currentAcessToken()->delete();
        Auth::logout();
    }
}