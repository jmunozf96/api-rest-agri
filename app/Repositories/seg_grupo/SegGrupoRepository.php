<?php

namespace App\Repositories\seg_grupo;

use App\Models\SegGrupo;

class SegGrupoRepository implements ISegGrupoRepository
{

    protected $grupo;

    public function __construct(SegGrupo $grupo)
    {
        $this->grupo = $grupo;
    }

    public function all()
    {
        //Retorna todos los grupos existentes en la base de datos, que esten activos
        return $this->grupo
            ->with(['permisos' => function ($query) {
                $query->select('idGrupo', 'idModulo', 'view', 'read', 'write', 'update', 'delete');
            }])
            ->orderBy('updated_at', 'desc')
            ->paginate(5);
    }

    public function save($data)
    {
        //Guarda los grupos en la base de datos
        return $this->grupo->create($data);
    }

    public function update($data)
    {
        return $this->grupo->existe($data['id'])->update($data);
    }

    public function delete($id)
    {
        $grupo = $this->grupo->existe($id)->first();
        if ($grupo) :
            return $this->grupo->destroy($id);
        endif;

        return false;
    }

    public function getGrupo($id)
    {
        return $this->grupo->existe($id)->first();
    }

    public function getAllGrupos()
    {
        return $this->grupo->active()->get();
    }
}
