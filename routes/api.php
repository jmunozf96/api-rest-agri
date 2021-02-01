<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SegGruPermisoController;
use App\Http\Controllers\SegGrupoController;
use App\Http\Controllers\SegModuloController;
use App\Http\Controllers\SegTipoModuloController;
use App\Http\Controllers\SegUsuarioController;
use App\Http\Controllers\SegUsuPerfilController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::group(['prefix' => 'agrisoft/index.php'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/user-profile', [AuthController::class, 'userProfile']);
    });

    Route::group(['prefix' => 'security'], function () {
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [SegUsuarioController::class, 'index']);
        });

        Route::group(['prefix' => 'group'], function () {
            Route::get('/', [SegGrupoController::class, 'index']);
            Route::post('/', [SegGrupoController::class, 'save']);
            Route::patch('/{id}', [SegGrupoController::class, 'update']);
            Route::delete('/{id}', [SegGrupoController::class, 'delete']);
            Route::get('/search/{id}', [SegGrupoController::class, 'show']);
        });

        Route::group(['prefix' => 'typeModule'], function () {
            Route::get('/', [SegTipoModuloController::class, 'index']);
            Route::post('/', [SegTipoModuloController::class, 'save']);
            Route::patch('/{id}', [SegTipoModuloController::class, 'update']);
            Route::delete('/{id}', [SegTipoModuloController::class, 'delete']);
            Route::get('/search/{id}', [SegTipoModuloController::class, 'show']);
        });

        Route::group(['prefix' => 'module'], function () {
            Route::get('/', [SegModuloController::class, 'index']);
            Route::post('/', [SegModuloController::class, 'save']);
            Route::patch('/{id}', [SegModuloController::class, 'update']);
            Route::delete('/{id}', [SegModuloController::class, 'delete']);
            Route::get('/search/{id}', [SegModuloController::class, 'show']);
        });

        Route::group(['prefix' => 'group_permission'], function () {
            Route::post('/', [SegGruPermisoController::class, 'save']);
            Route::patch('/{id}', [SegGruPermisoController::class, 'update']);
        });

        Route::group(['prefix' => 'user_profile'], function () {
            Route::post('/', [SegUsuPerfilController::class, 'save']);
            Route::patch('/{id}', [SegUsuPerfilController::class, 'update']);
        });
    });
});
