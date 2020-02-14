<?php
// Ruta para mantenimiento de catalogos generales
Route::group(['prefix' => 'catalogos' , 'middleware' => ['auth']], function(){

// administrador
	Route::group(['prefix' => 'administrador'], function(){
          // rutas para Catalogo envases
          Route::get('/crearenvase',[
          	'as'=>'crearenvase',
          	'middleware' => ['verifypermissions:cat.envases_crear.coshig'],
          	'uses'=>'EnvaseController@crearEnvase'
          	]);

          Route::post('/guardarenvase',[
          	'as'=>'guardarenvase',
          	'middleware' => ['verifypermissions:cat.envases_crear.coshig'],
          	'uses'=>'EnvaseController@guardarEnvase'
          	]);
          Route::get('/verenvases',[
          	'as'=>'indexenvases',
          	'middleware' => ['verifypermissions:cat.envases_ver.coshig'],
          	'uses'=>'EnvaseController@index'
          	]);
       
          Route::get('/editarenvase/{id}',[
          	'as'=>'editarenvase',
          	'middleware' => ['verifypermissions:cat.envases_editar.coshig'],
          	'uses'=>'EnvaseController@editarenvase'
          	]);
          Route::post('/actualizarenvase',[
          	'as'=>'actualizarenvase',
          	'middleware' => ['verifypermissions:cat.envases_editar.coshig'],
          	'uses'=>'EnvaseController@actualizarenvase'
          	]);



          // rutas para catalogo Marcas
          Route::get('/crearmarca',[
          	'as'=>'crearmarca',
          	'middleware' => ['verifypermissions:cat.marcas_crear.coshig'],
          	'uses'=>'MarcaController@crearMarca'
          	]);

          Route::post('/guardarmarca',[
          	'as'=>'guardarmarca',
          	'middleware' => ['verifypermissions:cat.marcas_crear.coshig'],
          	'uses'=>'MarcaController@guardarMarca'
          	]);

          Route::get('/vermarcas',[
          	'as'=>'indexmarcas',
          	'middleware' => ['verifypermissions:cat.marcas_ver.coshig'],
          	'uses'=>'MarcaController@index'
          	]);

          Route::get('/editarmarca/{id}',[
          	'as'=>'editarmarca',
          	'middleware' => ['verifypermissions:cat.marcas_editar.coshig'],
          	'uses'=>'MarcaController@editarMarca'
          	]);
          Route::post('/actualizarmarca',[
          	'as'=>'actualizarmarca',
          	'middleware' => ['verifypermissions:cat.marcas_editar.coshig'],
          	'uses'=>'MarcaController@actualizarMarca'
          	]);


            // rutas para catalogo Materiales
          Route::get('/crearmaterial',[
          	'as'=>'crearmaterial',
          	'middleware' => ['verifypermissions:cat.materiales_crear.coshig'],
          	'uses'=>'MaterialController@crearMaterial'
          	]);

          Route::post('/guardarmaterial',[
          	'as'=>'guardarmaterial',
          	'middleware' => ['verifypermissions:cat.materiales_crear.coshig'],
          	'uses'=>'MaterialController@guardarMaterial'
          	]);

          Route::get('/vermateriales',[
          	'as'=>'indexmateriales',
          	'middleware' => ['verifypermissions:cat.materiales_ver.coshig'],
          	'uses'=>'MaterialController@index'
          	]);

           Route::get('/editarmaterial/{id}',[
          	'as'=>'editarmaterial',
          	'middleware' => ['verifypermissions:cat.materiales_editar.coshig'],
          	'uses'=>'MaterialController@editarMaterial'
          	]);

           Route::post('/actualizarmaterial',[
          	'as'=>'actualizarmaterial',
          	'middleware' => ['verifypermissions:cat.materiales_editar.coshig'],
          	'uses'=>'MaterialController@actualizarMaterial'
          	]);
           //rutas para catalogos de sustancias

           Route::get('/versustanciascos',[
               'as'=>'indexsustanciascos',
               'middleware' => ['verifypermissions:cat.sustancias_cosmeticos_ver.coshig'],
               'uses'=>'CosmeticoController@indexSustancias'
               ]);
          Route::get('/versustanciashig',[
               'as'=>'indexsustanciashig',
               'middleware' => ['verifypermissions:cat.sustancias_higienicos_ver.coshig'],
               'uses'=>'HigienicoController@indexSustancias'
               ]);
           Route::get('/crearsustancias',[      //se utiliza para hig y cos
               'as'=>'crearsustancias',
               'middleware' => ['verifypermissions:cat.sustancias_cosmeticos_crear.coshig|cat.sustancias_higienicos_crear.coshig'],
               'uses'=>'CosmeticoController@crearSustancias'
               ]);
           Route::post('/guardarsustancias',[      //se utiliza para hig y cos
               'as'=>'savesustancias',
               'middleware' => ['verifypermissions:cat.sustancias_cosmeticos_crear.coshig|cat.sustancias_higienicos_crear.coshig'],
               'uses'=>'CosmeticoController@guardarSustancia'
               ]);

           Route::get('/getsustanciasCos',[      //se utiliza para cos
               'as'=>'dt.sust.cos',
               'middleware' => ['verifypermissions:cat.sustancias_cosmeticos_ver.coshig'],
               'uses'=>'CosmeticoController@getSustanciasCos'
               ]);
       
            Route::get('/getSustanciasHig',[      //se utiliza para hig 
               'as'=>'dt.sust.hig',
               'middleware' => ['verifypermissions:cat.sustancias_higienicos_ver.coshig'],
               'uses'=>'HigienicoController@getSustanciasHig'
               ]);

//rutas para catalogo de establecimientos            
            Route::get('/verFabricantesExt',[      
                         'as'=>'indexfabricantesext',
                         'middleware' => ['verifypermissions:cat.fabricantes_extranjeros_ver.coshig'],
                         'uses'=>'FabricanteExtranjeroController@indexFabricantesExtranjeros'
                         ]);

            Route::get('/getFabricantesExt',[
                         'as'=>'dt.fab.ext',
                         'middleware' => ['verifypermissions:cat.fabricantes_extranjeros_ver.coshig'],
                         'uses'=>'FabricanteExtranjeroController@getFabricantesExt'
                         ]);

            Route::get('/getFabExt',[
                         'as'=>'getCrearFabExt',
                         'middleware' => ['verifypermissions:cat.fabricantes_extranjeros_crear.coshig'],
                         'uses'=>'FabricanteExtranjeroController@getCrearFabExt'
                         ]);

            Route::post('/guardarFabExt',[
                         'as'=>'saveFabExt',
                         'middleware' => ['verifypermissions:cat.fabricantes_extranjeros_crear.coshig'],
                         'uses'=>'FabricanteExtranjeroController@saveFabExt'
                         ]);

            Route::get('/editarFabExt/{id}',[
                         'as'=>'editarFabExt',
                         'middleware' => ['verifypermissions:cat.fabricantes_extranjeros_editar.coshig'],
                         'uses'=>'FabricanteExtranjeroController@editarFabExt'
                         ]);

            Route::post('/actualizarFabExt',[
                         'as'=>'actualizarFabExt',
                         'middleware' => ['verifypermissions:cat.fabricantes_extranjeros_editar.coshig'],
                         'uses'=>'FabricanteExtranjeroController@actualizarFabExt'
                         ]);

            Route::get('/getFabricantesEstado',[
                         'as'=>'getFabricantesEstado',
                         'middleware' => ['verifypermissions:cat.fabricantes_extranjeros_ver.coshig'],
                         'uses'=>'FabricanteExtranjeroController@getFabricantesEstado'
                         ]);
           
	});



});