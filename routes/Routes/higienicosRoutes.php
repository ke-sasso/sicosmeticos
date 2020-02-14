<?php
// Ruta para mantenimiento de catalogos generales
Route::group(['prefix' => 'higienicos' , 'middleware' => ['auth']], function(){

// ver catalogo
	Route::group(['prefix' => 'tecnico'], function(){
	
		Route::get('/higienicos',[
		          	'as'=>'indexhigienicos',
		          	'middleware' => ['verifypermissions:cat.administrador_higienicos.coshig'],
		          	'uses'=>'HigienicoController@index'
		          	]);
		Route::get('/higienicodata',[
		          	'as'=>'dt.row.data.hig',
		          	'middleware' => ['verifypermissions:cat.administrador_higienicos.coshig'],
		          	'uses'=>'HigienicoController@dtRowDataHig'
		          	]);

		Route::get('/verhigienico/{indexhigienico}/{opcion}',[
		          	'as'=>'verhigienico',
		          	'middleware' => ['verifypermissions:cat.higienicos_ver_detalle.coshig'],
		          	'uses'=>'HigienicoController@verhigienico'
		          	]);
		Route::post('/higienicoclas',[
		          	'as'=>'guardarClasHig',
		          	'middleware' => ['verifypermissions:cat.clasificacion_higienicos_crear.coshig'],
		          	'uses'=>'HigienicoController@saveClassHig'
		          	]);
		Route::get('/getClasHig',[
		          	'as'=>'getCrearClas',
		          	'middleware' => ['verifypermissions:cat.clasificacion_higienicos_crear.coshig'],
		          	'uses'=>'HigienicoController@getCrearClas'
		          	]);
		Route::get('/indexClassHig',[
		          	'as'=>'indexClass',
		          	'middleware' => ['verifypermissions:cat.clasificacion_higienicos_ver.coshig'],
		          	'uses'=>'HigienicoController@verClasificiones'
		          	]);

		Route::get('/getClassHig',[
		          	'as'=>'dt.class.hig',
		          	'middleware' => ['verifypermissions:cat.clasificacion_higienicos_ver.coshig'],
		          	'uses'=>'HigienicoController@getClasificaciones'
		          	]);

		Route::get('/verclasificacion/{id}',[
					'as'=>'editarClassHig',
                    'middleware' => ['verifypermissions:cat.clasificacion_higienicos_editar.coshig'],
					'uses'=>'HigienicoController@editar'
					]);
		Route::post('/actualizarClassHig',[
					'as'=>'actualizarClassHig',
                    'middleware' => ['verifypermissions:cat.clasificacion_higienicos_editar.coshig'],
					'uses'=>'HigienicoController@actualizarClass'
					]);
		Route::post('/actualizarTonosHig',[
					'as'=>'editarTonosHig',
					'middleware' => ['verifypermissions:cat.higienicos_editar.coshig'],
					'uses'=>'HigienicoController@editarTonos'
		]);
		Route::post('/actualizarFraganciasHig',[
					'as'=>'editarFraganciaHig',
					'middleware' => ['verifypermissions:cat.higienicos_editar.coshig'],
					'uses'=>'HigienicoController@editarFragancias'
		]);
		Route::post('/actualizarFabHig',[
					'as'=>'editarFabHig',
					'middleware' => ['verifypermissions:cat.higienicos_editar.coshig'],
					'uses'=>'HigienicoController@editarFabricantes'
		]);
		Route::post('/actualizarDisHig',[
					'as'=>'editarDisHig',
					'middleware' => ['verifypermissions:cat.higienicos_editar.coshig'],
					'uses'=>'HigienicoController@editarDistribuidores'
		]);
		Route::post('/actualizarImpHig',[
					'as'=>'editarImpHig',
					'middleware' => ['verifypermissions:cat.higienicos_editar.coshig'],
					'uses'=>'HigienicoController@editarImportadores'
		]);

		Route::post('/actualizarGenerales',[
					'as'=>'editarGenenalesHig',
					'middleware' => ['verifypermissions:cat.higienicos_editar.coshig'],
					'uses'=>'HigienicoController@editarGenerales'
			]);

		Route::post('/actualizarPropietario',[
					'as'=>'editarPropietarioHig',
					'middleware' => ['verifypermissions:cat.higienicos_editar.coshig'],
					'uses'=>'HigienicoController@editarPropietario'
			]);

		Route::post('/actualizarProfesional',[
					'as'=>'editarProfesionalHig',
					'middleware' => ['verifypermissions:cat.higienicos_editar.coshig'],
					'uses'=>'HigienicoController@editarProfesional'
		]);

		Route::post('/actualizarClas',[
					'as'=>'editarClasHig',
					'middleware' => ['verifypermissions:cat.higienicos_editar.coshig'],
		          	'uses'=>'HigienicoController@editarClasificacion'
		]);

		Route::post('/actualizarMarca',[
					'as'=>'editarMarcaHig',
					'middleware' => ['verifypermissions:cat.higienicos_editar.coshig'],
					'uses'=>'HigienicoController@editarMarca'
		]);

		Route::post('/actualizarFormula',[
					'as'=>'editarFormulaHig',
					'middleware' => ['verifypermissions:cat.higienicos_editar.coshig'],
					'uses'=>'HigienicoController@editarFormula'
		]);

		Route::post('/savePresentacion',[
	               'as'=>'actualizar.presentacionHig',
                    'middleware' => ['verifypermissions:cat.higienicos_editar.coshig'],
	               'uses'=>'HigienicoController@savePresentacion'
            ]);

		Route::get('/deletePresentaciones',[
	               'as'=>'borrar.presentacionesHig',
                    'middleware' => ['verifypermissions:cat.higienicos_editar.coshig'],
	               'uses'=>'HigienicoController@deletePresentacion'
            ]);

		Route::post('/actualizarFragancias',[
			'as'=>'editarFraganciaHig',
			'middleware' => ['verifypermissions:cat.higienicos_editar.coshig'],
			'uses'=>'HigienicoController@editarFragancias'
		]);

		Route::post('/actualizarTonos',[
			'as'=>'editarTonosHig',
			'middleware' => ['verifypermissions:cat.higienicos_editar.coshig'],
			'uses'=>'HigienicoController@editarTonos'
		]);

		Route::post('/actualizarFab',[
			'as'=>'editarFabHig',
			'middleware' => ['verifypermissions:cat.higienicos_editar.coshig'],
			'uses'=>'HigienicoController@editarFabricantes'
		]);

		Route::post('/actualizarImp',[
			'as'=>'editarImpHig',
			'middleware' => ['verifypermissions:cat.higienicos_editar.coshig'],
			'uses'=>'HigienicoController@editarImportadores'
		]);

		Route::post('/actualizarDis',[
			'as'=>'editarDisHig',
			'middleware' => ['verifypermissions:cat.higienicos_editar.coshig'],
			'uses'=>'HigienicoController@editarDistribuidores'
		]);

	});
});
