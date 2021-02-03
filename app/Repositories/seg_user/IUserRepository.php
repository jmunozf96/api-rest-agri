<?php

namespace App\Repositories\seg_user;

use App\Helpers\Interfaces\IMantenimiento;

interface IUserRepository extends IMantenimiento
{
    public function getUser($id);
}
