<?php

namespace App\Repositories\seg_usuperfil;

use App\Helpers\Interfaces\IMantenimiento;

interface ISegUsuPerfilRepository extends IMantenimiento
{
    public function getUsuPerfil($idUsuario);
}
