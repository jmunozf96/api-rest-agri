<?php

namespace App\Repositories\seg_user;

use App\Repositories\seg_user\IAuthRepository;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthRepository implements IAuthRepository
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login(array $credentials)
    {
        return Auth::attempt($credentials);
    }

    public function refresh()
    {
        return Auth::refresh();
    }

    public function register(array $data)
    {
        return $this->user->create($data);
    }

    public function userProfile()
    {
        return Auth::user();
    }

    public function getToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user' => Auth::user()
        ];
    }

    public function logout()
    {
        Auth::logout();
    }
}