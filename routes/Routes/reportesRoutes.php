<?php
// Ruta para mantenimiento de catalogos generales
Route::group(['prefix' => 'reportes' , 'middleware' => ['auth' , 'verifypermissions:rpt.generacion_reportes.coshig']], function(){

// administrador
	Route::group(['prefix' => 'reporte'], function(){
			Route::get('/reportePortal',[
              'as'=>'indexReportePortal',
              'uses'=>'ReporteController@reportePortal'
            ]);
			Route::post('/generarReporte',[
              'as'=>'generarReporte',
              'uses'=>'ReporteController@generarReporte'
            ]);
            Route::get('/dtrows/solicitudes',[
		        'as' => 'solportal.dtrows-sol',
		        'uses' => 'ReporteController@getSolicitudesPortal'
		    ]);
		    Route::get('/reporteTrazabilidad',[
              'as'=>'indexReporteTrazabilidad',
              'uses'=>'ReporteController@reporteTrazabilidad'
            ]);
            Route::get('/dtrows/trazabilidad',[
		        'as' => 'dt.trazabilidad.sol',
		        'uses' => 'ReporteController@getSolicitudesTrazabilidad'
		    ]);
		    
	});

	


});
	