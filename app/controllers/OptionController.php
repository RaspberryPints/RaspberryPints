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


		$data['backgroundRepeat'] = Option::where('configName',OptionNames::BackgroundRepeat)->first();

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

	/**
	 * Update the specified resource in storage.
	 *
	 * @return Response
	 */
	public function replaceLogo()
	{		
		$validator = $this->validateImage();

		// process the login
		if ($validator->fails()) {
			return Response::json(array('success' => false, 'errors' => $validator->messages()->toJson()));

		} else {
			$destinationPath = '/img/';
			$filename = 'logo';
			$extension = '.' . Input::file('image')->getClientOriginalExtension();

			$option = Option::where('configName',OptionNames::LogoUrl)->first();
			if ( starts_with($option->configValue, $destinationPath . $filename) ){
				File::delete( public_path() . $option->configValue );
			}

			Input::file('image')->move( public_path() . $destinationPath, $filename . $extension);

			$option->configValue = $destinationPath . $filename . $extension;
			$option->save();

			return Response::json(array('success' => true));
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @return Response
	 */
	public function replaceBackground()
	{		
		$validator = $this->validateImage();

		// process the login
		if ($validator->fails()) {
			return Response::json(array('success' => false));

		} else {
			$destinationPath = '/img/';
			$filename = 'background';
			$extension = '.' . Input::file('image')->getClientOriginalExtension();

			$option = Option::where('configName',OptionNames::BackgroundUrl)->first();
			if ( starts_with($option->configValue, $destinationPath . $filename) ){
				File::delete( public_path() . $option->configValue );
			}

			Input::file('image')->move( public_path() . $destinationPath, $filename . $extension);

			$option->configValue = $destinationPath . $filename . $extension;
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

	private function validateImage(){
		$rules = array(
			'image' => 'required|image'
		);
		
		return Validator::make(Input::all(), $rules);
	}

	private function mapToDomain($option){
		$option->configValue       = Input::get('configValue');
	}

}