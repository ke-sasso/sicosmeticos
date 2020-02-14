<?php namespace App\Http\Middleware;

use Closure;
use Session;
use Auth;
use Debugbar;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Artisan;
class VerifyPermissions {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next,$permissions = null)
    {
        Artisan::call('cache:forget', ['key' => 'spatie.permission.cache']); //Permite refrescar los permisos del usuario
        $permit = $permissions; // Guardo el string completo de los permisos, para uso en la vista del sistema
        if ($request->user()->hasRole('admin_it'))
            return $next($request);
        if(!is_array($permissions))
            $permissions = explode('|',$permissions);
        /**
         *  Validación de Estado de la sesión del usuario
         */
            if (!Auth::check()) {
                if ($request->ajax())
                    return response()->json(['status' => 401, 'message' => "Sesión Expirada", "redirect" => '/login']);
                else {
                    return view('users.login');
                }
            }

            if (!$request->user()->hasAnyPermission($permissions) || is_null($permissions)) {
                if ($request->ajax()) {
                    return response()->json(['status' => 401, 'message' => "No posee los privilegios $permit para realizar esta acción", "redirect" => '']);
                } else {
                    return response()->view('errors.401',['permissions' => $permit]);
                }
            }

            return $next($request);

    }
}
