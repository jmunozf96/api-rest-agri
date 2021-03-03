<?php

namespace App\Repositories\seg_tipoModulo;

use App\Models\SegTipoModulo;

class SegTipoModuloRepository implements ISegTipoModuloRepository
{
    protected $tipo_modulo;

    public function __construct(SegTipoModulo $tipo_modulo)
    {
        $this->tipo_modulo = $tipo_modulo;
    }

    public function all()
    {
        return $this->tipo_modulo->with('modules')->orderBy('id')->paginate(5);
    }

    public function save($data)
    {
        return $this->tipo_modulo->create($data);
    }

    public function update($data)
    {
        return $this->tipo_modulo->existe($data['id'])->update($data);
    }

    public function delete($id)
    {
        return $this->tipo_modulo->destroy($id);
    }

    public function getTipoModulo($id)
    {
        return $this->tipo_modulo->existe($id)->first();
    }

    public function getAllTipos()
    {
        return $this->tipo_modulo
            ->with('modules')
            ->whereHas('modules')
            ->get();
    }
}
