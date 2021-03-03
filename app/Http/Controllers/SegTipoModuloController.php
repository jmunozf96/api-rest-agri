<?php

namespace App\Http\Controllers;

use App\Http\Requests\SegTipoModuloRequest;
use App\Repositories\seg_tipoModulo\ISegTipoModuloRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SegTipoModuloController extends Controller
{
    protected $tipo_modulo;

    public function __construct(ISegTipoModuloRepository $tipo_modulo)
    {
        $this->middleware('user_access');
        $this->tipo_modulo = $tipo_modulo;
    }

    public function index(Request $request)
    {
        try {
            $paginate = $request->get('paginate');

            if ($paginate && filter_var($paginate, FILTER_VALIDATE_BOOL)) :
                $data = $this->tipo_modulo->all();
            else :
                $data = $this->tipo_modulo->getAllTipos();
            endif;


            $message = count($data) > 0 ? 'devuelve registros.' : 'no hay registros.';

            return response()->json([
                'type' => 'success', 'message' => 'Consulta ejecutada con éxito, ' . $message,
                'response' => $data
            ], 200);
        } catch (Exception $ex) {
            return response()->json(['type' => 'error', 'message' => $ex->getMessage()], $ex->getCode());
        }
    }

    public function save(SegTipoModuloRequest $request)
    {
        try {
            DB::beginTransaction();
            $response = $this->tipo_modulo->save($request->validated());
            if ($response) :
                DB::commit();
                return response()->json([
                    'type' => 'success',
                    'message' => 'Registro guardado con éxito.',
                    'data' => $response
                ], 200);
            endif;

            throw new Exception('No se puedo procesar el registro.', 500);
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(['type' => 'error', 'message' => $ex->getMessage()], 500);
        }
    }

    public function update(SegTipoModuloRequest $request, $id)
    {
        try {
            $tipo_modulo = $this->tipo_modulo->getTipoModulo($id);

            if (!$tipo_modulo)
                throw new Exception('No se encontro el registro', 404);

            DB::beginTransaction();;
            $response = $this->tipo_modulo->update(array_merge(
                $request->only('nombre', 'descripcion'),
                ['id' => $id]
            ));

            if ($response) :
                DB::commit();
                return response()->json([
                    'type' => 'success',
                    'message' => 'Registro actualizados con éxito.'
                ], 200);
            endif;

            throw new Exception('No se puedo actualizar el registro.', 500);
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(['type' => 'error', 'message' => $ex->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $tipo_modulo = $this->tipo_modulo->getTipoModulo($id);

            if (!$tipo_modulo)
                throw new Exception('No se encontro el registro', 404);

            $response = $this->tipo_modulo->delete($id);

            if ($response) :
                return response()->json([
                    'type' => 'success',
                    'message' => 'Registro eliminado con éxito.'
                ], 200);
            endif;

            throw new Exception('No se puedo eliminar el registro.', 500);
        } catch (Exception $ex) {
            return response()->json(['type' => 'error', 'message' => $ex->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $response = $this->tipo_modulo->getTipoModulo($id);
            if ($response) :
                return response()->json([
                    'type' => 'success',
                    'message' => 'Registro encontrado con éxito.',
                    'data' => $response
                ], 200);
            endif;

            throw new Exception('No existe el registro.', 500);
        } catch (Exception $ex) {
            return response()->json(['type' => 'error', 'message' => $ex->getMessage()], 500);
        }
    }
}
