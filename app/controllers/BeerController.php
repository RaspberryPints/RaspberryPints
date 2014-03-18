<?php

class BeerController extends BaseController {

	public function index()
	{
		$data['beers'] = Beer::orderBy('name')->get();

		// load the view and pass the nerds
		return View::make('beers.index', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->loadFormViewData($data);

		return View::make('beers.create', $data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = $this->validate();

		// process the login
		if ($validator->fails()) {
			return Redirect::action('BeerController@create')
				->withErrors($validator)
				->withInput();
		} else {
			// store
			$beer = new Beer;
			$this->mapToDomain($beer);
			$beer->save();

			// redirect
			Session::flash('message', sprintf(Lang::get('common.itemSuccessfullyCreated'), Lang::get('beer')));
			return Redirect::action('BeerController@index');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$data['beer'] = Beer::find($id);
		$this->loadFormViewData($data);

		// show the edit form and pass the nerd
		return View::make('beers.edit', $data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		
		$validator = $this->validate();

		// process the login
		if ($validator->fails()) {
			return Redirect::action('BeerController@edit', $id)
				->withErrors($validator)
				->withInput();

		} else {
			// store
			$beer = Beer::find($id);
			$this->mapToDomain($beer);
			$beer->save();

			// redirect
			Session::flash('message', sprintf(Lang::get('common.itemSuccessfullyUpdated'), Lang::get('beer')));
			return Redirect::action('BeerController@index');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	private function loadFormViewData(&$data){
		$data['beerStyleList'] = BeerStyle::orderBy('name')->lists('name','id');
	}

	private function validate(){
		$rules = array(
			'name'      => 'required',
			'ogEst' 	=> 'required|numeric',
			'fgEst' 	=> 'required|numeric',
			'srmEst' 	=> 'required|numeric',
			'ibuEst' 	=> 'required|numeric'
		);
		
		return Validator::make(Input::all(), $rules);
	}

	private function mapToDomain($beer){
		$beer->name       = Input::get('name');
		$beer->beerStyleId = Input::get('beerStyleId');
		$beer->notes      = Input::get('notes');
		$beer->ogEst 	= Input::get('ogEst');
		$beer->fgEst 	= Input::get('fgEst');
		$beer->srmEst 	= Input::get('srmEst');
		$beer->ibuEst 	= Input::get('ibuEst');
	}

	public function inactivate($id)
	{
		$beer = Beer::find($id);
		$beer->active = false;
		$beer->save();

    	return Redirect::action('BeerController@index');
	}
	
}