<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//default route
Route::get('/','BusinessController@index');
//registration route
Route::get('auth/registration', 'Auth\AuthController@getRegister'); //view auth/register
Route::post('auth/registration', 'Auth\AuthController@postRegister'); //receive data from registration form
Route::get('auth/active', 'Auth\AuthController@postActivate'); //activate user account


Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin'); //login for clients (administrator)
Route::post('auth/loginmanager','Auth\AuthController@postLoginManager'); //login for clients
Route::get('auth/logout', 'Auth\AuthController@getLogout');

//client route group
Route::group(['middleware' => ['admin']], function() { //group for admin
    Route::get('client/account', 'Client\ClientController@index');
    Route::get('client/account/manager', 'Client\ClientManagerController@index'); //config manager list
    Route::post('client/account/manager', 'Client\ClientManagerController@create'); //create new manager
    Route::delete('client/account/manager/{id}','Client\ClientManagerController@destroy'); //delete old manager from list

    Route::get('client/account/script', 'Client\ClientScriptController@index'); //config script list
    Route::post('client/account/script', 'Client\ClientScriptController@store'); //add new script
    //Route::get('client/account/script/{id}', 'Client\ClientScriptController@show'); //add show script to edit
    Route::post('client/account/script/edit','Client\ClientScriptController@edit'); //edit script block


});
//manager route group
Route::group(['middleware' => ['auth']], function() { //group for manager
    Route::get('manager/account', 'Manager\ManagerController@index'); // manager default view
    Route::get('manager/account/{id}', 'Manager\ManagerController@show'); // manager default view
});