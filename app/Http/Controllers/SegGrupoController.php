<?php

namespace App\Http\Controllers;

use App\Http\Requests\SegGrupoRequest;
use App\Repositories\seg_grupo\ISegGrupoRepository;
use Exception;

class SegGrupoController extends Controller
{
    protected $grupo;

    public function __construct(ISegGrupoRepository $grupo)
    {
        $this->middleware('user_access');
        $this->grupo = $grupo;
    }

    public function index()
    {
        try {
            $data = $this->grupo->all();

            $message = count($data) > 0 ? 'devuelve registros.' : 'no hay registros.';

            return response()->json([
                'type' => 'success', 'message' => 'Consulta ejecutada con éxito, ' . $message,
                'data' => $data
            ], 200);
        } catch (Exception $ex) {
            return response()->json(['type' => 'error', 'message' => $ex->getMessage()], $ex->getCode());
        }
    }

    public function save(SegGrupoRequest $request)
    {
        try {
            $response = $this->grupo->save($request->validated());
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

    public function update(SegGrupoRequest $request, $id)
    {
        try {
            $response = $this->grupo->update(array_merge($request->input(), ['id' => $id]));
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
            $response = $this->grupo->delete($id);
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
            $response = $this->grupo->getGrupo($id);
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
