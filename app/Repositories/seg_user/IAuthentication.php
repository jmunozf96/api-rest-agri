<?php

namespace App\Repositories\seg_user;

interface IAuthentication{
    public function login(array $credentials);
    public function logout();
}