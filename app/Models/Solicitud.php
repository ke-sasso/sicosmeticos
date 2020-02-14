<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use DB;

class Solicitud extends Model
{
	protected $connection = 'sqlsrv';
	protected $table = 'dnm_cosmeticos_si.SOL.solicitudes';
	protected $fillable = [];
	protected $primaryKey='idSolicitud';
	CONST CREATED_AT = 'fechaCreacion';
	CONST UPDATED_AT = 'fechaModificacion';




	public function getFechaCreacionAttribute()
    {
        return (date_create($this->attributes['fechaCreacion'])->format('d-m-Y'));
    }

	public function getDateFormat(){
	    return 'Y-m-d H:i:s';
	}
	public function tipotramite(){
		return $this->belongsTo('App\Models\TiposTramites', 'tipoSolicitud', 'idTramite');
	}

	public function fabricante(){
		return $this->hasMany('App\Models\SolicitudFabricantes', 'idSolicitud', 'idSolicitud');
	}

	public function detallesolicitud(){
		return $this->hasOne('App\Models\SolicitudesDetalle', 'idSolicitud', 'idSolicitud');
	}

	public function tonos(){
		return $this->hasMany('App\Models\SolicitudesTonos', 'idSolicitud', 'idSolicitud');
	}

	public function fragancias(){
		return $this->hasMany('App\Models\SolicitudesFragancias', 'idSolicitud', 'idSolicitud');
	}

	public function historialAsignaciones()
	{
		return $this->hasMany('App\Models\SolicitudesPre\HistorialAsignacion','idSolicitud','idSolicitud');
	}

	 public function formulaCos(){
        return $this->hasMany('App\Models\FormulaCosmetico', 'idSolicitud', 'idSolicitud');
    }

    public function formulaHig(){
        return $this->hasMany('App\Models\FormulaHigienico', 'idSolicitud', 'idSolicitud');
    }
    public function asignacion(){
        return $this->hasMany('App\Models\SolicitudesPre\AsignacionSolPre','idSolicitud','idSolicitud');
    }

    public function detalleDocumentos(){
        return $this->belongsToMany('App\Models\DetalleDocumentos','dnm_cosmeticos_si.SOL.documentosSol','idSolicitud','idDetalleDoc')
                ->withPivot('idItemDoc');
	}
	public function distribuidores(){
		return $this->hasMany('App\Models\Distribuidores', 'idSolicitud', 'idSolicitud');
	}
	public function presentaciones(){
		return $this->hasMany('App\Models\SolicitudesPresentaciones', 'idSolicitud', 'idSolicitud');
	}
	public function importadores(){
		return $this->hasMany('App\Models\Importadores', 'idSolicitud', 'idSolicitud');
	}
	public function profesional(){
		return $this->hasOne('App\Models\Importadores', 'idSolicitud', 'idSolicitud');
	}

	public static function getNombreTramite($id){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.tiposTramites as t')
		->select('t.nombreTramite')->where('t.idTramite',$id)->get();
	}

	public static function getTramites(){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.tiposTramites')
				->select('idTramite','nombreTramite')->where('estado','A')->get();
	}



/*	public static function getClasificacionHig(){
		$items="";
		$class=DB::connection('sqlsrv')->table('dnm_cosmeticos_si.HIG.clasificacion')
		->select('idClasificacion','nombreClasificacion', 'poseeFragancia', 'poseeTono')->where('estado','A')->get();
		$items.="<option></option>";
		foreach ($class as $c ) {
			$items.="<option value='".$c->idClasificacion."'>".$c->nombreClasificacion."</option>";
		}
		return $items;
	}*/
	public static function getPaisesCA(){
		$pais=DB::connection('sqlsrv')->table('dnm_catalogos.cat.paises')
		->select('idPais','nombre','codigoId')->where('activo','A')
		->whereIn('codigoPais',['GT','NI','HN','CR','PA'])->get();
		return $pais;
	}

	public static function getPaises(){
		$items="";
		$items.="<option></option>";
		$pais=DB::connection('sqlsrv')->table('dnm_catalogos.cat.paises')
		->select('idPais','nombre','codigoId')->where('activo','A')
		->whereIn('codigoPais',['GT','NI','HN','CR','PA'])->get();
		foreach ($pais as $p) {
			$items .="<option value='".$p->codigoId."'>".$p->nombre."</option>";
		}
		return $items;
	}

