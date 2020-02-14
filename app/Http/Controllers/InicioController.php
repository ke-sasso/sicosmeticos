<?php namespace App\Http\Controllers;

use App;
use Session;
use App\Models\establecimientos;
use App\Models\dnm_sesiones_si\ses\sesiones;
use App\Models\dnm_sesiones_si\ses\sesion_detalle;
use App\Models\dnm_establecimientos_si\est\solicitudes_establecimientos;
use Illuminate\Http\Request;
use DB;
use Datatables;
use Auth;
use Debugbar;
class InicioController extends Controller {

	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
		
	}
	/**
	 * Muestra el Inicio de la aplicacion (Dashboard).
	 *
	 * @return Response
	 */
	public function index()
	{
		$data = ['title' 			=> 'Inicio' 
				,'subtitle'			=> ''
				,'breadcrumb' 		=> [
			 		['nom'	=>	'', 'url' => '#']
				]];

        if(Auth::check()){
            return view('inicio.index',$data);
        }else{

            Debugbar::disable();

            return view('users.login');
        }

	}

	/**
	 * Cambia configuración para ocultar menú lateral.
	 *
	 * @return void
	 */
	public function cfgHideMenu()
	{
		$cfgHideMenu = Session::get('cfgHideMenu',false);
		$cfgHideMenu = ($cfgHideMenu)?false:true;
		Session::put('cfgHideMenu',$cfgHideMenu);
	}
	
}