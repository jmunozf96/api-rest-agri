<?php

namespace App\Repositories\seg_grupermiso;

use App\Models\SegGruPermiso;

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
        return $this->gru_permiso->create($data);
    }

    public function update($data)
    {
        return $this->gru_permiso->existe($data['id'])->update($data);
    }

    public function delete($id)
    {
        return $this->gru_permiso->destroy($id);
    }

    public function getGruPermiso($id)
    {
        return $this->gru_permiso->existe($id)
            ->first();
    }
}
