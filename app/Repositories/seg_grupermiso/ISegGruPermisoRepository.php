<?php

namespace App\Repositories\seg_grupermiso;

use App\Helpers\Interfaces\IMantenimiento;

interface ISegGruPermisoRepository extends IMantenimiento
{
    public function getGruPermiso($id);
}
