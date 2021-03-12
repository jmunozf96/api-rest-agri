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
    private $time_expire;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->time_expire = 60;
    }

    public function login(array $credentials)
    {
        Auth::factory()->setTTL($this->time_expire);
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
            'access_modules' => $this->getModulesAccess(Auth::id()),
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ];
    }

    public function getModulesAccess($idUser)
    {
        $modulos = array();
        $grupos = SegUsuPerfil::where('idUsuario', $idUser)
            ->join('SEG_GRUPO', 'SEG_USUPERFIL.idGrupo', '=', 'SEG_GRUPO.id')
            ->orderBy('SEG_GRUPO.nombre')
            ->get();

        foreach ($grupos as $grupo) :
            $modulos_access = SegTipoModulo::select('id', 'nombre')
                ->with(['modules' => function ($query) use ($grupo) {
                    $query->select('id', 'idTModulo', 'nombre', 'icon', 'url');
                    $query->with(['permisos' => function ($query) use ($grupo) {
                        $query->select('id', 'idGrupo', 'idModulo', 'view', 'read', 'write', 'update', 'delete');
                        $query->where('idGrupo', $grupo->idGrupo);
                    }]);
                    $query->whereHas('permisos', function ($query) use ($grupo) {
                        $query->where('idGrupo', $grupo->idGrupo);
                    });
                }])->whereHas('modules')->get();

            array_push($modulos, [
                'grupo' => SegGrupo::select('id', 'nombre')->find($grupo->idGrupo),
                'access' => $modulos_access
            ]);
        endforeach;

        return $modulos;
    }

    public function logout()
    {
        Auth::logout();
    }
}
