<?php
require_once __DIR__.'/config_manager.php';
require_once __DIR__.'/tap_manager.php';
require_once __DIR__.'/keg_manager.php';
require_once __DIR__.'/user_manager.php';
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/pour.php';

$masterSql = "SELECT p.*, t.tapNumber, t.tapRgba, b.name AS beerName, b.untID AS beerUntID, br.imageUrl AS breweryImageUrl, COALESCE(u.userName, '') FROM pours p LEFT JOIN taps t ON (p.tapId = t.id) LEFT JOIN kegs k ON (t.kegId = k.id) LEFT JOIN beers b ON (k.beerId = b.id) LEFT JOIN breweries br ON (b.breweryId = br.id) LEFT JOIN users u ON (p.userId = u.id)";

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
	protected function getDBObject(){
		return new Pour();
	}
		
	function GetById($id){
		global $masterSql;
		$id = (int) preg_replace('/\D/', '', $id);	
		$sql= $masterSql." WHERE p.id = $id";
		return $this->executeQueryWithResults($sql);
	}

	function getLastPours($count){
		global $masterSql;
		$sql= $masterSql." ORDER BY p.createdDate DESC LIMIT $count";
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
	
	function pour($RFID, $PIN, $PULSE_COUNT){
		$config = getAllConfigs();	
		$tapManager = new TapManager();
		$kegManager = new KegManager();
		$userManager = new UserManager();
		$user = null;
		if ($RFID > 0) {
			$user = $userManger->getByRFID($RFID);
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
		
		echo "pours.php:Pour: pour on pin: " . $PIN . ", count: " . $PULSE_COUNT . ", conversion: " . $pourCountConversion . ", amount: " . $amount . "\n" ;
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