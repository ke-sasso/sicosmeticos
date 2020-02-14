<?php

Route::group(['prefix' => 'archivosPost' , 'middleware' => ['auth' ]], function(){

        Route::get('/mapeo',[
            'as'=>'mapeo.archivos.post.sol',
            'uses'=>'SolicitudesPost\ExportarArchivosPostController@mapeoArchivosPost'
        ]);

});