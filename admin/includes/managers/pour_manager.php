<?php
require_once __DIR__.'/config_manager.php';
require_once __DIR__.'/tap_manager.php';
require_once __DIR__.'/keg_manager.php';
require_once __DIR__.'/user_manager.php';
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/pour.php';

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
		$amount = $PULSE_COUNT / $pourCountConversion;
		
		echo "pours.php:Pour: pour on pin: " . $PIN . ", count: " . $PULSE_COUNT . 
			", conversion: " . $pourCountConversion . ", amount: " . $amount . 
			", user: " . ($user?$user->get_id():'N/A') . "\n" ;
		// Inserts in to the pours table 
		$pour = new Pour();
		$pour->set_tapId($tapId);
		$pour->set_pinId($PIN);
		$pour->set_amountPoured($amount);
		$pour->set_pulses($PULSE_COUNT);
		$pour->set_conversion($pourCountConversion);
		$pour->set_userId(($user?$user->get_id():''));
		$pour->set_beerId($beerId);
		$this->save($pour);
	
		$tap->set_currentAmount($tap->get_currentAmount() - $amount);
		$tapManager->save($tap);
	
		if ($beerId && $beerId != '' && $beerId != '0') {
			$client_id = $config[ConfigNames::ClientID];
			$client_secret = $config[ConfigNames::ClientSecret];
			$redirect_uri = "";
			$access_token = ($user?$user->get_unTapAccessToken():null);
			//echo $access_token;
			if ($access_token) {
				// create your UT instance		
				$ut = new UntappdPHP($client_id, $client_secret, $redirect_uri);		
				$ut->setToken($access_token);
				$checkins = array(
				'gmt_offset' => '-5',
				'timezone' => 'EST',
				'bid' => $beerID,
				'twitter' => 'on',
				'shout' => 'Poured with love by @raspberrypints'
				 );
				//Update Checkin
				$checkin = $ut->post("/checkin/add", $checkins);
				$checkinr = $checkin->response->result;
				//print_r ($checkinr);
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
		$amount = .125;
		
		echo "pours.php:Pour: pour on pin: " . $PIN . ", count: " . $PULSE_COUNT . ", conversion: " . $pourCountConversion . ", amount: " . $amount . "\n" ;
		// Inserts in to the pours table 
		$pour = new Pour();
		$pour->set_tapId($tapId);
		$pour->set_pinId($tap->get_pinId());
		$pour->set_amountPoured($amount);
		$pour->set_pulses(0);
		$pour->set_conversion($pourCountConversion);
		$pour->set_beerId($beerId);
		$this->save($pour);
	
		$tap->set_currentAmount($tap->get_currentAmount() - $amount);
		$tapManager->save($tap);
	}
}