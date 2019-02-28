<?php
require_once __DIR__.'/config_manager.php';
require_once __DIR__.'/tap_manager.php';
require_once __DIR__.'/keg_manager.php';
require_once __DIR__.'/beer_manager.php';
require_once __DIR__.'/user_manager.php';
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/pour.php';
require_once __DIR__.'/../../../includes/Pintlabs/Service/Untappd.php';

class PourManager extends Manager{
	
	protected function getPrimaryKeys(){
		return ["id"];
	}
	protected function getColumns(){
		return ["tapId", "amountPoured", "pinId", "pulses", "beerId", "conversion", "userId"];
	}
	protected function getTableName(){
		return "pours";
	}
	protected function getViewName(){
		return "vwPours";
	}
	protected function getDBObject(){
		return new Pour();
	}
		
	function getLastPours($count){
		return $this->getLastPoursFiltered($count, null, null, null, null, null);
	}

	function getLastPoursFiltered($count, $startTime, $endTime, $tapId, $beerId, $userId){
		$sql="SELECT * FROM ".$this->getViewName()." ";
		$where = "";
		if($startTime && $startTime != "") $where = $where.($where != ""?"AND ":"")."createdDate >= '$startTime' ";
		if($endTime && $endTime != "") $where = $where.($where != ""?"AND ":"")."endTime < '$endTime' ";
		if($tapId)  $where = $where.($where != ""?"AND ":"")."tapId = $tapId ";
		if($beerId) $where = $where.($where != ""?"AND ":"")."beerId = $beerId ";
		if($userId) $where = $where.($where != ""?"AND ":"")."userId = $userId ";
		if($where != "") $sql = $sql."WHERE $where ";
		$sql = $sql."ORDER BY createdDate DESC ";
		if($count && $count > 0) $sql = $sql."LIMIT $count ";
		return $this->executeQueryWithResults($sql);
	}
	
	function getDisplayAmount($gal){ 
		$displayUnit = getConfigValue(ConfigNames::DisplayUnits);
		$ret = 0;
		switch($displayUnit)
		{
			default:
			$ret = $gal*128;
		}
		return number_format($ret, 1);
	}
	
	function pour($USERID, $PIN, $PULSE_COUNT){
		$config = getAllConfigs();	
		$tapManager = new TapManager();
		$kegManager = new KegManager();
		$userManager = new UserManager();
		$user = null;
		if ($USERID > 0) {
			$user = $userManager->GetByID($USERID);
		}
		
		$tap = $tapManager->GetByFlowPin($PIN);
		if (!$tap) {
			echo "pours.php: No Active Tap Config for pin " .$PIN. "\n";
			exit();
		}
		$tapId = $tap->get_id();
		$keg = $kegManager->GetByID($tap->get_kegId());
		$beerId = 0;
		if($keg) $beerId = $keg->get_beerId();
		$pourCountConversion = $tap->get_count();
		
		// Sets the amount to be a fraction of a gallon
		$amount = 0;
		if( $pourCountConversion > 0 ) {
		    $amount = $PULSE_COUNT / $pourCountConversion;
		}else{
		    echo "pours.php: No Count Per Gallon Configured for pin " .$PIN. " Please update from Admin->Taps\n";
		}
		
		echo "pour on pin: " . $PIN . ", count: " . $PULSE_COUNT . 
			", conversion: " . $pourCountConversion . ", amount: " . $amount . 
			", user: " . ($user?$user->get_id():'N/A') . "\n" ;
		// Inserts in to the pours table 
		$pour = new Pour();
		$pour->set_tapId($tapId);
		$pour->set_pinId($PIN);
		$pour->set_amountPoured($amount);
		$pour->set_pulses($PULSE_COUNT);
		$pour->set_conversion($pourCountConversion);
		$pour->set_userId(($user?$user->get_id():-1));
		$pour->set_beerId($beerId);
		$this->save($pour);
		
		if($keg){
    		$keg->set_currentAmount($keg->get_currentAmount() - $amount);
    		$kegManager->save($keg);
		}
	
		if ($beerId && $beerId != '' && $beerId != '0' && $user) {
			$access_token = ($user?$user->get_unTapAccessToken():null);
			$beer = null;
			if ($access_token) {
			    $beerManager = new BeerManager();
			    $beer = $beerManager->GetByID($beerId);
			}
			//echo $access_token;
			if ($access_token && $beer && $beer->get_untID()) {
				// create your UT instance		
			    $ut = new Pintlabs_Service_Untappd(getAllConfigs());
			    //          $access_token, $gmtOffset, $timezone, $beerId, 			    
			    $ut->checkin($access_token, date('Z')/60/60, date('T'), $beer->get_untID(), 
			        //$foursquareId, $userLat, $userLong, 
			        '', '', '', 
			        //$shout, 
			        'Poured with love by @raspberrypints', 
			        //$facebook, $twitter, $foursquare , $rating
			        false, false, false, '');
			}
		}
	}	
	
	function pourSample($tapId){
		$config = getAllConfigs();	
		$tapManager = new TapManager();
		$kegManager = new KegManager();
		
		$tap = $tapManager->GetByID($tapId);
		if (!$tap) {
			echo "pours.php: No Active Tap Config for id " .$tapId. "\n";
			exit();
		}
		$keg = $kegManager->GetByID($tap->get_kegId());
		$beerId = 0;
		if($keg) $beerId = $keg->get_beerId();
		$pourCountConversion = $tap->get_count();
		
		// Sets the amount to be a fraction of a gallon
		$amount = 1/128;
		
		echo "pour on tap: " . $tap->get_tapNumber() . ", count: " . 'Sample' . ", conversion: " . $pourCountConversion . ", amount: " . $amount . "\n" ;
		// Inserts in to the pours table 
		$pour = new Pour();
		$pour->set_tapId($tapId);
		$pour->set_pinId($tap->get_flowPinId());
		$pour->set_amountPoured($amount);
		$pour->set_pulses(-1);
		$pour->set_conversion($pourCountConversion);
		$pour->set_beerId($beerId);
		$pour->set_userId((new UserManager)->getUnknownUserId());
		$this->save($pour);
	
		if($keg){
    		$keg->set_currentAmount($keg->get_currentAmount() - $amount);
    		$kegManager->save($keg);
		}
	}
}