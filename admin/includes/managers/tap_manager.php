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
	protected function getTableName(){
		return "taps";
	}
	protected function getDBObject(){
		return new Tap();
	}	
	protected function getActiveColumnName(){
		return "active";
	}		
	function GetByID($id){
		$id = (int) preg_replace('/\D/', '', $id);	
		$sql="SELECT * FROM taps t left join tapconfig tc on (t.id = tc.tapId) WHERE t.id = $id";
		return $this->executeQueryWithSingleResult($sql);
	}

	function GetByNumber($number){
		$number = (int) preg_replace('/\D/', '', $number);	
		$sql="SELECT * FROM taps t left join tapconfig tc on (t.id = tc.tapId) WHERE t.id = $number";
		return $this->executeQueryWithSingleResult($sql);
	}

	function GetByKegId($id){
		$id = (int) preg_replace('/\D/', '', $id);	
		$sql="SELECT * FROM taps t left join tapconfig tc on (t.id = tc.tapId) WHERE t.kegId = $id AND t.active = 1";
		return $this->executeQueryWithSingleResult($sql);
	}
	
	function GetByFlowPin($pin){
		$id = (int) preg_replace('/\D/', '', $pin);	
		$sql="SELECT * FROM taps t left join tapconfig tc on (t.id = tc.tapId) WHERE tc.flowPin = $pin";
		return $this->executeQueryWithSingleResult($sql);
	}
	
	function GetByBeerId($id){
		$id = (int) preg_replace('/\D/', '', $id);	
		$sql="SELECT * FROM taps t left join tapconfig tc on (t.id = tc.tapId) WHERE t.beerId = $id AND t.active = 1";
		return $this->executeQueryWithSingleResult($sql);
	}
	
	function updateNumberOfTaps($newTapNumber){
		saveConfigValue(ConfigNames::NumberOfTaps, $newTapNumber);
				
		$currCount = $this->getTotalTaps();
		while($currCount < $newTapNumber)
		{
			$currCount++;
			$sql = 	"INSERT INTO taps( tapNumber, createdDate, modifiedDate ) " .
					"VALUES( ".$currCount.", NOW(), NOW())";
			$ret = $this->executeQueryNoResults($sql);
		}
		
		$sql="UPDATE taps SET active = CASE WHEN id <= $newTapNumber THEN 1 ELSE 0 END, modifiedDate = NOW() WHERE id > 0";
		$ret = $ret && $this->executeQueryNoResults($sql);
		return $ret;
	}
	function getNumberOfTaps(){
		return getConfigValue(ConfigNames::NumberOfTaps);
	}

	function GetAll(){
		$sql="SELECT * FROM taps t LEFT JOIN tapconfig tc ON t.id=tc.tapId WHERE t.active = 1 ORDER BY id";
		return $this->executeQueryWithResults($sql);
	}
	
	function tapKeg($tap, $kegId, $beerId){
		$tap->set_kegId($kegId);
		$sql="UPDATE taps SET kegId = $kegId, modifiedDate = NOW() WHERE id = ".$tap->get_id();
		$ret = $this->executeQueryNoResult($sql);
		if(!$ret)return false;
		
		$kegManager = new KegManager();
		if(!$kegManager->Tap($tap->get_id(), $kegId, $beerId)) return false;
		
		return true;
	}
	
	function closeTap($id){
		$sql="UPDATE taps SET kegId = NULL, modifiedDate = NOW() WHERE id = $id";
		$ret = $this->executeQueryNoResults($sql);
		
		$sql="UPDATE kegs k, taps t SET k.kegStatusCode = 'NEEDS_CLEANING', k.onTapId = NULL WHERE t.kegId = k.id AND t.Id = $id";
		$ret = $ret && $this->executeQueryNoResults($sql);

		$tap = $this->GetById($id);
		if($tap) {
			$sql="UPDATE tapconfig SET valveOn = 0 WHERE tapId = ".$tap->get_id();
			$ret = $ret && $this->executeQueryNoResult($sql);
		}
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
	
	function saveTapConfig($id, $tapNumber, $flowPin, $valvePin, $valveOn, $countpergallon) {
		$ret = true;
		if(isset($tapNumber) && $tapNumber != "")
		{
			$sql = "UPDATE taps SET tapNumber = $tapNumber WHERE id = ".$id;
			$ret = $this->executeQueryNoResult($sql);
		}
		$sql="SELECT * FROM tapconfig where tapId = $id";
		$taps = $this->executeQueryWithResults($sql);
		unset($sql);
		$updateSql = "";
		if( $taps && count($taps) > 0 ){
			if($flowPin <> "") 			$updateSql .= ($updateSql!=""?",":"")."flowPin = " . $flowPin ;
			if($valvePin <> "") 		$updateSql .= ($updateSql!=""?",":"")."valvePin = " . $valvePin ; 
			if($valveOn <> "") 			$updateSql .= ($updateSql!=""?",":"")."valveOn = " . $valveOn ; 
			if($countpergallon <> "") 	$updateSql .= ($updateSql!=""?",":"")."count = " . $countpergallon ;
			if($updateSql != "")$sql = "UPDATE tapconfig SET ".$updateSql." WHERE tapId = " . $id;
		} else {
			$sql = "INSERT INTO tapconfig (tapId, flowPin, valvePin, valveOn, count) VALUES(" . 
				$id.", ".$flowPin.", ".$valvePin. ", ".$valveOn.", ".$countpergallon.")";
		}
		if(isset($sql) && $sql != "")$ret = $ret && $this->executeQueryNoResult($sql);
		return $ret;
	}
}