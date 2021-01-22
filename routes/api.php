<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SegGrupoController;
use App\Http\Controllers\SegTipoModuloController;
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

Route::group(['prefix' => 'agrisoft'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/user-profile', [AuthController::class, 'userProfile']);
    });

    Route::group(['prefix' => 'seg_group'], function () {
        Route::get('/', [SegGrupoController::class, 'index']);
        Route::post('/', [SegGrupoController::class, 'save']);
        Route::patch('/{id}', [SegGrupoController::class, 'update']);
        Route::delete('/{id}', [SegGrupoController::class, 'delete']);
        Route::get('/search/{id}', [SegGrupoController::class, 'show']);
    });

    Route::group(['prefix' => 'seg_tmodule'], function () {
        Route::get('/', [SegTipoModuloController::class, 'index']);
        Route::post('/', [SegTipoModuloController::class, 'save']);
        Route::patch('/{id}', [SegTipoModuloController::class, 'update']);
        Route::delete('/{id}', [SegTipoModuloController::class, 'delete']);
        Route::get('/search/{id}', [SegTipoModuloController::class, 'show']);
    });
});
