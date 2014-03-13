<?php

class BeerController extends BaseController {

	public function index()
	{
		$beers = Beer::orderBy('name')->get();

		$data = array('beers' => $beers);



		return View::make('beer.index_php', $data);
	}

	public function form($id = null)
	{
		$data = array(
			'id' => $id
		);

		return View::make('beer.form', $data);
	}

	public function inactivate($id)
	{
		$beer = Beer::find($id);
		$beer->active = false;
		$beer->save();

    	return Redirect::action('BeerController@index');
	}
	
	
}