<?php

class TapController extends BaseController {

	public function index()
	{
		$data['taps'] = Tap::orderBy('tapIndex')->get();

		$this->loadFormViewData($data);

		return View::make('taps.index', $data);
	}

	/**
	 * Assign a batch to the tap
	 *
	 * @return Response
	 */
	public function updateBatch()
	{
		$tap = Tap::find( Input::get('id') );

		$tap->batchId = null;
		if( Input::get('batchId') != "" )
			$tap->batchId = Input::get('batchId');

		$tap->save();

		return Response::json(array('success' => true));
	}

	/**
	 * Assign a batch to the tap
	 *
	 * @return Response
	 //*/
	public function updateNumTaps()
	{
		$option = Option::GetByName( OptionNames::NumberOfTaps );
		$prevNumTaps = $option->configValue;
		$option->configValue = Input::get('configValue');
		$option->save();

		DB::statement('UPDATE taps SET active = (?)', array('0'));

		for( $t = 1; $t <= $option->configValue; $t++ ){
			$tap = Tap::firstOrNew(array('tapNumber' => $t));

			$tap->tapNumber = $t;
			$tap->active = 1;

			if( $t > $prevNumTaps){
				$tap->batchId = null;
			}

			$tap->save();
		}


		return Redirect::action('TapController@index');
	}*/

	private function loadFormViewData(&$data){

		$batchList = array( '' => Lang::get('common.NoBeerOnTap') );
		$batches = Batch::GetAllActive();
		foreach($batches as $batch){
			$batchList = array_add($batchList, $batch->id, $batch->Beer->name);
		}
		$data['batchList'] = $batchList;
	}

}
