<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SegUsuPerfil extends Model
{
    use HasFactory;

    protected $table = 'SEG_USUPERFIL';

    protected $fillable = ['idGrupo', 'idUsuario'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'idUsuario', 'id');
    }

    public function grupo()
    {
        return $this->belongsTo(SegGrupo::class, 'idGrupo', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('estado', true);
    }

    public function scopeExiste($query, $id)
    {
        return $query->where('idUsuario', $id);
    }

    public function getUsuPerfil($idusuario)
    {
        return $this->existe($idusuario)->get();
    }
}
