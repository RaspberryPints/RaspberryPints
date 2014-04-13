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

	Route::get('admin/myAccount', 'UserController@showAccount');
	Route::put('admin/myAccount/update', 'UserController@update');

	Route::resource('admin/beers', 'BeerController');
	Route::get('admin/beer/inactivate/{id}', 'BeerController@inactivate');

	Route::resource('admin/kegs', 'KegController');
	Route::get('admin/kegs/inactivate/{id}', 'KegController@inactivate');

	Route::resource('admin/batches', 'BatchController');
	Route::get('admin/batches/inactivate/{id}', 'BatchController@inactivate');


	Route::get('admin/taps/destroy/{id}', 'TapController@destroy');
	Route::put('admin/taps/store/', 'TapController@store');
	Route::put('admin/taps/updateName/{id}', 'TapController@updateName');
	Route::put('admin/taps/updateBatch/{id}', 'TapController@updateBatch');
	Route::resource('admin/taps', 'TapController');

	Route::get('admin/options/', 'OptionController@index');
	Route::put('admin/options/update/{id}', 'OptionController@update');
	Route::put('admin/options/replaceLogo', 'OptionController@replaceLogo');
	Route::put('admin/options/replaceBackground', 'OptionController@replaceBackground');

	Route::get('admin/user', function()
	{
	    return View::make('user.index');
	});
});
