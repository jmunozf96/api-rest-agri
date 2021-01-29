<?php

namespace App\Http\Controllers;

use App\Http\Requests\SegModuloRequest;
use App\Repositories\seg_modulo\ISegModuloRepository;
use Exception;

class SegModuloController extends Controller
{
    protected $modulo;

    public function __construct(ISegModuloRepository $modulo)
    {
        $this->modulo = $modulo;
        $this->middleware('user_access');
    }

    public function index()
    {
        try {
            $data = $this->modulo->all();

            $message = count($data) > 0 ? 'devuelve registros.' : 'no hay registros.';

            return response()->json([
                'type' => 'success', 'message' => 'Consulta ejecutada con éxito, ' . $message,
                'data' => $data
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                'type' => 'error',
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    public function save(SegModuloRequest $request)
    {
        try {
            $response = $this->modulo->save($request->validated());
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

    public function update(SegModuloRequest $request, $id)
    {
        try {
            $modulo = $this->modulo->getModulo($id);

            if (!$modulo)
                throw new Exception('No se encontro el registro', 404);

            $response = $this->modulo->update(array_merge(
                $request->only('descripcion','url','icon'),
                ['id' => $id]
            ));

            if ($response) :
                return response()->json([
                    'type' => 'success',
                    'message' => 'Registro actualizados con éxito.'
                ], 200);
            endif;

            throw new Exception('No se puedo actualizar el registro.', 500);
        } catch (Exception $ex) {
            return response()->json(['type' => 'error', 'message' => $ex->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $modulo = $this->modulo->getModulo($id);

            if (!$modulo)
                throw new Exception('No se encontro el registro', 404);

            $response = $this->modulo->delete($id);
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
            $response = $this->modulo->getModulo($id);
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
