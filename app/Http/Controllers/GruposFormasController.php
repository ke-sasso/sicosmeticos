<?php

namespace App\Http\Controllers;
use App\Models\GruposFormas;
use App\Models\ClasificacionCos;
use Auth;
use Session;
use Illuminate\Http\Request;
use Redirect;
use Yajra\Datatables\Datatables;

class GruposFormasController extends Controller
{
	public function getGrupoFormas(Request $request){
		 	return GruposFormas::getGrupos($request->id);

	}
}