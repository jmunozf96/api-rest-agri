<?php

namespace App\Repositories\seg_user;

use App\Models\SegGrupo;
use App\Models\SegTipoModulo;
use App\Models\SegUsuPerfil;
use App\Repositories\seg_user\IAuthRepository;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class AuthRepository implements IAuthRepository
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login(array $credentials)
    {
        return Auth::attempt($credentials);
    }

    public function refresh()
    {
        return Auth::refresh();
    }

    public function userProfile()
    {
        return Auth::user();
    }

    public function getToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ];
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

    public function logout()
    {
        Auth::logout();
    }
}
