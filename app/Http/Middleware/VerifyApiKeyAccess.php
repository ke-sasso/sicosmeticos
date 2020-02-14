<?php
/**
 * Created by PhpStorm.
 * User: steven.mena
 * Date: 4/7/2018
 * Time: 9:55 AM
 */
namespace App\Http\Middleware;

use Closure;
use Request;
use Hash;


class VerifyApiKeyAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Obtenemos el api-key que el usuario envia
        $key = Request::header('tk');
        //dd($key);
        // Si coincide con el valor almacenado en la aplicacion
        // la aplicacion se sigue ejecutando
        if ($key==env('API_KEY')) {
            return $next($request);
        } else {
            // Si falla devolvemos el mensaje de error
            return response()->json(['status' => 401, 'message' => 'unauthorized'], 401);
        }
    }
}