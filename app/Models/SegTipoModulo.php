<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SegTipoModulo extends Model
{
    use HasFactory;

    protected $table = 'SEG_TIPOMODULO';

    protected $fillable = ['nombre', 'descripcion'];

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
