<?php
// Ruta para consultas generales
Route::group(['prefix' => 'consultas' , 'middleware' => ['auth']], function(){

// administrador
	Route::group(['prefix' => 'tools'], function(){
          // rutas para Catalogo envases
          Route::get('/getPaises',[
          	'as'=>'buscarPaises',
          	'uses'=>'ToolsController@getPaisesSelect'
          	]);
          Route::get('/getPropietarios',[
               'as'=>'buscarPropietarios',

               'uses'=>'ToolsController@buscarPropietarios'
          ]);
          Route::get('/obtenerPropietario',[
               'as'=>'get.titular',

               'uses'=>'ToolsController@getTitular'
          ]);
            Route::get('/getMarcas',[
               'as'=>'buscar.marcas',

               'uses'=>'ToolsController@buscarMarcas'
          ]);
            Route::get('/getClasificaciones',[
               'as'=>'buscar.clasificacion',

               'uses'=>'ToolsController@buscarClasificaciones'
          ]);
            Route::get('/getProfesional',[
               'as'=>'get.profesional',

               'uses'=>'ToolsController@getProfesionalByPoder'
          ]);

          Route::post('/buscarDistribuidor',[
               'as'=>'buscarDistribuidoresAjaxPorId',

               'uses'=>'ToolsController@buscarDistribuidor'
          ]);
          Route::get('/buscarDistribuidores',[
               'as'=>'buscarDistribuidoresAjax',

               'uses'=>'ToolsController@buscarDistribuidores'
               ]);

         Route::get('/buscarFabricantes',[
               'as'=>'buscarFabricantesAjax',
               'uses'=>'ToolsController@buscarFabricantes'
               ]);

          Route::post('/getFabricante',[
               'as'=>'buscarFabricanteAjaxPorId',

               'uses'=>'ToolsController@getFabricante'
               ]);
          Route::post('/getImportador',[
               'as'=>'buscarImportadorAjaxPorId',

               'uses'=>'ToolsController@getImportador'
               ]);

          Route::get('/buscarImportadores',[
               'as'=>'buscarImportadoresAjax',

               'uses'=>'ToolsController@buscarImportadores'
               ]);

          Route::get('/consultaMandamiento',[
                'as'=>'consulta.mandamiento.tools',
                'middleware'=>['verifypermissions:sistema.consultar_mandamiento.coshig'],
                'uses'=>'ToolsController@consultarMandamiento'
          ]);
               Route::get('/getenvases',[
               'as'=>'get.envases.producto',
               'uses'=>'ToolsController@getEvansesPost'
               ]);
                 Route::get('/getmaterial',[
               'as'=>'get.material.producto',
               'uses'=>'ToolsController@getMateriales'
               ]);
                    Route::get('/getunidad',[
               'as'=>'get.unidad.producto',
               'uses'=>'ToolsController@getUnidadesMedida'
               ]);

	});



});