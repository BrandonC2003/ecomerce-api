<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrarUsuarioRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use ApiResponseTrait;

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegistrarUsuarioRequest $request): JsonResponse
    {
        $userData = $request->only(['name', 'email', 'password', 'role']);

        $user = User::create($userData);

        $token = JWTAuth::fromUser($user);

        return $this->authResponse($token, $user, 'Usuario registrado exitosamente.', 201);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (! $token = JWTAuth::attempt($credentials)) {
            return $this->errorResponse('Credenciales inválidas.',[], 401);
        }

        $user = JWTAuth::user();

        return $this->authResponse($token, $user, 'Login exitoso.');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        return $this->noContentResponse();
    }
}