	public static function getDepartamentos(){
		$items="";
		$items.="<option></option>";
		$dep=DB::table('dnm_catalogos.cat_departamentos')
		->select('idDepartamento','nombreDepartamento')->where('estado','A')->get();
		foreach($dep as $d){
			$items .="<option value='".$d->idDepartamento."'>".$d->nombreDepartamento."</option>";
		}
		return $items;
	}

	public static function getMunicipios($idDep){
		$items="";
		$items.="<option></option>";
		$municipios=DB::table('dnm_catalogos.cat_municipios')
		->select('idMunicipio','nombreMunicipio')->where('idDepartamento',$idDep)->where('estado','A')->get();
		foreach($municipios as $m){
			$items .="<option value='".$m->idMunicipio."'>".$m->nombreMunicipio."</option>";
		}
		return $items;
	}

	public static function getTratamientos(){
		$items="";
		$items.="<option></option>";
		$tratamientos=DB::table('dnm_catalogos.cat_tratamiento')
		->select('idTipoTratamiento','abreviaturaTratamiento')->get();
		foreach($tratamientos as $t){
			$items.="<option value='".$t->idTipoTratamiento."'>".$t->abreviaturaTratamiento."</option>";
		}
		return $items;
	}


	public static function getFormulasCosmeticos($denominacion){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.CAT.formulaINCI')
		->select('idDenominacion','numeroCAS','denominacionINCI')
		->where('numeroCAS','like','%'.$denominacion.'%')
		->orWhere('denominacionINCI','like','%'.$denominacion.'%')
		->where('estado','A')->take(25)->get();
	}

	public static function getFormulasHigienicos($denominacion){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.CAT.formulaHig')
		->select('idDenominacion','numeroCAS','nombreSustancia as denominacionINCI')
		->where('numeroCAS','like','%'.$denominacion.'%')
		->orWhere('nombreSustancia','like','%'.$denominacion.'%')
		->where('estado','A')->take(25)->get();
	}

	public static function buscarSustanciaPorId($id){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.CAT.formulaINCI')
		->select('idDenominacion','numeroCAS','denominacionINCI')
		->where('idDenominacion',$id)->get();
	}

	public static function buscarSustanciaHigPorId($id){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.CAT.formulaHig')
		->select('idDenominacion','numeroCAS','nombreSustancia')
		->where('idDenominacion',$id)->get();
	}

	/*public static function getClass($id){
		$items="";

		$clas= DB::connection('sqlsrv')->table('dnm_cosmeticos_si.COS.clasificacion')
		->select('idClasificacion','nombreClasificacion')->where('estado','A')
		->where('idArea',$id)->get();
			$items.="<option></option>";
		foreach ($clas as $c) {
			$items .="<option value='".$c->idClasificacion."'>".$c->nombreClasificacion."</option>";
		}
		return $items;

	}*/
	public static function verificarSol($mandamiento){
		return Solicitud::where('estado','!=',10)->where('idMandamiento',$mandamiento)->pluck('idMandamiento');
	}

	public static function getMandamiento($idMandamiento){
		return DB::connection('mysql')->table('cssp.cssp_mandamientos as m')
                ->join('cssp.cssp_mandamientos_detalle as md','md.id_mandamiento','=','m.id_mandamiento')
                ->join('cssp.cssp_mandamientos_recibos as mr','mr.id_mandamiento', '=','m.id_mandamiento')
                ->join('cssp.cssp_tipos_pagos_col as col','col.id_tipo_pago','=','md.id_tipo_pago')
                ->where('m.id_mandamiento',$idMandamiento)
                ->select('md.correlativo','m.id_mandamiento', 'm.id_cliente', 'm.a_nombre', 'm.total', 'md.valor as valorDet', 'col.nombre_tipo_pago', 'mr.fecha', 'mr.total_cobrado')
                ->get();
	}

	public static function getTitulares($nombre){                           //Búsqueda titular nacionale selectize
		return DB::connection('mysql')->table('cssp.cssp_propietarios as pp')
   				 ->select('pp.id_propietario','pp.nombre_propietario')
				 ->where('pp.nombre_propietario','like','%'.$nombre.'%')
				 ->where('pp.ACTIVO','A')->take(10)->get();
	}

