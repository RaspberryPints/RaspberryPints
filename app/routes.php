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

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('admin', 'AdminController@index');

Route::get('admin/beer', 'BeerController@index');
Route::get('admin/beer/form/{id?}', 'BeerController@form');
Route::post('admin/beer/form_post/{id?}', 'BeerController@form_post');
Route::get('admin/beer/inactivate/{id}', 'BeerController@inactivate');
	
Route::get('admin/user', function()
{
    return View::make('user.index');
});