<?php

namespace App\Repositories\seg_grupo;

use App\Helpers\Interfaces\IMantenimiento;
use App\Models\SegGrupo;

interface ISegGrupoRepository extends IMantenimiento
{
    public function getGrupo($id);
    public function getAllGrupos();
}
