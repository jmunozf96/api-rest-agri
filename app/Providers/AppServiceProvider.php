<?php

namespace App\Providers;

use App\Repositories\seg_grupo\ISegGrupoRepository;
use App\Repositories\seg_grupo\SegGrupoRepository;
use App\Repositories\seg_tipoModulo\ISegTipoModuloRepository;
use App\Repositories\seg_tipoModulo\SegTipoModuloRepository;
use App\Repositories\seg_user\AuthRepository;
use App\Repositories\seg_user\IAuthRepository;
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
        $this->app->bind(ISegGrupoRepository::class, SegGrupoRepository::class);
        $this->app->bind(ISegTipoModuloRepository::class, SegTipoModuloRepository::class);
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
