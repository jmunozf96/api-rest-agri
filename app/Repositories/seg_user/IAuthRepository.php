<?php

namespace App\Repositories\seg_user;

use App\Repositories\seg_user\IAuthentication;

interface IAuthRepository extends IAuthentication
{
    public function refresh();
    public function userProfile();
    public function getToken($token);
    public function getModulesAccess($idUser);
}
