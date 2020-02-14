<?php
// Ruta para mantenimiento de catalogos generales
Route::group(['prefix' => 'cosmeticos' , 'middleware' => ['auth']], function(){

// administrador
	Route::group(['prefix' => 'administrador'], function(){

		// Rutas para areas de aplicación
		Route::get('/creararea',[
		          	'as'=>'creararea',
		          	'middleware' => ['verifypermissions:cat.areas_aplicacion_crear.coshig'],
		          	'uses'=>'AreaController@crearArea'
		          	]);
		Route::post('/guardararea',[
					'as'=>'guardararea',
                    'middleware' => ['verifypermissions:cat.areas_aplicacion_crear.coshig'],
					'uses'=>'AreaController@guardarArea'
					]);
		Route::get('/verareas',[
					'as'=>'indexareas',
                    'middleware' => ['verifypermissions:cat.areas_aplicacion_ver.coshig'],
					'uses'=>'AreaController@index'
					]);
		Route::get('/editararea/{id}',[
					'as'=>'editararea',
                    'middleware' => ['verifypermissions:cat.areas_aplicacion_editar.coshig'],
					'uses'=>'AreaController@editarArea'
					]);
		Route::post('/actualizararea',[
					'as'=>'actualizararea',
                    'middleware' => ['verifypermissions:cat.areas_aplicacion_editar.coshig'],
					'uses'=>'AreaController@actualizarArea'
					]);

		//Rutas para clasificacion de productos
		Route::get('/crearclasificacion',[
					'as'=>'crearc',
                    'middleware' => ['verifypermissions:cat.clasificacion_cosmeticos_crear.coshig'],
					'uses'=>'ClasificacionController@crearc'
					]);
		
		Route::post('/guardarclasificacion',[
					'as'=>'guardar',
                    'middleware' => ['verifypermissions:cat.clasificacion_cosmeticos_crear.coshig'],
					'uses'=>'ClasificacionController@guardar'
					]);

		Route::get('/verclasificaciones',[
					'as'=>'index',
                    'middleware' => ['verifypermissions:cat.clasificacion_cosmeticos_ver.coshig'],
					'uses'=>'ClasificacionController@index'
					]);
		Route::get('/verclasificaciones/{id}',[
					'as'=>'editar',
                    'middleware' => ['verifypermissions:cat.clasificacion_cosmeticos_editar.coshig'],
					'uses'=>'ClasificacionController@editar'
					]);
		Route::get('/getdataclass',[
					'as'=>'dt.row.data.class',
                    'middleware' => ['verifypermissions:cat.clasificacion_cosmeticos_ver.coshig'],
					'uses'=>'ClasificacionController@getDataClass'
					]);
		Route::post('/actualizarclass',[
					'as'=>'actualizar',
                    'middleware' => ['verifypermissions:cat.clasificacion_cosmeticos_ver.coshig'],
					'uses'=>'ClasificacionController@actualizar'
					]);
		Route::get('/cosmeticos',[
		          	'as'=>'indexcosmeticos',
		          	'middleware' => ['verifypermissions:cat.administrador_cosmeticos.coshig'],
		          	'uses'=>'CosmeticoController@index'
		          	]);
		Route::get('/cosmeticosdata',[
		          	'as'=>'dt.row.data.cos',
		          	'middleware' => ['verifypermissions'],
		          	'uses'=>'CosmeticoController@dtRowDataCos'
		          	]);

		Route::get('/vercosmeticos/{idCosmetico}',[
		          	'as'=>'vercosmetico',
		          	'middleware' => ['verifypermissions'],
		          	'uses'=>'CosmeticoController@vercosmetico'
		          	]);

		Route::get('/generales-cosmeticos',[
		          	'as'=>'generalescos',
		          	'middleware' => ['verifypermissions'],
		          	'uses'=>'CosmeticoController@generalescos'
		          	]);
		Route::get('/detalleCoempaque',[
		          	'as'=>'getDetalleCoempaques',
		          	'middleware' => ['verifypermissions'],
		          	'uses'=>'CosmeticoController@getDetalleCoempaque'
		          	]);


	});
	
	Route::group(['prefix' => 'tecnico'], function(){

		// Rutas para catalogo cosmeticos
		Route::get('/cosmeticos',[
		          	'as'=>'indexcosmeticos',
		          	'middleware' => ['verifypermissions'],
		          	'uses'=>'CosmeticoController@index'
		          	]);
		Route::get('/cosmeticos',[
		          	'as'=>'dt.row.data.cos',
                    'middleware' => ['verifypermissions:cat.administrador_cosmeticos.coshig'],
		          	'uses'=>'CosmeticoController@dtRowDataCos'
		          	]);
		Route::get('/vercosmeticos/{idCosmetico}/{opcion}',[
		          	'as'=>'vercosmetico',
		          	'middleware' => ['verifypermissions:cat.cosmeticos_ver_detalle.coshig'],
		          	'uses'=>'CosmeticoController@vercosmetico'
		          	]);

		Route::get('/edicionCos',[
		          	'as'=>'vercosmetico.edicion',
		          	'middleware' => ['verifypermissions'],
		          	'uses'=>'CosmeticoController@getDetalleCosmetico'
		          	]);

		Route::post('/actualizarClas',[
					'as'=>'editarClas',
                    'middleware' => ['verifypermissions:cat.cosmeticos_editar.coshig'],
		          	'uses'=>'CosmeticoController@editarClasificacion'
					]);

		Route::post('/actualizarGenerales',[
					'as'=>'editarGenenalesCos',
					'middleware' => ['verifypermissions:cat.cosmeticos_editar.coshig'],
					'uses'=>'CosmeticoController@editarGenerales'
			]);

		Route::post('/actualizarMarca',[
					'as'=>'editarMarca',
                    'middleware' => ['verifypermissions:cat.cosmeticos_editar.coshig'],
					'uses'=>'CosmeticoController@editarMarca'
			]);
		Route::post('/actualizarPropietario',[
					'as'=>'editarPropietarioCos',
                    'middleware' => ['verifypermissions:cat.cosmeticos_editar.coshig'],
					'uses'=>'CosmeticoController@editarPropietario'
			]);
		Route::post('/actualizarProfesional',[
			'as'=>'editarProfesionalCos',
            'middleware' => ['verifypermissions:cat.cosmeticos_editar.coshig'],
			'uses'=>'CosmeticoController@editarProfesional'
		]);
		Route::post('/actualizarFormula',[
			'as'=>'editarFormulaCos',
            'middleware' => ['verifypermissions:cat.cosmeticos_editar.coshig'],
			'uses'=>'CosmeticoController@editarFormula'
		]);
		Route::post('/actualizarTonos',[
			'as'=>'editarTonosCos',
            'middleware' => ['verifypermissions:cat.cosmeticos_editar.coshig'],
			'uses'=>'CosmeticoController@editarTonos'
		]);
		Route::post('/actualizarFragancias',[
			'as'=>'editarFraganciaCos',
            'middleware' => ['verifypermissions:cat.cosmeticos_editar.coshig'],
			'uses'=>'CosmeticoController@editarFragancias'
		]);
		Route::post('/actualizarFab',[
			'as'=>'editarFabCos',
            'middleware' => ['verifypermissions:cat.cosmeticos_editar.coshig'],
			'uses'=>'CosmeticoController@editarFabricantes'
		]);
		Route::post('/actualizarDis',[
			'as'=>'editarDisCos',
            'middleware' => ['verifypermissions:cat.cosmeticos_editar.coshig'],
			'uses'=>'CosmeticoController@editarDistribuidores'
		]);
		Route::post('/actualizarImp',[
			'as'=>'editarImpCos',
            'middleware' => ['verifypermissions:cat.cosmeticos_editar.coshig'],
			'uses'=>'CosmeticoController@editarImportadores'
		]);

		Route::post('/savePresentacion',[
               'as'=>'actualizar.presentacion',
                'middleware' => ['verifypermissions:cat.cosmeticos_editar.coshig'],
               'uses'=>'CosmeticoController@savePresentacion'
            ]);

		Route::get('/getPresentacionesCos',[
              'as'=>'get.presentacionesCos',
                'middleware' => ['verifypermissions'],
              'uses'=>'CosmeticoController@getPresentacionesCosmeticos'
            ]);

		Route::get('/deletePresentaciones',[
               'as'=>'borrar.presentacionesCos',
                'middleware' => ['verifypermissions:cat.cosmeticos_editar.coshig'],
               'uses'=>'CosmeticoController@deletePresentacion'
            ]);

		

	});
});