<?php

namespace App\Http\Controllers;

use App\Http\Requests\SegGruPermisoRequest;
use App\Repositories\seg_grupermiso\ISegGruPermisoRepository;
use Exception;

class SegGruPermisoController extends Controller
{
    protected $permiso;

    public function __construct(ISegGruPermisoRepository $permiso)
    {
        $this->permiso = $permiso;
    }

    public function save(SegGruPermisoRequest $request)
    {
        try {
            return response()->json($request->validated());
            /* if ($response) :
                return response()->json([
                    'type' => 'success',
                    'message' => 'Registro guardado con éxito.',
                    'data' => $response
                ], 200);
            endif; */

            throw new Exception('No se puedo procesar la información.', 500);
        } catch (Exception $ex) {
            return response()->json(['type' => 'error', 'message' => $ex->getMessage()], 500);
        }
    }
}
