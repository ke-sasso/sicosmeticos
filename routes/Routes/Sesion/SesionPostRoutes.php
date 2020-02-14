<?php
/**
 * Created by PhpStorm.
 * User: steven.mena
 * Date: 19/9/2018
 * Time: 10:13 AM
 */
Route::group(['prefix' => 'SesionesPost' , 'middleware' => ['auth']], function(){

    Route::get('/index',[
        'as'=>'index.sesionespost',
        'middleware' => ['verifypermissions:post.solicitudes_ingresar_sesion.coshig'],
        'uses'=>'Sesion\SesionPostController@indexSesion'
    ]);
    Route::get('/index/aprobar',[
        'as'=>'index.aprobar.sesionespost',
        'middleware' => ['verifypermissions:post.solicitudes_aprobar_sesion.coshig'],
        'uses'=>'Sesion\SesionPostController@indexSesionAprobar'
    ]);

    Route::get('/getSesiones',[
        'as'=>'getsesiones.sesionespost',
        'middleware' => ['verifypermissions:post.solicitudes_ingresar_sesion.coshig'],
        'uses'=>'Sesion\SesionPostController@getSesiones'
    ]);
       Route::get('/getSesiones/jefes',[
        'as'=>'getsesiones.sesionespost.jefes',
           'middleware' => ['verifypermissions:post.solicitudes_aprobar_sesion.coshig'],
        'uses'=>'Sesion\SesionPostController@getSesionesJefes'
    ]);


    Route::get('/agregarSolicitudes/{idSesion}',[
        'as'=>'agregarsolicitudes.sesionespost',
        'middleware' => ['verifypermissions:post.solicitudes_ingresar_sesion.coshig'],
        'uses'=>'Sesion\SesionPostController@agregarSolicitudes'
    ]);

     Route::get('/aprobarSolicitudes/{idSesion}',[
        'as'=>'aprobarsolicitudes.sesionespost',
         'middleware' => ['verifypermissions:post.solicitudes_aprobar_sesion.coshig'],
        'uses'=>'Sesion\SesionPostController@aprobarSolicitudes'
    ]);

    Route::get('/solicitudesFav',[
        'as'=>'dt.rows.solfav.sesionespost',
        'middleware' => ['verifypermissions:post.solicitudes_ingresar_sesion.coshig'],
        'uses'=>'Sesion\SesionPostController@dtRowsSolPostFav'
    ]);

     Route::get('/solicitudesAgregadas',[
        'as'=>'dt.rows.solagregadas.sesionespost',
         'middleware' => ['verifypermissions:post.solicitudes_ingresar_sesion.coshig'],
        'uses'=>'Sesion\SesionPostController@dtRowsSolPostAgregadas'
    ]);

    Route::post('/addSolPost',[
        'as'=>'addsol.sesionpost',
        'middleware' => ['verifypermissions:post.solicitudes_ingresar_sesion.coshig'],
        'uses'=>'Sesion\SesionPostController@addSolPostSesion'
    ]);

    Route::post('/aprobarSolPost',[
        'as'=>'aprobarsol.sesionpost',
        'middleware' => ['verifypermissions:post.solicitudes_aprobar_sesion.coshig'],
        'uses'=>'Sesion\SesionPostController@aprobarSolPostSesion'
    ]);

    Route::post('/desaprobarSolPost',[
        'as'=>'desaprobarsol.sesionpost',
        'middleware' => ['verifypermissions:post.solicitudes_aprobar_sesion.coshig'],
        'uses'=>'Sesion\SesionPostController@desaprobarSol'
    ]);


    //Vista de certificacion sol post
    Route::get('/certificacionSolPost',[
        'as'=>'certificacion.sol.sesionespost',
        'middleware' => ['verifypermissions:post.solicitudes_admin_certificaciones.coshig'],
        'uses'=>'Sesion\SesionPostController@certificacionSolPost'
    ]);

    Route::get('/getSesionesCertificacion',[
        'as'=>'certificacion.sesionespost',
        'middleware' => ['verifypermissions:post.solicitudes_admin_certificaciones.coshig'],
        'uses'=>'Sesion\SesionPostController@getSesionesCertificacion'
    ]);

    Route::get('/solsACertificar/{idSesion}',[
        'as'=>'sols.certificar.sesionespost',
        'middleware' => ['verifypermissions:post.solicitudes_admin_certificaciones.coshig'],
        'uses'=>'Sesion\SesionPostController@certificarSolicitudes'
    ]);

    Route::get('/getsolsACertificar',[
        'as'=>'dt.rows.sols.sesionespost',
        'middleware' => ['verifypermissions:post.solicitudes_admin_certificaciones.coshig'],
        'uses'=>'Sesion\SesionPostController@dtRowsCertificacionSolPost'
    ]);

    Route::post('/certificarSolicitudesSesion',[
        'as'=>'sesion.certificar.postSol',
        'middleware' => ['verifypermissions:post.solicitudes_certificar_ses.coshig'],
        'uses'=>'Sesion\SesionPostController@storeCertificarPost'
    ]);






});