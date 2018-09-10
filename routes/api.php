<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([], function() {
	Route::post('/auth', 'API\AuthController@authenticate')->name('api.auth.token');
});

Route::group(['middleware' => 'auth:api'], function() {

	Route::get('/me', 'API\AuthController@identity')->name('api.auth.identity');


	Route::get('/locks', 'API\LocksController@index')->name('api.locks.index');
	Route::get('/locks/{lock}', 'API\LocksController@show')->name('api.locks.show');
	Route::put('/locks/{lock}', 'API\LocksController@update')->name('api.locks.update');

});
