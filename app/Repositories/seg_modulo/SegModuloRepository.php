<?php

namespace App\Repositories\seg_modulo;

use App\Models\SegModulo;

class SegModuloRepository implements ISegModuloRepository
{
    protected $modulo;

    public function __construct(SegModulo $modulo)
    {
        $this->modulo = $modulo;
    }

    public function all()
    {
        return $this->modulo->getAll();
    }

    public function save($data)
    {
        return $this->modulo->create($data);
    }

    public function update($data)
    {
        return $this->modulo->existe($data['id'])->update($data);
    }

    public function delete($id)
    {
        $modulo = $this->modulo->existe($id)->first();
        if ($modulo) :
            return $this->modulo->destroy($id);
        endif;

        return false;
    }

    public function getModulo($id)
    {
        return $this->modulo->existe($id)
            ->with('tmodulo')
            ->first();
    }
}
