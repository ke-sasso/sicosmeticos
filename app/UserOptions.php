<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;

class UserOptions extends Model {

	protected $table = 'dnm_catalogos.sys_usuario_roles';
	protected $primaryKey = ['codUsuario','codOpcion'];
	protected $timestap = false;
	public  $incrementing =  false;
	protected $connection = 'mysql';
	public static function vrfOpt($id_opcion){
		if (UserOptions::where('codUsuario',Auth::user()->idUsuario)->whereIn('codOpcion',[$id_opcion,0])->count() > 0)
			return true;
		else
			return false;
	}

	public static function verifyOption($id_usuario,$id_opcion){
		if (UserOptions::where('codUsuario',$id_usuario)->where('codOpcion',[$id_opcion,0])->count() > 0)
			return true;
		else
			return false;
	}

	public static function getAutUserOptions(){
		#return
		$opciones = UserOptions::join('dnm_catalogos.sys_opciones','codOpcion','=','idOpcion')
		->where('codUsuario',Auth::user()->idUsuario)->pluck('codOpcion')->toArray();
		/*$return = array();
		foreach ($opciones as $key => $value) {
			dd($value->codOpcion);
		}*/
		return $opciones;
	}

	public function usuario()
	{
		return $this->belongsTo('App\User','codUsuario','idUsuario');
	}

}
