<?php

namespace App\Repositories\seg_tipoModulo;

use App\Helpers\Interfaces\IMantenimiento;

interface ISegTipoModuloRepository extends IMantenimiento
{
    public function getTipoModulo($id);
    public function getAllTipos();
}
