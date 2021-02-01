<?php

namespace App\Providers;

use App\Repositories\seg_grupermiso\ISegGruPermisoRepository;
use App\Repositories\seg_grupermiso\SegGruPermisoRepository;
use App\Repositories\seg_grupo\ISegGrupoRepository;
use App\Repositories\seg_grupo\SegGrupoRepository;
use App\Repositories\seg_modulo\ISegModuloRepository;
use App\Repositories\seg_modulo\SegModuloRepository;
use App\Repositories\seg_tipoModulo\ISegTipoModuloRepository;
use App\Repositories\seg_tipoModulo\SegTipoModuloRepository;
use App\Repositories\seg_user\AuthRepository;
use App\Repositories\seg_user\IAuthRepository;
use App\Repositories\seg_user\IUserRepository;
use App\Repositories\seg_user\UserRepository;
use App\Repositories\seg_usuperfil\ISegUsuPerfilRepository;
use App\Repositories\seg_usuperfil\SegUsuPerfilRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IAuthRepository::class, AuthRepository::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(ISegGrupoRepository::class, SegGrupoRepository::class);
        $this->app->bind(ISegTipoModuloRepository::class, SegTipoModuloRepository::class);
        $this->app->bind(ISegModuloRepository::class, SegModuloRepository::class);
        $this->app->bind(ISegGruPermisoRepository::class, SegGruPermisoRepository::class);
        $this->app->bind(ISegUsuPerfilRepository::class, SegUsuPerfilRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
