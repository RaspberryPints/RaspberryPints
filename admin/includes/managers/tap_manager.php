<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/tap.php';

class TapManager extends Manager{
	
	protected function getPrimaryKeys(){
		return ["id"];
	}
	protected function getColumns(){
		return ["tapNumber", "kegId", "tapRgba", "startAmount", "currentAmount", "active"];
	}
	//Tap needs more data then whats in the taps table so use a view for getting data but the columns for updating
	protected function getTableName(){
		return "taps";
	}
	protected function getViewName(){
		return "vwTaps";
	}
	protected function getDBObject(){
		return new Tap();
	}	
	protected function getActiveColumnName(){
		return "active";
	}		
	function GetByNumber($number){
		$number = (int) preg_replace('/\D/', '', $number);	
		$sql="SELECT * FROM ".$this->getTableName()." WHERE tapNumber = $number";
		return $this->executeQueryWithSingleResult($sql);
	}

	function GetByKegId($id){
		$id = (int) preg_replace('/\D/', '', $id);	
		$sql="SELECT * FROM ".$this->getTableName()." WHERE kegId = $id AND active = 1";
		return $this->executeQueryWithSingleResult($sql);
	}
	
	function GetByFlowPin($pin){
		$id = (int) preg_replace('/\D/', '', $pin);	
		$sql="SELECT * FROM ".$this->getTableName()." t LEFT JOIN tapconfig tc ON (t.id = tc.tapId) WHERE tc.flowPin = $pin";
		return $this->executeQueryWithSingleResult($sql);
	}
	
	function GetByBeerId($id){
		$id = (int) preg_replace('/\D/', '', $id);	
		$sql="SELECT * FROM ".$this->getTableName()." WHERE beerId = $id AND active = 1";
		return $this->executeQueryWithSingleResult($sql);
	}
	
	function updateNumberOfTaps($newTapNumber){
		$ret = true;		
		$currCount = $this->getTotalTaps();
		while($currCount < $newTapNumber)
		{
			$currCount++;
			$sql = 	"INSERT INTO taps( tapNumber, createdDate, modifiedDate ) " .
					"VALUES( ".$currCount.", NOW(), NOW())";
			$ret = $ret && $this->executeQueryNoResult($sql);
		}
		
		$sql="UPDATE taps SET active = CASE WHEN id <= $newTapNumber THEN 1 ELSE 0 END, modifiedDate = NOW() WHERE id > 0";
		$ret = $ret && $this->executeQueryNoResult($sql);
		
		if($ret){
			saveConfigValue(ConfigNames::NumberOfTaps, $newTapNumber);
			$_SESSION['successMessage'] = "Number of Taps Updated to $newTapNumber";			
		}
		
		return $ret;
	}
	function getTotalTaps(){
		$sql = "SELECT COUNT(id) as totalTaps FROM taps";
		$ret = $this->executeNonObjectQueryWithSingleResults($sql);	
		if($ret && isset($ret[0])) return $ret[0];
		return 0;
	}
	function getNumberOfTaps(){
		return getConfigValue(ConfigNames::NumberOfTaps);
	}

	function tapKeg(&$tap, $kegId, $beerId){
		if($tap->get_kegId() != $kegId){
		$tap->set_kegId($kegId);
		$sql="UPDATE taps SET kegId = $kegId, modifiedDate = NOW() WHERE id = ".$tap->get_id();
		$ret = $this->executeQueryNoResult($sql);
		if(!$ret)return false;
		}
		$kegManager = new KegManager();
		if(!$kegManager->Tap($tap->get_id(), $kegId, $beerId)) return false;
		return true;
	}
	
	function closeTapById($id){
		$tap = $this->GetById($id);
		if($tap) return closeTap($tap);
		return false;
	}
	function closeTap(&$tap, $saveTap = true){
		$tap->set_kegId(null);
		
		$kegManager = new KegManager();
		$ret = $ret && $kegManager->Kick($tap->get_kegId());

			$sql="UPDATE tapconfig SET valveOn = 0 WHERE tapId = ".$tap->get_id();
			$ret = $ret && $this->executeQueryNoResult($sql);
		
		if($saveTap)$ret = $ret && $this->Save($tap);
		
		return $ret;
	}

	function enableTap($id){
		$sql="UPDATE tapconfig SET valveOn = 1 WHERE tapId = $id";
		return $this->executeQueryNoResult($sql);
	}
	
	function disableTap($id){
		$sql="UPDATE tapconfig SET valveOn = 0 WHERE tapId = $id";
		return $this->executeQueryNoResult($sql);
	}
	
	function saveTapConfig($id, $flowPin, $valvePin, $valveOn, $countpergallon) {
		$ret = true;
		$sql="SELECT * FROM tapconfig where tapId = $id";
		$tap = $this->executeQueryWithSingleResult($sql);
		unset($sql);
		$updateSql = "";
		if( $tap ){
			if($tap->get_flowPinId() != $flowPin) 		$updateSql .= ($updateSql!=""?",":"")."flowPin = NULLIF('" . $flowPin . "', '')";
			if($tap->get_valvePinId() != $valvePin) 	$updateSql .= ($updateSql!=""?",":"")."valvePin = NULLIF('" . $valvePin . "', '')"; 
			if($tap->get_valveOn() != $valveOn) 		$updateSql .= ($updateSql!=""?",":"")."valveOn = NULLIF('" . $valveOn . "', '')"; 
			if($tap->get_count() != $countpergallon) 	$updateSql .= ($updateSql!=""?",":"")."count = NULLIF('" . $countpergallon . "', '')";
			if($updateSql != "")$sql = "UPDATE tapconfig SET ".$updateSql." WHERE tapId = " . $id;
		} else {
			$sql = "INSERT INTO tapconfig (tapId, flowPin, valvePin, valveOn, count) VALUES(" . 
				$id.", ".$flowPin.", ".$valvePin. ", ".$valveOn.", ".$countpergallon.")";
		}
		if(isset($sql) && $sql != "")$ret = $ret && $this->executeQueryNoResult($sql);
		return $ret;
	}
}