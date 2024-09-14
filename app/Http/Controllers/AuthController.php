<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Registro de usuario
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        Log::info('Intentando login con: ', $credentials);

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                Log::info('Credenciales inválidas');
                return response()->json(['error' => 'Credenciales inválidas'], 401);
            }
        } catch (JWTException $e) {
            Log::error('Error al crear el token: ' . $e->getMessage());
            return response()->json(['error' => 'No se pudo crear el token'], 500);
        }

        Log::info('Token generado: ' . $token);
        return response()->json(compact('token'));
    }

    // Obtener el usuario autenticado
    public function me()
    {
        return response()->json(Auth::user());
    }
}
