<?php

namespace App\Repositories\seg_usuperfil;

use App\Models\SegUsuPerfil;
use App\Models\User;
use Exception;

class SegUsuPerfilRepository implements ISegUsuPerfilRepository
{
    protected $perfil;

    public function __construct(SegUsuPerfil $perfil)
    {
        $this->perfil = $perfil;
    }

    public function all()
    {
        return [];
    }

    public function save($data)
    {
        $usuario = User::where('id', $data['idUsuario'])->firstOrFail();
        if ($usuario) :
            $grupos = $data['grupos'];
            foreach ($grupos as $grupo) :
                $saved = $this->perfil->create(array_merge($grupo, ['idUsuario' => $usuario->id]));
                if (!$saved)
                    throw new Exception("Error al guardar el registro.", 500);
            endforeach;
        endif;

        return true;
    }

    public function update($data)
    {
        $this->delete($data['idUsuario']);
        return $this->save($data);
    }

    public function delete($id)
    {
        return $this->perfil->existe($id)->delete();
    }

    public function getUsuPerfil($idUsuario)
    {
        return $this->perfil->existe($idUsuario)
            ->with('tperfil')
            ->first();
    }
}
