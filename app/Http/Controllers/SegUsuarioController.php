<?php

namespace App\Http\Controllers;

use App\Repositories\seg_user\IAuthRepository;
use App\Repositories\seg_user\IUserRepository;
use Exception;
use Illuminate\Http\Request;

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
}
