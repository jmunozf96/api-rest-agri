<?php

namespace App\Http\Controllers;

use App\Http\Requests\SegTipoModuloRequest;
use App\Repositories\seg_tipoModulo\ISegTipoModuloRepository;
use Exception;

class SegTipoModuloController extends Controller
{
    protected $tipo_modulo;

    public function __construct(ISegTipoModuloRepository $tipo_modulo)
    {
        $this->middleware('user_access');
        $this->tipo_modulo = $tipo_modulo;
    }

    public function index()
    {
        try {
            $data = $this->tipo_modulo->all();

            $message = count($data) > 0 ? 'devuelve registros.' : 'no hay registros.';

            return response()->json([
                'type' => 'success', 'message' => 'Consulta ejecutada con éxito, ' . $message,
                'data' => $data
            ], 200);
        } catch (Exception $ex) {
            return response()->json(['type' => 'error', 'message' => $ex->getMessage()], $ex->getCode());
        }
    }

    public function save(SegTipoModuloRequest $request)
    {
        try {
            $response = $this->tipo_modulo->save($request->validated());
            if ($response) :
                return response()->json([
                    'type' => 'success',
                    'message' => 'Registro guardado con éxito.',
                    'data' => $response
                ], 200);
            endif;

            throw new Exception('No se puedo procesar el registro.', 500);
        } catch (Exception $ex) {
            return response()->json(['type' => 'error', 'message' => $ex->getMessage()], 500);
        }
    }

    public function update(SegTipoModuloRequest $request, $id)
    {
        try {
            $response = $this->tipo_modulo->update(array_merge($request->input(), ['id' => $id]));
            if ($response) :
                return response()->json([
                    'type' => 'success',
                    'message' => 'Registro actualizados con éxito.'
                ], 200);
            endif;

            throw new Exception('No se puedo procesar el registro.', 500);
        } catch (Exception $ex) {
            return response()->json(['type' => 'error', 'message' => $ex->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
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