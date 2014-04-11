<?php

class HomeController extends BaseController {


	public function index()
	{
		$data['options'] = Option::AllAsFlatten();

		$data['taps'] = ActiveTap::orderBy('id')->get();

		$data['backgroundUrl'] = Option::where('configName',OptionNames::BackgroundUrl)->first()->configValue;
		$data['backgroundRepeat'] = Option::where('configName',OptionNames::BackgroundRepeat)->first()->configValue;

		return View::make('home.index', $data);
	}

}