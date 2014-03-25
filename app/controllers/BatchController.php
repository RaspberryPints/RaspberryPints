<?php

class BatchController extends BaseController {

	public function index()
	{
		$data['batches'] = Batch::GetAllActive();

		return View::make('batches.index', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->loadFormViewData($data);

		return View::make('batches.create', $data);
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
			return Redirect::action('BatchController@create')
				->withErrors($validator)
				->withInput();
		} else {
			// store
			$batch = new Batch;
			$this->mapToDomain($batch);
			$batch->save();

			// redirect
			Session::flash('message', sprintf(Lang::get('common.itemSuccessfullyCreated'), Lang::get('batch')));
			return Redirect::action('BatchController@index');
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
		$data['batch'] = Batch::find($id);
		$this->loadFormViewData($data);

		// show the edit form and pass the nerd
		return View::make('batches.edit', $data);
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
			return Redirect::action('BatchController@edit', $id)
				->withErrors($validator)
				->withInput();

		} else {
			// store
			$batch = Batch::find($id);
			$this->mapToDomain($batch);
			$batch->save();

			// redirect
			Session::flash('message', sprintf(Lang::get('common.itemSuccessfullyUpdated'), Lang::get('batch')));
			return Redirect::action('BatchController@index');
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
		$data['beerList'] = Beer::GetAllActive()->lists('name','id');
		$data['kegList'] = Keg::GetAllActive()->lists('label','id');
	}

	private function validate(){
		$rules = array(
			'beerId' 	=> 'required',
			'kegId' 	=> 'required',
			'ogAct' 	=> 'numeric',
			'fgAct' 	=> 'numeric',
			'srmAct' 	=> 'numeric',
			'ibuAct' 	=> 'numeric',
			'startKg' 	=> 'numeric'
		);
		
		return Validator::make(Input::all(), $rules);
	}

	private function mapToDomain($batch){
		$batch->beerId     	= Input::get('beerId');
		$batch->kegId 		= Input::get('kegId');
		$batch->ogAct 		= Input::get('ogAct');
		$batch->fgAct 		= Input::get('fgAct');
		$batch->srmAct 		= Input::get('srmAct');
		$batch->ibuAct 		= Input::get('ibuAct');
		$batch->startKg		= Input::get('startKg');
	}

	public function inactivate($id)
	{
		$batch = Batch::find($id);
		$batch->active = false;
		$batch->save();

    	return Redirect::action('BatchController@index');
	}
	
}