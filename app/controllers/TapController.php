<?php

class TapController extends BaseController {

	public function index()
	{
		$data['taps'] = Tap::GetAllActive();

		$data['numTaps'] = Option::GetByName(OptionNames::NumberOfTaps);

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

	private function loadFormViewData(&$data){

		$batchList = array( '' => Lang::get('common.NoBeerOnTap') );
		$batches = Batch::GetAllActive();
		foreach($batches as $batch){
			$batchList = array_add($batchList, $batch->id, $batch->Beer->name);
		}
		$data['batchList'] = $batchList;
	}

}