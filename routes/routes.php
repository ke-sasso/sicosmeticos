<?php
/*
	This method include all Routes archives from Routes Directory
	By Kevin Alvarez

*/
foreach (new DirectoryIterator(__DIR__.'/Routes') as $file)
{
    if (!$file->isDot() && !$file->isDir() && $file->getFilename() != '.gitignore')
    {
        require_once __DIR__.'/Routes/'.$file->getFilename();
        //require_once __DIR__.'/Routes/'.$file->getFilename();
    }
}

foreach (new DirectoryIterator(__DIR__.'/Routes/PostRegistro/') as $file)
{
    if (!$file->isDot() && !$file->isDir() && $file->getFilename() != '.gitignore')
    {
        require_once __DIR__.'/Routes/PostRegistro/'.$file->getFilename();
        //require_once __DIR__.'/Routes/'.$file->getFilename();
    }
}

foreach (new DirectoryIterator(__DIR__.'/Routes/Sesion/') as $file)
{
    if (!$file->isDot() && !$file->isDir() && $file->getFilename() != '.gitignore')
    {
        require_once __DIR__.'/Routes/Sesion/'.$file->getFilename();
    }
}
foreach (new DirectoryIterator(__DIR__.'/Routes/AdminIT/') as $file)
{
    if (!$file->isDot() && !$file->isDir() && $file->getFilename() != '.gitignore')
    {
        require_once __DIR__.'/Routes/AdminIT/'.$file->getFilename();
    }
}


Route::get('/', ['as' => 'doLogin', 'uses' => 'CustomAuthController@getLogin']);
Route::post('/login', ['as' => 'login', 'uses' =>'CustomAuthController@postLogin']);
Route::get('/login', ['uses'=>'InicioController@index']);
Route::get('/logout', 'CustomAuthController@getLogout');
Route::get('cfg/menu', 'InicioController@cfgHideMenu');

Route::group(['middleware' => ['verifypermissions:sistema.ingreso.coshig']], function() {
	Route::get('/inicio',[
	    'as' => 'doInicio',
	    'uses' => 'InicioController@index']
    );
});

Route::group(['prefix' => 'cosapi' , 'middleware' => ['verifyapikeyaccess']], function() {
    Route::get('/resolucion/{idSol}',[
        'uses' => 'Api\ApiController@pdfResolucionBySol']);
    Route::get('/resolucion/post/{idSolicitud}/{idDictamen}',[
        'uses' => 'Api\PostController@pdfDictamenPost']);
});


