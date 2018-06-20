<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/keg.php';

class KegManager extends Manager{
	
	protected function getPrimaryKeys(){
		return ["id"];
	}
	protected function getColumns(){
		return ["label", "kegTypeId", "make", "model", "serial", "stampedOwner", "stampedLoc", "notes", "kegStatusCode", "weight", "beerId", "onTapId", "tapNumber", "active"];
	}
	protected function getTableName(){
		return "kegs";
	}
	protected function getViewName(){
		return "vwKegs";
	}
	protected function getDBObject(){
		return new Keg();
	}	
	protected function getActiveColumnName(){
		return "active";
	}	
	function Tap($tapId, $kegId, $beerId = null){
		$sql="UPDATE kegs k SET k.onTapId = NULL, k.kegStatusCode = 'NEEDS_CLEANING', modifiedDate = NOW() WHERE onTapId = $tapId";
		$ret = $this->executeQueryNoResult($sql);
		$sql="UPDATE kegs k SET k.onTapId = $tapId, k.kegStatusCode = 'SERVING'".($beerId?", k.beerId=$beerId":"").", modifiedDate = NOW() WHERE id = $kegId";
		$ret = $ret && $this->executeQueryNoResult($sql);
		return $ret;
	}	
	function Kick($id){
		$sql = "UPDATE kegs k SET k.kegStatusCode = 'NEEDS_CLEANING', k.onTapId = NULL WHERE id = $id";
		return $this->executeQueryNoResult($sql);
	}
	function Inactivate($id){
		$tapManager = new TapManager();
		$taps = $tapManager->GetByKegId($id);	
		foreach($taps as $tap){	
			$_SESSION['errorMessage'] = "Keg was associated with an active tap ".$tap->getTapNumber().". Tap Set empty.";
			$tap->set_kegId("NULL");
			$tap->set_startAmount(0);
			$tap->set_currentAmount(0);
			$tapManager->Save($tap);			
		}
	
		$sql="UPDATE kegs SET active = 0, onTapId = NULL WHERE id = $id";
		return $this->executeQueryNoResult($sql);
	}
}