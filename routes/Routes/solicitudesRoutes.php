<?php
// Ruta para mantenimiento de catalogos generales
Route::group(['prefix' => 'solicitudes' , 'middleware' => ['auth']], function(){

// administrador
	Route::group(['prefix' => 'nueva'], function(){
		Route::group(['prefix' => 'asignaciones'], function(){
                Route::get('/pre',[
                    'as'=>'solicitudes.nueva.asignaciones',
                    'middleware' => ['verifypermissions:pre.asignar_ver_asignadas.coshig'],
                    'uses'=>'SolicitudesPre\Asignaciones\AsignacionesController@index'
                ]);
                Route::get('/get/solicitudes',[
                    'as'=>'solicitudes.pre.get.asignaciones',
                    'middleware' => ['verifypermissions:pre.asignar_ver_asignadas.coshig'],
                    'uses'=>'SolicitudesPre\Asignaciones\AsignacionesController@getSolicitudesAsignarPre'
                ]);
                Route::post('/store/pre',[
                    'as'=>'solicitudes.pre.asignaciones.store',
                    'middleware' => ['verifypermissions:pre.asignar_solicitudes.coshig'],
                    'uses'=>'SolicitudesPre\Asignaciones\AsignacionesController@store'
                ]);
                Route::get('/tecnico',[
                    'as'=>'solicitudes.pre.tecnico',
                    'middleware' => ['verifypermissions:pre.usuario_asignacion.coshig'],
                    'uses'=>'SolicitudesPre\Asignaciones\AsignacionesController@solicitudesTecnico'
                ]);
                Route::get('/get/solicitudes/tecnico',[
                    'as'=>'solicitudes.get.pre.tecnico',
                    'middleware' => ['verifypermissions:pre.usuario_asignacion.coshig'],
                    'uses'=>'SolicitudesPre\Asignaciones\AsignacionesController@getSolicitudesTecnicoPre'
                ]);
                Route::get('/pre/{idSolicitud}',[
                    'as'=>'index.asignar.pre.sol',
                    'middleware' => ['verifypermissions:pre.usuario_asignacion.coshig'],
                    'uses'=>'SolicitudesPre\Asignaciones\AsignacionesController@indexAsignaciones'
                ]);
		});


		Route::get('/nuevasol',[
          	'as'=>'nuevasol',
          	'middleware' => ['verifypermissions:pre.nueva_solicitud.coshig'],
          	'uses'=>'SolicitudController@nuevaSolicitud'
          	]);

		Route::post('/getDataClass',[
          	'as'=>'getDataClassSol',
          	'uses'=>'ClasificacionController@getClassByArea'
          	]);
          Route::get('/getDataClassHig',[
               'as'=>'getClassHig',
               'uses'=>'SolicitudController@getClasHig'
               ]);


          Route::post('/getFormas',[
               'as'=>'getGrupoFormasSol',
               'uses'=>'GruposFormasController@getGrupoFormas'
               ]);
          Route::get('/consultarClassC',[
               'as'=>'consultarClassSol',
               'uses'=>'ClasificacionController@consultarClass'
               ]);
          Route::get('/consultarClassH',[
               'as'=>'consultarClassSolHig',
               'uses'=>'ClasificacionController@consultarClassHig'
               ]);
          Route::get('/consultarClassC',[
               'as'=>'consultarClassSolCos',
               'uses'=>'ClasificacionController@consultarClass'
               ]);
          Route::get('/buscarFormulaCos',[
               'as'=>'buscarFormulasAjax',
               'uses'=>'SolicitudController@buscarFormulas'
               ]);




          Route::get('/buscarTitular',[
               'as'=>'buscarTitularAjax',
               'uses'=>'ToolsController@searchTitular'
               ]);
          Route::get('/getTitular',[
               'as'=>'buscarTitularAjaxPorId',
               'uses'=>'ToolsController@getTitular'
               ]);
          Route::get('/buscarProfesionales',[
               'as'=>'buscarProfesionalesAjax',
               'uses'=>'SolicitudController@buscarProfesionales'
               ]);
          Route::get('/buscarProfesionalesById',[
               'as'=>'buscarProfesionalesAjaxPorIdProf',
               'uses'=>'SolicitudController@buscarProfesionalesPorIdProf'
               ]);
          Route::post('/buscarProfesional',[
               'as'=>'buscarProfesionalAjaxPorId',
               'uses'=>'SolicitudController@buscarProfesional'
               ]);
          Route::get('/buscarPersonas',[
               'as'=>'buscarPersonasAjax',
               'uses'=>'SolicitudController@buscarPersonas'
               ]);
           Route::post('/buscarPersona',[
               'as'=>'buscarPersonasAjaxPorId',
               'uses'=>'SolicitudController@getPersona'
               ]);

           Route::post('/getItems',[
               'as'=>'buscarItems',
               'uses'=>'SolicitudController@getItems'
               ]);
           Route::post('/getItemsEditar',[
               'as'=>'buscarItemsEditar',
               'uses'=>'SolicitudController@getItemsEditar'
               ]);
          Route::post('/guardarSolNuevoCosmetico',[
               'as'=>'guardarsolNuevoCos',
              'middleware' => ['verifypermissions:pre.nueva_solicitud.coshig'],
               'uses'=>'SolicitudController@guardarsolNuevoCos'
               ]);
          Route::post('/actualizarSol',[
               'as'=>'actualizarSol',
              'middleware' => ['verifypermissions:pre.nueva_solicitud.coshig'],
               'uses'=>'SolicitudController@actualizarSol'
               ]);
          Route::get('/getEnvases',[
               'as'=>'envases.presentaciones',
               'uses'=>'SolicitudController@getEnvases'
               ]);
          Route::get('/getMateriales',[
               'as'=>'materiales.presentaciones',
               'uses'=>'SolicitudController@getMateriales'
               ]);
          Route::get('/getUnidades',[
               'as'=>'unidades.presentaciones',
               'uses'=>'SolicitudController@getUnidades'
               ]);
          Route::get('/getMunicipios',[
               'as'=>'municipios',
               'uses'=>'SolicitudController@getMunicipios'
               ]);
           Route::get('/getDepartamentos',[
               'as'=>'departamentos',
               'uses'=>'SolicitudController@getDepartamentos'
               ]);
           Route::get('/getTratamientos',[
               'as'=>'tratamientos',
               'uses'=>'SolicitudController@getTratamientos'
               ]);
           Route::get('/getSolicitudes',[
               'as'=>'dt.row.data.sol',
               'middleware'=>['verifypermissions:pre.admin_solicitudes.coshig'],
               'uses'=>'SolicitudController@getSolicitudes'
               ]);
           Route::get('/getSolicitudesIngresadas',[
               'as'=>'indexsol',
               'middleware'=>['verifypermissions:pre.admin_solicitudes.coshig'],
               'uses'=>'SolicitudController@indexSolicitudes'
               ]);
            Route::get('/consultarSol/{idSol}/{tipo}',[
               'as'=>'versolicitud',
                'middleware'=>['verifypermissions:pre.admin_solicitudes_detalle.coshig'],
               'uses'=>'SolicitudController@verSolicitud'
               ]);
            Route::get('/editarSol/{idSol}/{tipo}/{tipoSol}',[
               'as'=>'editarsolicitud',
                'middleware'=>['verifypermissions:pre.admin_solicitudes_editar.coshig'],
               'uses'=>'SolicitudController@actualizarSolicitud'
               ]);
            Route::get('/paises',[
               'as'=>'getPaises',
               'uses'=>'SolicitudController@getPaises'
               ]);
            Route::get('/guardarSolCos',[
               'as'=>'guardarSolicitudCos',
                'middleware' => ['verifypermissions'],
               'uses'=>'SolicitudController@guardarSolicitudCos'
               ]);
            Route::post('/guardarSolCosDetalle',[
               'as'=>'guardarSolicitudCosDetalle',
                'middleware' => ['verifypermissions:pre.nueva_solicitud.coshig'],
               'uses'=>'SolicitudController@guardarSolicitudCosDetalle'
               ]);
           Route::post('/validarMand',[
               'as'=>'validar.mandamiento',
               'uses'=>'SolicitudController@validarManda'
               ]);
            Route::get('/verDocumentos/{idDoc}',[
               'as'=>'ver.documento',
                'middleware' => ['verifypermissions:pre.admin_solicitudes_detalle.coshig'],
               'uses'=>'SolicitudController@getDocumentos'
               ]);
            Route::post('/eliminarDocumento',[
               'as'=>'eliminar.documento',
                'middleware' => ['verifypermissions:pre.nueva_solicitud.coshig'],
               'uses'=>'SolicitudController@eliminarDocumento'
               ]);
            Route::post('/eliminarFormula',[
               'as'=>'eliminar.formula',
                'middleware' => ['verifypermissions:pre.nueva_solicitud.coshig'],
               'uses'=>'SolicitudController@eliminarFormula'
               ]);
            Route::post('/eliminarFragancia',[
               'as'=>'eliminar.fragancia',
                'middleware' => ['verifypermissions:pre.nueva_solicitud.coshig'],
               'uses'=>'SolicitudController@eliminarFragancia'
               ]);
            Route::post('/eliminarTono',[
               'as'=>'eliminar.tono',
                'middleware' => ['verifypermissions:pre.nueva_solicitud.coshig'],
               'uses'=>'SolicitudController@eliminarTono'
               ]);
            Route::post('/guardarNuevaPersona',[
               'as'=>'guardarNuevaPersona',
                'middleware' => ['verifypermissions:pre.nueva_solicitud.coshig'],
               'uses'=>'SolicitudController@guardarPersona'
               ]);
            Route::post('/buscarFormula',[
               'as'=>'buscarFormulajaxPorId',
                'middleware' => ['verifypermissions:pre.nueva_solicitud.coshig'],
               'uses'=>'SolicitudController@buscarFormulaPorId'
               ]);
            Route::post('/buscarFormulaHig',[
               'as'=>'buscarFormulaHigjaxPorId',
                'middleware' => ['verifypermissions:pre.nueva_solicitud.coshig'],
               'uses'=>'SolicitudController@buscarFormulaHigPorId'
               ]);
            Route::get('/getSolicitudesFav',[
               'as'=>'dt.row.data.sol.fav',
               'uses'=>'SolicitudController@getSolicitudesFavorables'
               ]);
            Route::get('/getSolicitudesSesion',[
               'as'=>'indexsolFavorables',
               'uses'=>'SolicitudController@getSolFavorables'
               ]);
            Route::get('/getClasificaciones',[
               'as'=>'cargar.clasificacion',
               'uses'=>'SolicitudController@getClasificacionesProductos'
            ]);
            Route::post('/savePresentaciones',[
               'as'=>'guardar.presentacion',
                'middleware' => ['verifypermissions:pre.nueva_solicitud.coshig'],
               'uses'=>'SolicitudController@savePresentacion'
            ]);
            Route::get('/deletePresentaciones',[
               'as'=>'borrar.presentaciones',
                'middleware' => ['verifypermissions:pre.nueva_solicitud.coshig'],
               'uses'=>'SolicitudController@deletePresentacion'
            ]);
             Route::get('/getPresentacionesSol',[
              'as'=>'get.presentacionesSol',
              'uses'=>'SolicitudController@getPresentacionesSolicitud'
            ]);
            Route::get('/getCoempaquesSol',[
              'as'=>'get.coempaqueSol',
              'uses'=>'CoempaqueController@getCoempaquesSol'
            ]);
            Route::get('/getCoempaquesProducto',[
              'as'=>'get.coempaqueProducto',
              'uses'=>'CoempaqueController@getCoempaquesProducto'
            ]);
            Route::post('/crearCoempaque',[
              'as'=>'crear.coempaque',
                'middleware'=>['verifypermissions:pre.solicitudes_agregar_coempaque.coshig'],
              'uses'=>'CoempaqueController@crearCoempaqueCos'
            ]);
            Route::get('/deleteCoempaque',[
               'as'=>'borrar.coempaque',
                'middleware'=>['verifypermissions:pre.solicitudes_agregar_coempaque.coshig'],
               'uses'=>'CoempaqueController@deleteCoempaque'
            ]);
            Route::post('/ingresarFormula',[
              'as'=>'ingresarFormula',
                'middleware' => ['verifypermissions:pre.nueva_solicitud.coshig'],
              'uses'=>'SolicitudController@ingresarFormula'
            ]);


	});
});
