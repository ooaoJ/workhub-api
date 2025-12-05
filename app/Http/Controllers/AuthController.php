<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try{

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
            ] , 201);
        } catch (Exception $e){
            return response()->json([
                'message' => 'Erro ao criar o usuário'
            ], 400);
        }
    }

    public function login(Request $request)
    {
        
    }
}
