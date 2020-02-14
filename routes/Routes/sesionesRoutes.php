<?php
// Ruta para mantenimiento de catalogos generales
Route::group(['prefix' => 'sesiones' , 'middleware' => ['auth' ]], function(){

// administrador
	Route::group(['prefix' => 'sesion'], function(){
            Route::get('/getsesiones',[
                'as'=>'indexSesiones',
                'middleware'=>['verifypermissions:pre.sesiones_administrador.coshig'],
                'uses'=>'SesionController@getIndex'
            ]);

			Route::get('/versesiones',[
               'as'=>'dt.row.data.sesiones',
                'middleware'=>['verifypermissions:pre.sesiones_administrador.coshig'],
               'uses'=>'SesionController@getSesiones'
               ]);
               Route::get('/detalleSesion/{id}',[
               'as'=>'verSesion',
               'middleware'=>['verifypermissions:pre.sesiones_administrador.coshig'],
               'uses'=>'SesionController@getDetalleSesion'
               ]);

               Route::get('/consultarSol/{sesion}',[
               'as'=>'consultarSolicitudes',
               'middleware'=>['verifypermissions:pre.sesiones_administrador.coshig'],
               'uses'=>'SesionController@getConsultarSol'
               ]);

               Route::post('/agregarSol',[
               'as'=>'agregarSolicitudesAsesion',
               'middleware'=>['verifypermissions:pre.solicitudes_ingresar_sesion.coshig'],
               'uses'=>'SesionController@agregarSolSesion'
               ]);

               Route::get('/getsesionesCertificaciones',[
               'as'=>'indexSesionesCertificar',
               'middleware'=>['verifypermissions:pre.solicitudes_admin_certificaciones.coshig'],
               'uses'=>'SesionController@getIndexCertificar'
               ]);

               Route::get('/versesionesParaCertificar',[
               'as'=>'dt.row.data.sesiones.certificar',
               'middleware'=>['verifypermissions:pre.solicitudes_admin_certificaciones.coshig'],
               'uses'=>'SesionController@getSesionesCertificaciones'
               ]);

               Route::get('/detalleSesionCertificar/{id}',[
               'as'=>'getSolicitudesCertificar',
               'middleware'=>['verifypermissions:pre.solicitudes_admin_certificaciones.coshig'],
               'uses'=>'SesionController@getDetalleSolCertificar'
               ]);
               Route::post('/certificarSol',[
               'as'=>'certificarSolicitudes',
               'middleware'=>['verifypermissions:pre.solicitudes_certificar_ses.coshig'],
               'uses'=>'SesionController@certificarSolicitudes'
               ]);
               Route::get('/getSolicitudesParaCertificar',[
               'as'=>'dt.row.data.sol.certificar',
               'middleware'=>['verifypermissions:pre.solicitudes_admin_certificaciones.coshig'],
               'uses'=>'SesionController@getSolCertificar'
               ]);

               Route::get('/indexSesionesAprobar',[
               'as'=>'indexSesionesAprobar',
               'middleware'=>['verifypermissions:pre.solicitudes_aprobar_sesion.coshig'],
               'uses'=>'SesionController@indexSesiones'
               ]);

               Route::get('/getSol',[
               'as'=>'dt.row.data.sesiones.aprobar',
               'middleware'=>['verifypermissions:pre.solicitudes_aprobar_sesion.coshig'],
               'uses'=>'SesionController@getSesionesAprobar'
               ]);

               Route::get('/indexSolAprobar/{id}',[
               'as'=>'indexSolicitudesAprobar',
               'middleware'=>['verifypermissions:pre.solicitudes_aprobar_sesion.coshig'],
               'uses'=>'SesionController@indexSolSesiones'
               ]);


               Route::get('/aprobarSol',[
               'as'=>'dt.row.data.sol.listas',
               'middleware'=>['verifypermissions:pre.solicitudes_aprobar_sesion.coshig'],
               'uses'=>'SesionController@solParaAprobar'
               ]);

               Route::post('/aprobarSolicitudes',[
               'as'=>'aprobarSolicitudesAsesion',
               'middleware'=>['verifypermissions:pre.solicitudes_aprobar_sesion.coshig'],
               'uses'=>'SesionController@aprobarSolicitudes'
               ]);



                Route::get('/consultarSolSes',[
               'as'=>'dt.row.data.sol.ses',
                'middleware'=>['verifypermissions'],
               'uses'=>'SesionController@getSolictudesByEstado'
               ]);

                Route::get('/imprimir',[
               'as'=>'imprimirCertificado',
                'middleware'=>['verifypermissions:pre.solicitudes_imprimir_cvl_ses.coshig'],
               'uses'=>'SesionController@prepararCertificado'
               ]);

               Route::get('/imprimir/solicitudes',[
                  'as' => 'imprimir.solicitudes',
                   'middleware'=>['verifypermissions:pre.solicitudes_imprimir_cvl_ses.coshig'],
                  'uses' => 'SesionController@imprimirCertificados'
               ]);

               Route::post('/get/producto-sesion',[
                    'as'=>'find.producto.pre.sesion',
                    'permissions' => [475],
                    'uses'=>'SesionController@getProductoSesion'
               ]);




	});

});
