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
		if( $id ){
			$data['beer'] = Beer::find($id);
		}else{
			$data['beer'] = new Beer();
		}

		$data['beerStyleList'] = BeerStyle::orderBy('name')->lists('name','id');

		return View::make('beer.form', $data);
	}

	public function form_post($id = null){
		$rules = array(
	        'name' => array('required')
	    );

	    $validation = Validator::make(Input::all(), $rules);

	    if ($validation->fails())
	    {
	        // Validation has failed.
	        //return Redirect::action('BeerController@form')->with_input()->with_errors($validation);
	        return Redirect::action('BeerController@form')->withInput()->withErrors($validation);
	    }

	    return Redirect::action('BeerController@index');
	}

	public function inactivate($id)
	{
		$beer = Beer::find($id);
		$beer->active = false;
		$beer->save();

    	return Redirect::action('BeerController@index');
	}
	
	
}