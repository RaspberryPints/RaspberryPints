<?php

class AdminController extends BaseController {

	public function index()
	{
		return View::make('admin.index');			
	}

	public function showLogin()
	{
		return View::make('admin.login');
	}

	public function doLogin()
	{
		$rules = array(
			'username'    => 'required',
			'password' => 'required|alphaNum|min:3'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::action('AdminController@showLogin')
				->withErrors($validator)
				->withInput(Input::except('password'));

		} else {
			$userdata = array(
				'username' 	=> Input::get('username'),
				'password' 	=> Input::get('password')
			);

			if (Auth::attempt($userdata)) {
				return Redirect::action('AdminController@index');

			} else {	
				$user = User::where('username','=',Input::get('username'))->first();
				if(isset($user)) {
				    if($user->password == md5(Input::get('password'))) { // If their password is still MD5
				        $user->password = Hash::make(Input::get('password')); // Convert to new format
				        $user->save();
				        Auth::login($user);
				        return Redirect::action('AdminController@index');
				    }
				}

				return Redirect::action('AdminController@showLogin');

			}
		}
	}

	public function doLogout()
	{
		Auth::logout();
		return Redirect::action('HomeController@index');
	}
}