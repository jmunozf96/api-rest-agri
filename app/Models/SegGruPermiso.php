<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SegGruPermiso extends Model
{
    use HasFactory;

    protected $table = 'SEG_GRUPERMISO';
    protected $fillable = ['idGrupo', 'idModulo', 'view', 'read', 'write', 'update', 'delete'];

    public function grupo()
    {
        return $this->belongsTo(SegGrupo::class, 'idGrupo', 'id');
    }

    public function modulo()
    {
        return $this->belongsTo(SegModulo::class, 'idModulo', 'id');
    }

    public function scopeExiste($query, $id)
    {
        return $query->where('id', $id);
    }

    public function scopeGetGrupo($query, $idGrupo)
    {
        return $query->where('idGrupo', $idGrupo);
    }

    public function getGrupoPermisos($idGrupo)
    {
        return $this->getGrupo()->get();
    }

    public function getAll()
    {
        return $this->get();
    }
}
