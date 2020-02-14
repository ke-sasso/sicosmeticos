<?php
// Ruta para mantenimiento de catalogos generales
Route::group(['prefix' => 'dictamenes' , 'middleware' => ['auth']], function(){

  Route::get('/AdmonNotificaciones',[
              'as'=>'indexAdmonNotificacion',
              'middleware' => ['verifypermissions'],
              'uses'=>'DictamenController@indexAdmonNotificaciones'
            ]);
  Route::get('/getSolicitudeNotificacion',[
               'as'=>'dt.row.data.noti',
                'middleware' => ['verifypermissions'],
               'uses'=>'DictamenController@getSolicitudesNotificacion'
            ]);
  Route::get('/registroNotificacion/{idSol}',[
               'as'=>'registroNotificacion',
                'middleware' => ['verifypermissions'],
               'uses'=>'DictamenController@registroNotificacion'
               ]);
  Route::post('/guardarNuevaNotificacion',[
               'as'=>'guardarNuevaNoti',
                'middleware' => ['verifypermissions'],
               'uses'=>'DictamenController@guardarNuevaNotificacion'
               ]);
  Route::post('/guardarNotificacion',[
               'as'=>'guardarNoti',
                'middleware' => ['verifypermissions'],
               'uses'=>'SolicitudController@getSolicitudesNotificacion'
               ]);

// administrador
	Route::group(['prefix' => 'nuevoDic','middleware'=>['auth','verifypermissions:pre.admin_solicitudes_dictaminar.coshig']], function(){

          Route::get('/consultarSol/{idSol}/{tipo}/{solicitudPortal}',[
               'as'=>'versolicitudDic',
               'uses'=>'SolicitudController@verSolicitud'
               ]);
		Route::get('/nuevadic',[
          	'as'=>'nuevadictamen',
          	'uses'=>'DictamenController@nuevoDictamen'
          	]);

		Route::post('/saveDic',[
          	'as'=>'guardarDictamen',
          	'uses'=>'DictamenController@guardarDictamen'
          	]);

          Route::post('/saveResolucion',[
               'as'=>'guardarResolucion',
               'uses'=>'DictamenController@guardarResolucion'
               ]);
          Route::get('/verDictamen/{id}',[
               'as'=>'pdfDictamen',
               'uses'=>'DictamenController@pdfDictamen'
               ]);
          Route::get('/verResolucion/{id}',[
               'as'=>'pdfResolucion',
               'uses'=>'DictamenController@pdfResolucion'
               ]);
          Route::get('/verResolucionDic/{id}/{idDic}',[
               'as'=>'verResolucionDic',
               'uses'=>'DictamenController@pdfResolucionBySol'
               ]);
          Route::post('/enviarcorrespondencia',[
              'as'=>'enviar.correspondencia',
              'uses'=>'DictamenController@enviarCorrespondencia'
            ]);
             Route::get('/verResolucionDesfavorable/{idSolicitud}',[
               'as'=>'solpre.pdf.certificacion.desfavorable',
               'uses'=>'DictamenController@pdfResolBySolDesfavorable'
               ]);

             Route::post('/cambiar/estadoDocCertificacion',[
               'as'=>'solpre.pdf.certificacion.cambiarestado',
               'uses'=>'DictamenController@cambiarEstadoDocCertificacion'
               ]);


		});

	});
