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
	 * @param  int  $tapId
	 * @param  int  $batchId
	 * @return Response
	 */
	public function updateBatch($tapId, $batchId = null)
	{
		$tap = Tap::find($tabId);
		$tap->batchId = $batchId;
		$tap->save();

		// redirect
		Session::flash('message', sprintf(Lang::get('common.itemSuccessfullyUpdated'), Lang::get('tap')));
		return Redirect::action('TapController@index');		
	}

	private function loadFormViewData(&$data){

		$batchList = array();
		$batches = Batch::GetAllActive();
		foreach($batches as $batch){
			$batchList = array_add($batchList, $batch->id, $batch->Beer->name);
		}
		$data['batchList'] = $batchList;
	}

}