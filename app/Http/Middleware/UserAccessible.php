<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserAccessible
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$request->header("authorization")){
            return response()->json([
                "status" => "error",
                "messagge" => "No se ha enviado token de identificación."
            ], 403);
        }

        $user = auth()->user();

        if (!$user) {
            return response()->json([
                "status" => "error",
                "type" => "token_expired",
                "messagge" => "El usuario no se ha identificado."
            ], 403);
        }

        return $next($request);
    }
}
