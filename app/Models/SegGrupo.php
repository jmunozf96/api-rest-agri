<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SegGrupo extends Model
{
    use HasFactory;

    protected $table = 'SEG_GRUPO';

    protected $fillable = ['nombre', 'descripcion'];

    public function permisos()
    {
        return $this->hasMany(SegGruPermiso::class, 'idGrupo', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('estado', true);
    }

    public function scopeExiste($query, $id)
    {
        return $query->where('id', $id);
    }

    public function getAll()
    {
        return $this->active()->get();
    }
}
