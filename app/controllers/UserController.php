<?php

class UserController extends BaseController {

	/**
	* Show the profile for the given user.
	*/
	public function showAccount()
	{
		$user = Auth::user();

		return View::make('user.index', compact('user'));
	}

	public function update()
        {
		$rules = array(
			'username' => 'Required|Min:3',
			'name' => 'Max:80|Alpha',
			'email'     => 'Required|Between:3,64|Email',
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::action('UserController@showAccount')
				->withErrors($validator)
				->withInput(Input::all());
		}

		$user = Auth::user();
		$user->name = Input::get('name');
		$user->username = Input::get('username');
		$user->email = Input::get('email');
		$user->save();

                return Redirect::action('UserController@showAccount');
        }
}
