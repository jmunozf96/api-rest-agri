<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Repositories\seg_user\IAuthRepository;
use App\Repositories\seg_user\IUserRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SegUsuarioController extends Controller
{
    private $user;

    public function __construct(IUserRepository $user)
    {
        $this->user = $user;
        $this->middleware('user_access');
    }

    public function index()
    {
        try {
            $data = $this->user->all();

            $message = count($data) > 0 ? 'devuelve registros.' : 'no hay registros.';

            return response()->json([
                'type' => 'success', 'message' => 'Consulta ejecutada con éxito, ' . $message,
                'response' => $data
            ], 200);
        } catch (Exception $ex) {
            return response()->json(['type' => 'error', 'message' => $ex->getMessage()], $ex->getCode());
        }
    }

    public function save(UserRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = $this->user->save(
                array_merge(
                    $request->validated(),
                    ['password' => bcrypt($request->password)]
                )
            );

            if ($user) :
                DB::commit();
                return response()->json([
                    'message' => 'Usuario registrado correctamente.',
                    'user' => $user
                ], 200);
            endif;
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(['type' => 'error', 'message' => $ex->getMessage()], 500);
        }
    }

    public function update(UserRequest $request, $id)
    {
        try {
            $user = $this->user->getUser($id);
            if (!$user)
                throw new Exception('No se encontro el registro', 404);

            DB::beginTransaction();
            $response = $this->user->update(array_merge(
                $request->only('name', 'email'),
                ['password' => bcrypt($request->password)],
                ['id' => $id]
            ));
            if ($response) :
                DB::commit();
                return response()->json([
                    'type' => 'success',
                    'message' => 'Usuario actualizado con éxito.'
                ], 200);
            endif;

            throw new Exception('No se puedo procesar el registro.', 500);
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(['type' => 'error', 'message' => $ex->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $user = $this->user->getUser($id);
            if (!$user)
                throw new Exception('No se encontro el registro', 404);

            DB::beginTransaction();
            $response = $this->user->delete($id);
            if ($response) :
                DB::commit();
                return response()->json([
                    'type' => 'success',
                    'message' => 'Registro eliminado con éxito.'
                ], 200);
            endif;

            throw new Exception('No se puedo eliminar el registro.', 500);
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(['type' => 'error', 'message' => $ex->getMessage()], 500);
        }
    }
}
