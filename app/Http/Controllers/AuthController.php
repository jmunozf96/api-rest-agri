<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Repositories\seg_user\IAuthRepository;

class AuthController extends Controller
{
    private $authRepository;

    public function __construct(IAuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
        $this->middleware('user_access', ['except' => ['login', 'register']]);
    }

    public function login(LoginRequest $request)
    {
        if (!$token = $this->authRepository->login($request->validated())) {
            return response()->json(['error' => 'Usuario o contraseña incorrectas.'], 401);
        }

        return $this->createNewToken($token);
    }

    public function register(UserRequest $request)
    {
        $user = $this->authRepository->register(
            array_merge(
                $request->validated(),
                ['password' => bcrypt($request->password)]
            )
        );

        if ($user) :
            return response()->json([
                'message' => 'User successfully registered',
                'user' => $user
            ], 200);
        endif;

        return response()->json(['message' => 'Error']);
    }

    public function logout()
    {
        $this->authRepository->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }

    public function refresh()
    {
        return $this->createNewToken($this->authRepository->refresh());
    }

    public function userProfile()
    {
        return response()->json($this->authRepository->userProfile());
    }

    protected function createNewToken($token)
    {
        return response()->json($this->authRepository->getToken($token));
    }
}
