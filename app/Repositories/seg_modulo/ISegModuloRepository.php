<?php

namespace App\Repositories\seg_modulo;

use App\Helpers\Interfaces\IMantenimiento;

interface ISegModuloRepository extends IMantenimiento
{
    public function getModulo($id);
}
