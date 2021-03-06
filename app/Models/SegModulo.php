<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SegModulo extends Model
{
    use HasFactory;


    protected $table = 'SEG_MODULO';

    protected $fillable = ['idTModulo', 'nombre', 'descripcion', 'url', 'icon'];

    public function tmodulo()
    {
        return $this->hasOne(SegTipoModulo::class, 'id', 'idTModulo');
    }

    public function permisos()
    {
        return $this->hasOne(SegGruPermiso::class, 'idModulo', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('estado', true);
    }

    public function scopeExiste($query, $id)
    {
        return $query->where('id', $id);
    }

    public function scopeTmodulo($query)
    {
        return $query->whereHas('tmodulo')->with('tmodulo', function ($query) {
            $query->select('id', 'nombre', 'descripcion');
        });
    }

    public function getAll()
    {
        return $this->active()
            ->tmodulo()
            ->get();
    }
}