	public static function getTitularesJuridico($nombre){                 //Búsqueda titular extranjeros selectize
		return DB::connection('mysql')->table('dnm_catalogos.dnm_persona_juridica as pj')
				->join('dnm_catalogos.dnm_razones_sociales as rs','pj.nitJuridico','rs.nitJuridico')
   				->select('pj.nitJuridico as id_propietario','rs.nombreRazonSocial as nombre_propietario')
				->where('rs.nombreRazonSocial','like','%'.$nombre.'%')
				->where('rs.vigente','A')->take(10)->get();
	}

	public static function getDistribuidores($nombre){
		return DB::connection('mysql')->table('cssp.siic_distribuidores_poderes as dp')
				->join('cssp.cssp_establecimientos as e','dp.ID_DISTRIBUIDOR_MAQUILA','e.ID_ESTABLECIMIENTO')
				->select('dp.ID_DISTRIBUIDOR_MAQUILA','dp.ID_PODER','e.NOMBRE_COMERCIAL')
				->where(function($query){
					$query->where('dp.ESTADO','A')
						  ->where('dp.ESTADO','A')
						  ->where('dp.TIPO_PODER','PD');
				})
				->where(function($query) use($nombre){
					$query->where('e.NOMBRE_COMERCIAL','like','%'.$nombre.'%')
						  ->orWhere('dp.ID_PODER','like','%'.$nombre.'%');
				})
				->take(10)->get();
	}

	public static function getProfesionales($idPoder){
	return DB::connection('mysql')->table('cssp.cssp_profesionales as p')
				 ->Join('cssp.siic_profesionales_poderes as pp','p.ID_PROFESIONAL','pp.ID_PROFESIONAL')
   				 ->select('p.ID_PROFESIONAL','pp.ID_PODER',DB::raw('CONCAT (p.NOMBRES," ",p.APELLIDOS) as NOMBRE_PROFESIONAL'))
   				 ->where('pp.ESTADO','A')
				 ->where('pp.ID_PODER','like','%'.$idPoder.'%')
				 ->orWhere(DB::raw('CONCAT (p.NOMBRES," ",p.APELLIDOS)'),'like','%'.$idPoder.'%')
				 ->take(10)->get();
	}

	/*public static function getProfesionales($idPoder){
	return DB::table('cssp.cssp_profesionales as p')
				 ->Join('cssp.siic_profesionales_poderes as pp','p.ID_PROFESIONAL','pp.ID_PROFESIONAL')
				 ->join('cssp.cssp_propietarios as pro','pp.ID_PROPIETARIO','pro.ID_PROPIETARIO')
   				 ->select('p.ID_PROFESIONAL','pp.ID_PODER',DB::raw('CONCAT (p.NOMBRES," ",p.APELLIDOS) as NOMBRE_PROFESIONAL'))
   				 ->where(function ($query) {
                	$query->where('pp.ESTADO','A')
                      ->where('pro.ACTIVO','A')
                      ->where('p.ACTIVO','A');
            		})
   				 ->where(function ($query) use($idPoder){
                	$query->where('p.NOMBRES','like','%'.$idPoder.'%')
                      ->orWhere('pp.ID_PODER','like','%'.$idPoder.'%')
                      ->orWhere('p.APELLIDOS','like','%'.$idPoder.'%');
            		})
   				 ->get();
	}*/

	/*public static function getProfesionales($idPoder){
		return DB::select("select pp.ID_PODER, CONCAT (prof.NOMBRES,' ',prof.APELLIDOS) as NOMBRE_PROFESIONAL from cssp.siic_profesionales_poderes as pp
			inner join cssp.cssp_profesionales as prof on prof.ID_PROFESIONAL = pp.ID_PROFESIONAL
			inner join cssp.cssp_propietarios as prop on prop.ID_PROPIETARIO = pp.ID_PROPIETARIO
			where (pp.estado = 'A' and prof.ACTIVO = 'A' and prop.ACTIVO = 'A') and (prof.NOMBRES like '%".$idPoder."%' or prof.APELLIDOS like '%".$idPoder."%' or pp.ID_PODER like '%".$idPoder."%')");
	}*/

