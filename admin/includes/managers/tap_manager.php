<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/tap.php';
require_once __DIR__.'/tapEvent_manager.php';
require_once __DIR__.'/user_manager.php';
require_once __DIR__.'/../models/tapEvent.php';

class TapManager extends Manager{
	
	protected function getPrimaryKeys(){
		return ["id"];
	}
	protected function getColumns(){
		return ["tapNumber", "kegId", "tapRgba", "active"];
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
		$sql="SELECT * FROM ".$this->getTableName()." t LEFT JOIN tapconfig tc ON (t.id = tc.tapId) WHERE tc.flowPin = $id";
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
			$sql = 	"INSERT INTO taps( tapNumber, active, createdDate, modifiedDate ) " .
					"VALUES( ".$currCount.", 1, NOW(), NOW())";
			$ret = $ret && $this->executeQueryNoResult($sql);
		}
		
		$sql="UPDATE taps SET active = CASE WHEN id <= $newTapNumber THEN 1 ELSE 0 END, kegId=CASE WHEN id <= $newTapNumber THEN kegId ELSE NULL END, modifiedDate = NOW() WHERE id > 0";
		$ret = $ret && $this->executeQueryNoResult($sql);
		
		if($ret){
			saveConfigValue(ConfigNames::NumberOfTaps, $newTapNumber);
			$_SESSION['successMessage'] = "Number of Taps Updated to $newTapNumber";	
			
			//Clear the kegs from the tap they are in
			$sql="UPDATE kegs SET onTapId = null, kegStatusCode='NEEDS_CLEANING' WHERE onTapId IS NOT NULL AND onTapId NOT IN (SELECT id FROM taps WHERE active = 1)";
			$ret = $ret && $this->executeQueryNoResult($sql);
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

	function tapKeg(&$tap, $kegId, $beerId, $beerBatchId){
	    $ret = true;
	    if($tap->get_kegId())$this->closeTap($tap, false);
		if($tap->get_kegId() != $kegId){
    		$tap->set_kegId($kegId);
    		$sql="UPDATE taps SET kegId = $kegId, modifiedDate = NOW() WHERE id = ".$tap->get_id();
    		$ret = $this->executeQueryNoResult($sql);
    		if(!$ret)return false;
		}
		$kegManager = new KegManager();
		$ret = $kegManager->Tap($tap->get_id(), $kegId, $beerId, $beerBatchId);
		
		$tapEvent = new TapEvent();
		$tapEvent->set_type(TAP_EVENT_TYPE_TAP);
		$tapEvent->set_tapId($tap->get_id());
		$tapEvent->set_kegId($kegId);
		$tapEvent->set_beerId($beerId);
		$tapEvent->set_beerBatchId($beerBatchId);
		$tapEvent->set_userId($_SESSION['myuserid']);
		$keg = $kegManager->GetByID($kegId);
		if($keg) {
		    $tapEvent->set_amount($keg->get_currentAmount());
		    $tapEvent->set_amountUnit($keg->get_currentAmountUnit());
		    if( $keg->get_beerBatchId() > 0 )
		    {
		        $beerBatchManager = new BeerBatchManager();
		        $beerBatch = $beerBatchManager->GetByID($keg->get_beerBatchId());
		        if( $beerBatch) $tapEvent->set_beerBatchAmount($beerBatch->get_currentAmount());
		        if( $beerBatch) $tapEvent->set_beerBatchAmountUnit($beerBatch->get_currentAmountUnit());
		    }
		}
		//If ret is false keep it false even if the save is successful
		$ret = $ret && (new TapEventManager)->Save($tapEvent); 
		
		return $ret;
	}
	
	function closeTapById($id){
		$tap = $this->GetById($id);
		if($tap) return $this->closeTap($tap);
		return false;
	}
	function closeTap(&$tap, $saveTap = true){
	    $kegId = $tap->get_kegId();
	    $beerId = $tap->get_beerId();
	    
		$kegManager = new KegManager();
		$ret = $kegManager->Kick($tap->get_kegId());
		if(!$ret) return $ret;
		
		$tap->set_kegId(null);
		if($saveTap)$ret = $ret && $this->Save($tap);
		
		if($beerId) {
    		$tapEvent = new TapEvent();
    		$tapEvent->set_type(TAP_EVENT_TYPE_UNTAP);
    		$tapEvent->set_tapId($tap->get_id());
    		$tapEvent->set_kegId($kegId);
    		$tapEvent->set_beerId($beerId);
    		$tapEvent->set_userId(isset($_SESSION['myuserid'])?$_SESSION['myuserid']:USER_ID_SYSTEM);
    		$keg = $kegManager->GetByID($kegId);
    		if($keg) $tapEvent->set_amount($keg->get_currentAmount());
    		$tapEvent->set_amountUnit($keg->get_currentAmountUnit());
    		//If ret is false keep it false even if the save is successful
    		$ret = $ret && (new TapEventManager)->Save($tapEvent); 
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
	
	function saveTapConfig($id, $flowPin, $valvePin, $valveOn, $countpergallon, $countpergallonunit, $plaatoAuthToken) {
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
			if($tap->get_countUnit() != $countpergallonunit) 	$updateSql .= ($updateSql!=""?",":"")."countUnit = NULLIF('" . $countpergallonunit . "', '')";
			if($tap->get_plaatoAuthToken() != $plaatoAuthToken) $updateSql .= ($updateSql!=""?",":"")."plaatoAuthToken = NULLIF('" . $plaatoAuthToken . "', '')";
			if($updateSql != "")$sql = "UPDATE tapconfig SET ".$updateSql." WHERE tapId = " . $id;
		} else {
			$sql = "INSERT INTO tapconfig (tapId, flowPin, valvePin, valveOn, count, countUnit, plaatoAuthToken) VALUES(" . 
			 			$id.", ".$flowPin.", ".$valvePin. ", ".$valveOn.", ".$countpergallon.", '".$countpergallonunit."','".$plaatoAuthToken."')";
		}
		if(isset($sql) && $sql != "")$ret = $ret && $this->executeQueryNoResult($sql);
		return $ret;
	}
	
	function saveTapLoadCellInfo($id, $loadCellCmdPin, $loadCellRspPin, $loadCellScaleRatio, $loadCellTareOffset, $loadCellUnit, $loadCellUpdateVariance) {
	    $ret = true;
	    $sql="SELECT * FROM tapconfig where tapId = $id";
	    $tap = $this->executeQueryWithSingleResult($sql);
	    unset($sql);
	    $updateSql = "";
	    if( $tap ){
	        if($tap->get_loadCellCmdPin() != $loadCellCmdPin) $updateSql .= ($updateSql!=""?",":"")."loadCellCmdPin = NULLIF('" . $loadCellCmdPin . "', '')";
	        if($tap->get_loadCellRspPin() != $loadCellRspPin) $updateSql .= ($updateSql!=""?",":"")."loadCellRspPin = NULLIF('" . $loadCellRspPin . "', '')";
	        if($tap->get_loadCellScaleRatio() != $loadCellScaleRatio) $updateSql .= ($updateSql!=""?",":"")."loadCellScaleRatio = NULLIF('" . $loadCellScaleRatio . "', '')";
	        if($tap->get_loadCellTareOffset() != $loadCellTareOffset) $updateSql .= ($updateSql!=""?",":"")."loadCellTareOffset = NULLIF('" . $loadCellTareOffset . "', '')";
	        if($tap->get_loadCellUnit() != $loadCellUnit) $updateSql .= ($updateSql!=""?",":"")."loadCellUnit = NULLIF('" . $loadCellUnit . "', '')";
	        if($tap->get_loadCellUpdateVariance() != $loadCellUpdateVariance) $updateSql .= ($updateSql!=""?",":"")."loadCellUpdateVariance = NULLIF('" . $loadCellUpdateVariance . "', '')";
	        if($updateSql != "")$sql = "UPDATE tapconfig SET ".$updateSql." WHERE tapId = " . $id;
	    } else {
	        $sql = "INSERT INTO tapconfig (tapId, loadCellCmdPin, loadCellRspPin, loadCellScaleRatio, loadCellTareOffset, loadCellUnit, loadCellUpdateVariance) VALUES(" .
	   	        $id.", ".$loadCellCmdPin.", ".$loadCellRspPin.", ".$loadCellScaleRatio.", ".$loadCellTareOffset.", '".$loadCellUnit."', '". $loadCellUpdateVariance. "' )";
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