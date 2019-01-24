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
		$sql="SELECT t.* FROM ".$this->getTableName()." t LEFT JOIN kegs k ON (t.kegId = k.id) WHERE k.beerId = $id AND t.active = 1";
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
		if($tap) return $this->closeTap($tap);
		return false;
	}
	function closeTap(&$tap, $saveTap = true){
		$kegManager = new KegManager();
		$ret = $kegManager->Kick($tap->get_kegId());
		if(!$ret) return $ret;
		
		$tap->set_kegId(null);

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
	
	function saveTapConfig($id, $flowPin, $valvePin, $valveOn, $countpergallon, $fermentationPSI, $keggingTemp) {
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
			if($tap->get_fermentationPSI() != $fermentationPSI) 	$updateSql .= ($updateSql!=""?",":"")."fermentationPSI = NULLIF('" . $fermentationPSI . "', '')";
			if($tap->get_keggingTemp() != $keggingTemp) $updateSql .= ($updateSql!=""?",":"")."keggingTemp = NULLIF('" . $keggingTemp . "', '')";
			if($updateSql != "")$sql = "UPDATE tapconfig SET ".$updateSql." WHERE tapId = " . $id;
		} else {
			$sql = "INSERT INTO tapconfig (tapId, flowPin, valvePin, valveOn, count, fermentationPSI, keggingTemp) VALUES(" . 
			                             $id.", ".$flowPin.", ".$valvePin. ", ".$valveOn.", ".$countpergallon.", ".$fermentationPSI.", ".$keggingTemp.")";
		}
		if(isset($sql) && $sql != "")$ret = $ret && $this->executeQueryNoResult($sql);
		return $ret;
	}
	
	function saveTapLoadCellInfo($id, $loadCellCmdPin, $loadCellRspPin) {
	    $ret = true;
	    $sql="SELECT * FROM tapconfig where tapId = $id";
	    $tap = $this->executeQueryWithSingleResult($sql);
	    unset($sql);
	    $updateSql = "";
	    if( $tap ){
	        if($tap->get_loadCellCmdPin() != $loadCellCmdPin) $updateSql .= ($updateSql!=""?",":"")."loadCellCmdPin = NULLIF('" . $loadCellCmdPin . "', '')";
	        if($tap->get_loadCellRspPin() != $loadCellRspPin) $updateSql .= ($updateSql!=""?",":"")."loadCellRspPin = NULLIF('" . $loadCellRspPin . "', '')";
	        if($updateSql != "")$sql = "UPDATE tapconfig SET ".$updateSql." WHERE tapId = " . $id;
	    } else {
	        $sql = "INSERT INTO tapconfig (tapId, loadCellCmdPin, loadCellRspPin) VALUES(" .
	   	        $id.", ".$loadCellCmdPin.", ".$loadCellRspPin.")";
	    }
	    if(isset($sql) && $sql != "")$ret = $ret && $this->executeQueryNoResult($sql);
	    return $ret;
	}
	function set_tapTareRequested($id, $tare) {
	    $ret = true;
	    $sql="SELECT * FROM tapconfig where tapId = $id";
	    $tap = $this->executeQueryWithSingleResult($sql);
	    unset($sql);
	    $updateSql = "";
	    if($tare){
	        $tare = 1;
	    }else{
	        $tare = 0;
	    }
	    if( $tap ){
	        $updateSql .= ($updateSql!=""?",":"")."loadCellTareReq = NULLIF('" . $tare . "', '0')";
	        if($updateSql != "")$sql = "UPDATE tapconfig SET ".$updateSql." WHERE tapId = " . $id;
	    }
	    if(isset($sql) && $sql != "")$ret = $ret && $this->executeQueryNoResult($sql);
	    return $ret;
	}
}