	public static function getFabricantesNacionales($nombre){
		return DB::connection('mysql')->table('dnm_establecimientos_si.est_establecimientos as e')
				 ->join('dnm_establecimientos_si.est_actividades_establecimiento as act','e.idEstablecimiento','=','act.idEstablecimiento')
   				 ->select('e.idEstablecimiento','e.nombreComercial as nombreFab')
				 ->where('e.nombreComercial','like','%'.$nombre.'%')
				 ->whereIn('act.idActividad',[8,9,10])
				 ->whereIn('e.estado',['A','CS'])->take(10)->get();
	}

	/**
	 * Gets the fabricantes nacionales cos.
	 * Se separa la consulta ya que se obtienen los Fabricantes autorizados según
	 * la Clasificación hecha en la base de estableciimentos, cuando posea
	 * autorizada la actividad para "Elaboración de Productos Cosméticos" o la opción
	 * para elaborar Ambos
	 *
	 * @author     rogelio.menjivar@medicamentos.gob.sv
	 *
	 * @param      string  $nombre  Nombre o parámetro de búsqueda
	 *
	 * @return     Array  Listado de Establecimientos con los datos de idEstablecimiento, nombreComercial.
	 */
	public static function getFabricantesNacionalesCOS($nombre){
		return DB::connection('mysql')->table('dnm_establecimientos_si.est_establecimientos as e')
				 ->join('dnm_establecimientos_si.est_actividades_establecimiento as act','e.idEstablecimiento','=','act.idEstablecimiento')
   				 ->select('e.idEstablecimiento','e.nombreComercial as nombreFab')
				 ->where('e.nombreComercial','like','%'.$nombre.'%')
				 ->whereIn('act.idActividad',[8,10])
				 ->whereIn('e.estado',['A','CS'])->take(10)->get();
	}

	/**
	 * Gets the fabricantes nacionales cos.
	 * Se separa la consulta ya que se obtienen los Fabricantes autorizados según
	 * la Clasificación hecha en la base de estableciimentos, cuando posea
	 * autorizada la actividad para "Elaboración de Productos Higiénicos" o la opción
	 * para elaborar Ambos
	 *
	 * @author     rogelio.menjivar@medicamentos.gob.sv
	 *
	 * @param      string  $nombre  Nombre o parámetro de búsqueda
	 *
	 * @return     Array  Listado de Establecimientos con los datos de idEstablecimiento, nombreComercial.
	 */
	public static function getFabricantesNacionalesHIG($nombre){
		return DB::connection('mysql')->table('dnm_establecimientos_si.est_establecimientos as e')
				 ->join('dnm_establecimientos_si.est_actividades_establecimiento as act','e.idEstablecimiento','=','act.idEstablecimiento')
   				 ->select('e.idEstablecimiento','e.nombreComercial as nombreFab')
				 ->where('e.nombreComercial','like','%'.$nombre.'%')
				 ->whereIn('act.idActividad',[9,10])
				 ->whereIn('e.estado',['A','CS'])->take(10)->get();
	}



	public static function getImportadores($nombre){
		return DB::connection('mysql')->table('dnm_establecimientos_si.est_establecimientos as e')
   				 ->select('e.idEstablecimiento','e.nombreComercial as nombreFab')
				 ->where('e.nombreComercial','like','%'.$nombre.'%')
				 ->whereIn('e.idTipoEstablecimiento',['E29','E01'])
				 ->where('e.estado','A')->take(10)->get();
	}


	/*public static function getFabricantesExtranjeros($nombre){
		return DB::table('cssp.cssp_establecimientos as e')
				 ->join('cssp.siic_cosmeticos_fabricantes as cf','cf.ID_FABRICANTE','e.ID_ESTABLECIMIENTO')
				 ->join('cssp.siic_cosmeticos as c','c.ID_PRODUCTO','cf.ID_PRODUCTO')
				 ->join('cssp.cssp_paises as p','p.ID_PAIS','e.id_pais')
   				 ->select('e.ID_ESTABLECIMIENTO',DB::raw('CONCAT( e.nombre_comercial, " (" ,p.NOMBRE_PAIS,")") as fabricante '))
				 ->where('c.activo','A')
				 ->whereNotIn('p.CODIGO',[222])
				 ->where('e.NOMBRE_COMERCIAL','like','%'.$nombre.'%')
				 ->orderBy('e.NOMBRE_COMERCIAL')->get();
	}*/

