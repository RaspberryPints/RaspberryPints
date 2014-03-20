<?php

class KegController extends BaseController {

	public function index()
	{
		$data['kegs'] = Keg::GetAllActive();

		return View::make('kegs.index', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->loadFormViewData($data);

		return View::make('kegs.create', $data);
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
			return Redirect::action('KegController@create')
				->withErrors($validator)
				->withInput();
		} else {
			// store
			$keg = new Keg;
			$this->mapToDomain($keg);
			$keg->save();

			// redirect
			Session::flash('message', sprintf(Lang::get('common.itemSuccessfullyCreated'), Lang::get('keg')));
			return Redirect::action('KegController@index');
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
		$data['keg'] = Keg::find($id);
		$this->loadFormViewData($data);

		// show the edit form and pass the nerd
		return View::make('kegs.edit', $data);
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
			return Redirect::action('KegController@edit', $id)
				->withErrors($validator)
				->withInput();

		} else {
			// store
			$keg = Keg::find($id);
			$this->mapToDomain($keg);
			$keg->save();

			// redirect
			Session::flash('message', sprintf(Lang::get('common.itemSuccessfullyUpdated'), Lang::get('keg')));
			return Redirect::action('KegController@index');
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
		$data['kegTypeList'] = KegType::orderBy('name')->lists('name','id');
		$data['kegStatusList'] = KegStatus::orderBy('name')->lists('name','code');
	}

	private function validate(){
		$rules = array(
			'label'      => 'required|numeric'
		);
		
		return Validator::make(Input::all(), $rules);
	}

	private function mapToDomain($keg){
		$keg->label 		= Input::get('label');
		$keg->kegTypeId 	= Input::get('kegTypeId');
		$keg->make 			= Input::get('make');
		$keg->model 		= Input::get('model');
		$keg->serial 		= Input::get('serial');
		$keg->stampedOwner 	= Input::get('stampedOwner');
		$keg->stampedLoc 	= Input::get('stampedLoc');
		$keg->notes 		= Input::get('notes');
		$keg->kegStatusCode = Input::get('kegStatusCode');
		$keg->weight 		= Input::get('weight');
	}	

	public function inactivate($id)
	{
		$beer = Keg::find($id);
		$beer->active = false;
		$beer->save();

    	return Redirect::action('KegController@index');
	}
}