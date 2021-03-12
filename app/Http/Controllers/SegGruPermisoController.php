<?php

namespace App\Http\Controllers;

use App\Http\Requests\SegGruPermisoRequest;
use App\Repositories\seg_grupermiso\ISegGruPermisoRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class SegGruPermisoController extends Controller
{
    protected $permiso;

    public function __construct(ISegGruPermisoRepository $permiso)
    {
        $this->permiso = $permiso;
        $this->middleware('user_access');
    }

    public function save(SegGruPermisoRequest $request)
    {
        try {
            DB::beginTransaction();
            $response = $this->permiso->update($request->validated());
            if ($response) :
                DB::commit();
                return response()->json([
                    'type' => 'success',
                    'message' => 'Permisos registrados con éxito.',
                    'data' => $response
                ], 200);
            endif;

            throw new Exception('No se puedo procesar la información.', 500);
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(['type' => 'error', 'message' => $ex->getMessage()], 500);
        }
    }
}
