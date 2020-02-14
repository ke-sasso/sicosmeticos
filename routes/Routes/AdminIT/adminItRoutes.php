<?php
Route::group(['prefix' => 'admin_it'], function () {
    Route::get('/impersonate/{user}',[
        'as'    =>  'adminit.impersonate.user',
        'uses'  =>  'CustomAuthController@impersonateUser'
    ]);
});