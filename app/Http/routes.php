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
Route::get('auth/loginmanager','Auth\AuthController@postLoginManager'); //login for clients
Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::group(['middleware' => ['auth','admin']], function() { //group for admin
    Route::get('client/account', 'ClientController@index');
    Route::get('client/account/manager', 'ClientController@getManager');

});
Route::group(['middleware' => ['auth']], function() { //group for manager
    Route::get('manager/account', 'ManagerController@index');
});