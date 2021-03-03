<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'SEG_USUARIO';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }


    public function getJWTCustomClaims()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'permisos' => $this->getModulesAccess($this->id)
        ];
    }

    public function perfil()
    {
        return $this->hasMany(SegUsuPerfil::class, 'idUsuario', 'id');
    }

    public function scopeExiste($query, $id)
    {
        return $query->where('id', $id);
    }

    public function getModulesAccess($idUser)
    {
        $modulos = array();
        $grupos = SegUsuPerfil::where('idUsuario', $idUser)->get();

        foreach ($grupos as $grupo) :
            $modulos_access = SegTipoModulo::with(['modules' => function ($query) use ($grupo) {
                $query->whereHas('permisos', function ($query) use ($grupo) {
                    $query->where('idGrupo', $grupo->idGrupo);
                });
            }])->whereHas('modules.permisos')->get();

            array_push($modulos, ['grupo' => SegGrupo::find($grupo->idGrupo), 'access' => $modulos_access]);
        endforeach;

        return $modulos;
    }
}
