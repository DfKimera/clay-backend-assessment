<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([], function () {

	Route::get('/', function() {
		if(auth()->guest()) return redirect()->route('auth.index');
		return redirect()->route('admin.dashboard');
	});

    Route::get('/login', 'Admin\AuthController@index')->name('auth.index');
    Route::post('/login', 'Admin\AuthController@login')->name('auth.login');
    Route::post('/logout', 'Admin\AuthController@logout')->name('auth.logout');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth:web'], function() {

	Route::get('/', 'Admin\DashboardController@index')->name('admin.dashboard');

	Route::get('/accessors', 'Admin\AccessorsController@index')->name('admin.accessors.index');
	Route::get('/accessors/new', 'Admin\AccessorsController@create')->name('admin.accessors.create');
	Route::get('/accessors/{accessor}', 'Admin\AccessorsController@edit')->name('admin.accessors.edit');
	Route::post('/accessors/{accessor?}', 'Admin\AccessorsController@save')->name('admin.accessors.save');
	Route::delete('/accessors/{accessor}', 'Admin\AccessorsController@destroy')->name('admin.accessors.destroy');

	Route::get('/locks', 'Admin\LocksController@index')->name('admin.locks.index');
	Route::get('/locks/new', 'Admin\LocksController@create')->name('admin.locks.create');
	Route::get('/locks/{lock}', 'Admin\LocksController@edit')->name('admin.locks.edit');
	Route::post('/locks/{lock?}', 'Admin\LocksController@save')->name('admin.locks.save');
	Route::post('/locks/{lock?}/accessors', 'Admin\LocksController@update_authorized_accessors')->name('admin.locks.update_authorized_accessors');
	Route::delete('/locks/{lock}', 'Admin\LocksController@destroy')->name('admin.locks.destroy');

});
