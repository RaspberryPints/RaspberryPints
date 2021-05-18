<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/keg.php';

class KegManager extends Manager{
	
	protected function getPrimaryKeys(){
		return ["id"];
	}
	protected function getColumns(){
		return array_push($this->getUpdateColumns(), "tapNumber");
	}
	protected function getInsertColumns(){
	    return ["label", "kegTypeId", "make", "model", "serial", "stampedOwner", "stampedLoc", "notes", "kegStatusCode", "weight", "weightUnit", "beerId", "beerBatchId", "onTapId", "active", "emptyWeight", "emptyWeightUnit", "maxVolume", "maxVolumeUnit", "startAmount", "startAmountUnit", "currentAmount", "currentAmountUnit", "fermentationPSI", "fermentationPSIUnit", "keggingTemp", "keggingTempUnit", "hasContinuousLid"];
	}	    
	protected function getUpdateColumns(){return $this->getInsertColumns();}
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
	
	function Tap($tapId, $kegId, $beerId = null, $beerBatchId=null){
		$sql="UPDATE kegs k SET k.onTapId = NULL, k.kegStatusCode = 'NEEDS_CLEANING', modifiedDate = NOW() WHERE onTapId = $tapId";
		$ret = $this->executeQueryNoResult($sql);
		$sql="UPDATE kegs k SET k.onTapId = $tapId, k.kegStatusCode = 'SERVING'".($beerId?", k.beerId=$beerId":"").", k.beerBatchId=".($beerBatchId?"$beerBatchId":"0").", modifiedDate = NOW() WHERE id = $kegId";
		$ret = $ret && $this->executeQueryNoResult($sql);
		return $ret;
	}	
	function Kick($id){
		$sql = "UPDATE kegs k SET k.kegStatusCode = 'NEEDS_CLEANING', k.onTapId = NULL WHERE id = $id";
		return $this->executeQueryNoResult($sql);
	}
	function Inactivate($id){
		$tapManager = new TapManager();
		$tap = $tapManager->GetByKegId($id);	
		if($tap){
		    $_SESSION['errorMessage'] = "Keg was associated with an active tap ".$tap->get_tapNumber().". Tap Set empty.";
			$tap->set_kegId(null);
			$tapManager->Save($tap);			
		}
	
		$sql="UPDATE kegs SET active = 0, onTapId = NULL WHERE id = $id";
		return $this->executeQueryNoResult($sql);
	}
	
	function GetByBeerId($id){
	    $id = (int) preg_replace('/\D/', '', $id);
	    $sql="SELECT k.* FROM ".$this->getTableName()." k WHERE k.beerId = $id AND k.active = 1";
	    return $this->executeQueryWithSingleResult($sql);
	}
	
	function GetByBeerBatchIdOnTap($id){
	    $id = (int) preg_replace('/\D/', '', $id);
	    $sql="SELECT k.* FROM ".$this->getTableName()." k WHERE k.beerBatchId = $id AND k.active = 1 AND k.onTapId > -1 AND k.onTapId IS NOT NULL";
	    return $this->executeQueryWithResults($sql);
	}
}