	public static function getFabricantesExtranjeros($nombre){
		return DB::connection('mysql')->table('dnm_catalogos.vwfabricantesextrajeros as e')
				 ->select('e.idFabricanteExtranjero as idEstablecimiento',DB::raw('CONCAT( e.nombreFabricante, " (" ,e.nombrePais,")") as nombreFab '))
				 ->where('e.estadoFabricante','A')
				 ->where('e.nombreFabricante','like','%'.$nombre.'%')
				 ->orderBy('e.nombreFabricante')->get();

	}

    public static function getPropietarios($id){                                  //propietarios naturales
    	return DB::connection('mysql')->table('cssp.cssp_propietarios as pp')
    			 ->leftJoin('dnm_catalogos.cat_paises as pais','pp.id_pais','=','pais.idPais')
				 ->select('pp.id_propietario','pp.nombre_propietario','pais.nombre', 'pp.direccion', 'pp.email', 'pp.telefono_1', DB::raw("CASE when pp.activo='A' then
				 	'ACTIVO' else 'INACTIVO' END as estado"))
				 ->where('pp.id_propietario',$id)->get();
    }
    public static function getPropietarioJuridico($nit){
        $prop= DB::connection('mysql')->table('dnm_catalogos.vwpropietarios as pj')
                ->select('pj.nit as id_propietario','pj.nombre as nombre_propietario','pj.direccion','pj.emailsContacto as email',DB::raw("replace(replace(pj.telefonosContacto,'{','['),'}',']') as telefono_1"), DB::raw("CASE when pj.tipoPersona='N' then
				 	'PERSONA NATURAL' else 'PERSONA JURÍDICA' END as estado"))
                ->where('pj.nit',$nit)->get();

                $prop[0]->telefono_1= str_replace('{', '',$prop[0]->telefono_1);
				$prop[0]->telefono_1 = str_replace('}', '', $prop[0]->telefono_1);
				$prop[0]->telefono_1= str_replace('"telefono1":', '', $prop[0]->telefono_1);
				$prop[0]->telefono_1 = str_replace('"telefono2":', '', $prop[0]->telefono_1);
             //  	$tel=json_decode($prop[0]->telefono_1);
                // $prop[0]->telefono_1=$tel[0];
                 return $prop;
             /*DB::raw("replace(replace(pj.telefonosContacto,'{','['),'}',']') as telefono_1")*/
    }

	public static function getEstablecimiento($idFab){
		return DB::connection('mysql')->table('dnm_establecimientos_si.est_establecimientos as e')
		->select('e.idEstablecimiento as idEstablecimiento','e.nombreComercial as nombreFab',DB::raw("replace(replace(telefonosContacto,'{','['),'}',']') as telefonosContacto"), 'e.direccion','e.emailContacto','e.vigenteHasta')
		->where('e.idEstablecimiento',$idFab)->get();
	}

	public static function getDistribuidorByPoder($poder){
		return DB::connection('mysql')->table('cssp.siic_distribuidores_poderes as dp')
				->join('cssp.cssp_establecimientos as e','dp.ID_DISTRIBUIDOR_MAQUILA','e.ID_ESTABLECIMIENTO')
				->select('dp.ID_PODER','e.ID_ESTABLECIMIENTO as idEstablecimiento','e.NOMBRE_COMERCIAL as nombreFab','e.TELEFONO_1 as telefonosContacto', 'e.direccion','e.email as emailContacto')
				->where('dp.ID_PODER',$poder)->get();
	}

	public static function getEstablecimientoExtranjero($idFab){
		return DB::connection('mysql')->table('dnm_catalogos.vwfabricantesextrajeros as e')
		->select('e.idFabricanteExtranjero as idEstablecimiento','e.nombreFabricante as nombreFab','e.telefonos as telefonosContacto', 'e.direccion','e.correoElectronico as emailContacto')
		->where('e.idFabricanteExtranjero',$idFab)->get();
	}

	public static function getProfesional($idPoder){
		return DB::connection('mysql')->table('cssp.cssp_profesionales as p')
		->leftJoin('cssp.siic_profesionales_poderes as pp','p.ID_PROFESIONAL','pp.ID_PROFESIONAL')
		->select('p.ID_PROFESIONAL','p.DUI','p.NIT',DB::raw('CONCAT (p.NOMBRES," ",p.APELLIDOS) as NOMBRE_PROFESIONAL'),'p.TELEFONO_1','p.EMAIL','pp.ID_PODER')
		->where('pp.ID_PODER',$idPoder)->get();
	}


	public static function getItems($idTramite){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.itemsTramites as it')
		->join('dnm_cosmeticos_si.SOL.items as i','it.idItem','i.idItem')
		->select('i.idItem','i.nombreItem')
		->where('i.estado','A')
		->where('it.idTramite',$idTramite)
		->get();
	}

	public static function getNombreItem($idItem){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.itemsTramites as it')
		->join('dnm_cosmeticos_si.SOL.items as i','it.idItem','i.idItem')
		->select('i.nombreItem')
		->where('it.idItem',$idItem)
		->get();
	}

	public static function getUnidades(){
		$items="";
		$unidades =DB::connection('sqlsrv')->table('dnm_cosmeticos_si.CAT.medidas')
		->select('idMedida','abreviatura')
		->get();
		$items.="<option></option>";
		foreach($unidades as $u){
			$items.="<option value='".$u->idMedida."'>".$u->abreviatura."</option>";
		}

		return $items;
	}



	public static function getPersonasNaturales($nombre){
			$persona= DB::connection('mysql')->table('dnm_catalogos.dnm_persona_natural as pn')
   				->select('pn.nitNatural as NIT', DB::raw('CONCAT(pn.nombres," ", pn.apellidos) as NOMBRE_PERSONA'))
   				->where(function($query) use($nombre){
   						$query->where('pn.nombres','LIKE','%'.$nombre.'%')
   						->orWhere('pn.apellidos','LIKE','%'.$nombre.'%')
   						->orWhere('pn.nitNatural','LIKE','%'.$nombre.'%');
   				})
				->where('pn.estado','A')->take(10)->get();

				return $persona;

	}

	public static function getPersonaN($nit){
		$persona= DB::connection('mysql')->table('dnm_catalogos.dnm_persona_natural as pn')
   				->select('pn.nitNatural as NIT', DB::raw('CONCAT(pn.nombres," ", pn.apellidos) as NOMBRE_PERSONA'), 'emailsContacto','telefonosContacto','pn.direccion')
				->where('pn.nitNatural',$nit)
				->get();

				//$persona[0]->telefonosContacto= str_replace('{', '',$persona[0]->telefonosContacto);
				//$persona[0]->telefonosContacto = str_replace('}', '', $persona[0]->telefonosContacto);
				//$persona[0]->telefonosContacto= str_replace('"telefono1":', '', $persona[0]->telefonosContacto);
				//$persona[0]->telefonosContacto = str_replace('"telefono2":', '', $persona[0]->telefonosContacto);
				return $persona;
	}


	public static function getSolicitudes(){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.solicitudes as s')
		->join('dnm_cosmeticos_si.SOL.solicitudesDetalle as sd','s.idSolicitud','sd.idSolicitud')
		->join('dnm_cosmeticos_si.SOL.estadosSolicitudes as e','e.idEstado','s.estado')
		->join('dnm_cosmeticos_si.SOL.tiposTramites as tp','tp.idTramite','s.tipoSolicitud')
		->select('s.idSolicitud','s.numeroSolicitud','s.fechaCreacion','s.fechaEnvio','s.idUsuarioCrea','s.solicitudPortal','tp.nombreTramite','sd.nombreComercial','e.estado','s.tipoSolicitud',DB::raw("CASE WHEN s.solicitudPortal=0 THEN 'DNM' ELSE 'Portal en línea' END as origen"),DB::raw("CASE WHEN s.solicitudPortal=0 THEN s.fechaCreacion ELSE s.fechaEnvio END as fecha"),'s.estado as idEstado','e.plazo as plazoEstado','s.plazo')
		->whereNotIn('s.estado',[0,10,9]);
	}
	public static function getSolicitudesAsignar(){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.solicitudes as s')
		->join('dnm_cosmeticos_si.SOL.solicitudesDetalle as sd','s.idSolicitud','sd.idSolicitud')
		->join('dnm_cosmeticos_si.SOL.estadosSolicitudes as e','e.idEstado','s.estado')
		->join('dnm_cosmeticos_si.SOL.tiposTramites as tp','tp.idTramite','s.tipoSolicitud')
		->select('s.idSolicitud','s.numeroSolicitud','s.fechaCreacion','s.fechaEnvio','s.idUsuarioCrea','s.solicitudPortal','tp.nombreTramite','sd.nombreComercial','e.estado','s.tipoSolicitud',DB::raw("CASE WHEN solicitudPortal=0 THEN 'DNM' ELSE 'Portal en línea' END as origen"),DB::raw("CASE WHEN solicitudPortal=0 THEN s.fechaCreacion ELSE s.fechaEnvio END as fecha"),'s.estado as idEstado','e.plazo as plazoEstado','s.plazo')
		->whereNotIn('s.estado',[0,10])
		->whereIn('s.estado',[1,2]);
	}
	public static function getSolicitudesTecnico($usuario){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.solicitudes as s')
		->join('dnm_cosmeticos_si.SOL.solicitudesDetalle as sd','s.idSolicitud','sd.idSolicitud')
		->join('dnm_cosmeticos_si.SOL.estadosSolicitudes as e','e.idEstado','s.estado')
		->join('dnm_cosmeticos_si.SOL.tiposTramites as tp','tp.idTramite','s.tipoSolicitud')
		->leftjoin('dnm_cosmeticos_si.SOL.solicitudAsignaciones as asig','s.idSolicitud','asig.idSolicitud')
		->select('s.idSolicitud','s.numeroSolicitud','s.fechaCreacion','s.fechaEnvio','s.idUsuarioCrea','s.solicitudPortal','tp.nombreTramite','sd.nombreComercial','e.estado','s.tipoSolicitud',DB::raw("CASE WHEN solicitudPortal=0 THEN 'DNM' ELSE 'Portal en línea' END as origen"),DB::raw("CASE WHEN solicitudPortal=0 THEN s.fechaCreacion ELSE s.fechaEnvio END as fecha"),'s.estado as idEstado','e.plazo as plazoEstado','s.plazo','asig.usuarioAsignado')
		->whereNotIn('s.estado',[0,10])
		->where('asig.usuarioAsignado','like','%'.$usuario.'%');
	}




	public static function getSolicitudesParaSesion($nombreSesion){
		//dd($nombreSesion);
		$sesion=DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SES.sesiones')
		->select('fechaSesion')->where('nombreSesion',$nombreSesion)->get();
		//dd($sesion);
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.solicitudes as s')
		->join('dnm_cosmeticos_si.SOL.solicitudesDetalle as sd','s.idSolicitud','sd.idSolicitud')
		->join('dnm_cosmeticos_si.SOL.estadosSolicitudes as e','e.idEstado','s.estado')
		->join('dnm_cosmeticos_si.SOL.tiposTramites as tp','tp.idTramite','s.tipoSolicitud')
		->select('s.idSolicitud','tp.nombreTramite','sd.nombreComercial','e.estado','s.fechaCreacion')
		->whereDate('s.fechaCreacion','<',date('Ymd',strtotime($sesion[0]->fechaSesion)) )
		->whereIn('s.estado',[3])
		->get();
		//dd($fecha);
	}
	public static function getSustanciasFormulaCos($id){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.formulaCosmetico as fc')
		->join('dnm_cosmeticos_si.CAT.formulaINCI as f','fc.idDenominacion','f.idDenominacion')
		->select('fc.porcentaje','f.numeroCAS','f.denominacionINCI')->where('idSolicitud',$id)->get();
	}

	public static function getSustanciasFormulaHig($id){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.formulaHigienico as fc')
		->join('dnm_cosmeticos_si.CAT.formulaHig as f','fc.idDenominacion','f.idDenominacion')
		->select('fc.porcentaje','f.numeroCAS','f.nombreSustancia as denominacionINCI')->where('idSolicitud',$id)->get();
	}

	public static function getNomFabricanteNacional($id){
		return DB::connection('mysql')->table('cssp.cssp_establecimientos as e')
				->select('e.ID_ESTABLECIMIENTO','e.NOMBRE_COMERCIAL as nombreFabricante')
				->where('ID_ESTABLECIMIENTO',$id)->get();


	}

	public static function getEstadosSol(){
		return DB::connection('sqlsrv')->table('dnm_cosmeticos_si.SOL.estadosSolicitudes')
		->select('*')->whereNotIn('idEstado',[0,10])->get();
	}


}
