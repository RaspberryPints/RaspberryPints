<?php

class OptionController extends BaseController {


	public function index()
	{
		$data['showHideCols'] = Option::where('showOnPanel','1')->orderBy('displayName')->get();

		$data['showHideColsList'] =  array(
		    '1' => Lang::get('common.show'),
    		'0' => Lang::get('common.hide'),
    	);

		$data['headerText'] = Option::where('configName',OptionNames::HeaderText)->first();
		$data['headerTextTruncLen'] = Option::where('configName',OptionNames::HeaderTextTruncLen)->first();

		// load the view and pass the nerds
		return View::make('options.index', $data);
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
			return Response::json(array('success' => false));

		} else {
			// store
			$option = Option::find($id);
			$this->mapToDomain($option);
			$option->save();

			return Response::json(array('success' => true));
		}
	}

	private function validate(){
		$rules = array(
			'configValue' => 'required'
		);
		
		return Validator::make(Input::all(), $rules);
	}

	private function mapToDomain($option){
		$option->configValue       = Input::get('configValue');
	}

}