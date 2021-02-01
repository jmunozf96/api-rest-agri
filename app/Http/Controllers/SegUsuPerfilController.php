<?php

namespace App\Http\Controllers;

use App\Http\Requests\SegUsuPerfilRequest;
use App\Repositories\seg_usuperfil\ISegUsuPerfilRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SegUsuPerfilController extends Controller
{
    protected $perfil;

    public function __construct(ISegUsuPerfilRepository $perfil)
    {
        $this->perfil = $perfil;
        $this->middleware('user_access');
    }

    public function save(SegUsuPerfilRequest $request)
    {
        try {
            DB::beginTransaction();
            $response = $this->perfil->update($request->validated());
            if ($response) :
                DB::commit();
                return response()->json([
                    'type' => 'success',
                    'message' => 'Perfil guardado con éxito.',
                    'data' => $response
                ], 200);
            endif;

            throw new Exception('No se puedo procesar el perfil.', 500);
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(['type' => 'error', 'message' => $ex->getMessage()], 500);
        }
    }
}
