<?php
/**
 * Created by PhpStorm.
 * User: steven.mena
 * Date: 15/8/2018
 * Time: 12:03 PM
 */
Route::group(['prefix' => 'solicitudesPost' , 'middleware' => ['auth']], function(){


        Route::get('/nuevaSolicitud',[
            'as'=>'nuevasolicitud.post',
            'middleware'=>['verifypermissions:post.nueva_solicitud.coshig'],
            'uses'=>'SolicitudesPost\SolicitudesPostController@nuevaSolicitud'
        ]);

        Route::get('/administrador',[
            'as'=>'administrador.post',
            'middleware'=>['verifypermissions:post.admin_solicitudes.coshig'],
            'uses'=>'SolicitudesPost\SolicitudesPostController@adminSolicitudes'
        ]);

        Route::get('/dtrows/solicitudes',[
            'as'=>'dtrows.solicitudes.post',
            'middleware'=>['verifypermissions:post.admin_solicitudes.coshig'],
            'uses'=>'SolicitudesPost\SolicitudesPostController@getDtRowSolicitudes'
        ]);

        Route::get('/admin/certificacion',[
            'as'=>'admin.certificacion.post',
            'middleware'=>['verifypermissions:post.solicitudes_admin_certificaciones_sin_sesion.coshig'],
            'uses'=>'SolicitudesPost\SolicitudesPostController@certificarSolicitudes'
        ]);

        Route::get('/dtrows/certificar/solicitudes',[
            'as'=>'dtrows.certificar.sol.post',
            'middleware'=>['verifypermissions:post.solicitudes_admin_certificaciones_sin_sesion.coshig'],
            'uses'=>'SolicitudesPost\SolicitudesPostController@getDtRowCertificarSol'
        ]);

        Route::get('/revisar/solicitud/{idSolicitud}',[
            'as'=>'revisar.solicitud.post',
            'middleware'=>['verifypermissions:post.admin_solicitudes_detalle.coshig'],
            'uses'=>'SolicitudesPost\SolicitudesPostController@revisionSolicitud'
        ]);

        Route::get('/productos',[
            'as'=>'productos.post',
            'uses'=>'SolicitudesPost\SolicitudesPostController@getProductos'
        ]);

        Route::post('/dataProducto',[
            'as'=>'dataproducto.post',
            'uses'=>'SolicitudesPost\SolicitudesPostController@getDatosProducto'
        ]);

        Route::post('/gnralProducto',[
            'as'=>'gnralproducto.post',
            'uses'=>'SolicitudesPost\SolicitudesPostController@getGeneralesProducto'
        ]);

        Route::post('/store',[
            'as'=>'store.post',
            'middleware'=>['verifypermissions:post.nueva_solicitud.coshig'],
            'uses'=>'SolicitudesPost\SolicitudesPostController@store'
        ]);

        Route::post('/storeRevision',[
            'as'=>'store.revision.post',
            'middleware'=>['verifypermissions:post.admin_soliciutdes_dictaminar.coshig'],
            'uses'=>'SolicitudesPost\SolicitudesPostController@storeRevisionSol'
        ]);

        Route::get('/solicitud/certificar',[
            'as'=>'solicitud.certificar.post',
            'middleware'=>['verifypermissions:post.solicitudes_certificar_sin_sesion.coshig'],
            'uses'=>'SolicitudesPost\SolicitudesPostController@solicitudFavorable'
        ]);

        Route::post('/certificar',[
            'as'=>'certificar.post',
            'middleware'=>['verifypermissions:post.solicitudes_certificar_sin_sesion.coshig'],
            'uses'=>'SolicitudesPost\SolicitudesPostController@certificarSol'
        ]);

        Route::get('/documentobyRequisito',[
            'as'=>'doc.requisito.post',
            'uses'=>'SolicitudesPost\SolicitudesPostController@docByRequisito'
        ]);

        Route::get('/requisitoByTramite',[
            'as'=>'requisitos.tramite.post',
            'uses'=>'SolicitudesPost\SolicitudesPostController@getRequisitosByTramite'
        ]);


        Route::get('/certificacionpdf',[
            'as'=>'certificacion.requisito.post',
            'middleware'=>['verifypermissions:post.solicitudes_imprimir_cvl.coshig|post.solicitudes_imprimir_certificacion_sin_sesion.coshig'],
            'uses'=>'SolicitudesPost\PdfController@pdfCertificacion'
        ]);

        Route::get('/certificacionespdf',[
            'as'=>'certificaciones.post',
            'middleware'=>['verifypermissions:post.solicitudes_imprimir_cvl.coshig|post.solicitudes_imprimir_certificacion_sin_sesion.coshig'],
            'uses'=>'SolicitudesPost\SolicitudesPostController@pdfAllCertificaciones'
        ]);

        Route::get('/ampliacionfragancia',[
            'as'=>'ampliacionfragancia.post',
            'uses'=>'SolicitudesPost\SolicitudesPostController@franganciaNewView'
        ]);

        Route::get('/ampliaciontono',[
            'as'=>'ampliaciontono.post',
            'uses'=>'SolicitudesPost\SolicitudesPostController@tonoNewView'
        ]);

        Route::get('/fechareconocimiento',[
            'as'=>'fechareconocimiento.post',
            'uses'=>'SolicitudesPost\SolicitudesPostController@fechareconocimientoNewView'
        ]);
         Route::get('/cambio-presentación',[
            'as'=>'cambiopresentacion.post',
            'permissions' => [475],
            'uses'=>'SolicitudesPost\SolicitudesPostController@cambioPresentacionView'
        ]);
         Route::get('/cambio-formulacion',[
            'as'=>'cambioformulacion.post',
            'permissions' => [475],
            'uses'=>'SolicitudesPost\SolicitudesPostController@cambioFormulacionNewView'
        ]);
           Route::get('/cambio-nombrecomercial',[
            'as'=>'cambiodenombre.post',
            'permissions' => [475],
            'uses'=>'SolicitudesPost\SolicitudesPostController@cambioNombreComercialNewView'
        ]);

         Route::post('/generarMandamiento',[
            'as'=>'generar.mandamiento.post',
            'uses'=>'SolicitudesPost\MandamientoController@generarMandamiento'
        ]);

        Route::post('/validarMandamiento/postSol',[
            'as'=>'validar.mandamiento.post',
            'uses'=>'SolicitudesPost\MandamientoController@validarMandamientoPost'
        ]);
         Route::post('/validarMandamiento/revisionPost',[
            'as'=>'validar.mandamiento.revision',
            'uses'=>'SolicitudesPost\MandamientoController@validarMandamientoRevision'
        ]);

         Route::get('/boleta/mandamiento',[
            'as'=>'pdf.mandamiento.boleta',
            'uses'=>'SolicitudesPost\MandamientoController@boletaMandamiento'
        ]);

        Route::get('/dictamen/herramienta/{idDictamen}',[
            'as'=>'pdf.dictamen.herramienta',
            'uses'=>'SolicitudesPost\PdfController@herramientaDictamen'
        ]);
        Route::get('/dictamen/resolucion/{idDictamen}',[
            'as'=>'pdf.dictamen.resolucion',
            'uses'=>'SolicitudesPost\PdfController@resolucionDictamen'
        ]);
        Route::get('/resolucion/desfavorable/{idSolicitud}',[
            'as'=>'pdf.dictamen.post.desfavorable',
            'uses'=>'SolicitudesPost\PdfController@pdfCertificacionDesfavorable'
        ]);
         Route::post('/cambiarEstado/documentoCertificacion',[
            'as'=>'post.cambiarestado.documentocertificacion',
            'uses'=>'SolicitudesPost\PdfController@cambiarEstadoDocCertificacion'
        ]);


        Route::group(['prefix' => 'asignaciones'], function(){
                Route::get('/post',[
                        'as'=>'solicitudes.post.nueva.asignaciones',
                        'middleware'=>['verifypermissions:post.asignar_solicitudes.coshig'],
                        'uses'=>'SolicitudesPost\AsignacionesController@index'
                ]);
                Route::get('/get/solicitudes',[
                    'as'=>'solicitudes.post.get.asignaciones',
                    'middleware'=>['verifypermissions:post.asignar_solicitudes.coshig'],
                    'uses'=>'SolicitudesPost\AsignacionesController@getSolicitudesAsignarPost'
                ]);
                Route::post('/store/post',[
                        'as'=>'solicitudes.post.asignaciones.store',
                        'middleware'=>['verifypermissions:post.asignar_solicitudes.coshig'],
                        'uses'=>'SolicitudesPost\AsignacionesController@store'
                ]);

                Route::get('/tecnico',[
                        'as'=>'solicitudes.tecnico.post',
                        'middleware'=>['verifypermissions:post.ver_asignadas.coshig'],
                        'uses'=>'SolicitudesPost\AsignacionesController@solicitudesTecnico'
                ]);
                Route::get('/get/tecnico',[
                        'as'=>'solicitudes.get.tecnico.post',
                        'middleware'=>['verifypermissions:post.ver_asignadas.coshig'],
                        'uses'=>'SolicitudesPost\AsignacionesController@getSolicitudesTecnicoPost'
                ]);
                 Route::get('/post/{idSolicitud}',[
                        'as'=>'index.asignar.post.sol',
                        'permissions' => [475],
                        'uses'=>'SolicitudesPost\AsignacionesController@indexAsignaciones'
                ]);

        });



});