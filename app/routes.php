<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');


Route::get('login', 'AdminController@showLogin')->before('guest');
Route::post('login', 'AdminController@doLogin');
Route::get('logout', 'AdminController@doLogout');


Route::group(array('before' => 'auth'), function() 
{
	Route::get('admin', 'AdminController@index');

	Route::resource('admin/beers', 'BeerController');
	Route::get('admin/beer/inactivate/{id}', 'BeerController@inactivate');
	
	Route::resource('admin/kegs', 'KegController');
	Route::get('admin/kegs/inactivate/{id}', 'KegController@inactivate');
	
	Route::resource('admin/batches', 'BatchController');
	Route::get('admin/batches/inactivate/{id}', 'BatchController@inactivate');

	Route::get('admin/taps/', 'TapController@index');
	Route::get('admin/taps/updateBatch/', 'TapController@updateBatch');
	//Route::get('admin/taps/numTaps/{numTaps}', 'TapController@updateNumTaps');
	
	Route::get('admin/user', function()
	{
	    return View::make('user.index');
	});
});