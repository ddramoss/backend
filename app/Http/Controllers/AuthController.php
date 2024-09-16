<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * register: Registro de usuario
     *
     * @param  RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    /**
     * login: Inicio de sesión
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Usuario y/o contraseña incorrecta.'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Error al iniciar sesión.'], 500);
        }

        return response()->json(['token' => $token]);
    }

    /**
     * me: Obtiene el usuario autenticado.
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return response()->json(Auth::user());
    }

    /**
     * logout: Cierra sesión
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        // Invalida el token JWT
        JWTAuth::parseToken()->invalidate();

        return response()->json(['message' => 'Se ha cerrado la sesión correctamente.']);
    }
}
