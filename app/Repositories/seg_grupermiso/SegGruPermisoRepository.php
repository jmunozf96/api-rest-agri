<?php

namespace App\Repositories\seg_grupermiso;

use App\Models\SegGruPermiso;
use App\Models\SegGrupo;
use Exception;

class SegGruPermisoRepository implements ISegGruPermisoRepository
{
    protected $gru_permiso;

    public function __construct(SegGruPermiso $gru_permiso)
    {
        $this->gru_permiso = $gru_permiso;
    }

    public function all()
    {
        return $this->gru_permiso->getAll();
    }

    public function save($data)
    {
        $grupo = SegGrupo::existe($data['idGrupo'])->first();
        if ($grupo) :
            $permisos = $data['permisos'];
            foreach ($permisos as $permiso) :
                $saved = $this->gru_permiso->create(array_merge($permiso, ['idGrupo' => $grupo->id]));
                if (!$saved)
                    throw new Exception("Error al guardar el registro.", 500);
            endforeach;
        endif;

        return true;
    }

    public function update($data)
    {
        $this->delete($data['idGrupo']);
        return $this->save($data);
    }

    public function delete($id)
    {
        return $this->gru_permiso->getGrupo($id)->delete();
    }

    public function getGruPermiso($id)
    {
        return $this->gru_permiso->existe($id)
            ->first();
    }
}
