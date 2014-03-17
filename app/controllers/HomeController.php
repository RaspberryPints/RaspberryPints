<?php

class HomeController extends BaseController {


	public function index()
	{
		$data['options'] = Option::select('configName', 'configValue')->get();
		
		$data['taps'] = ActiveTap::all();

		return View::make('home.index', $data);
	}

}