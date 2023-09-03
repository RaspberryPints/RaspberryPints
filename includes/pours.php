<?php

//Includes the Database and config information
require_once __DIR__.'/../admin/includes/managers/config_manager.php';
require_once __DIR__.'/../admin/includes/managers/tap_manager.php';
require_once __DIR__.'/../admin/includes/managers/pour_manager.php';
require_once __DIR__.'/config.php';
$tapManager = new TapManager();
$pourManager = new PourManager();

if( isset($_GET['tapId'])){
	echo 'Sample:';
	$pourManager->pourSample($_GET["tapId"]);
	unset($_GET['tapId']);
	redirect('../../index.php');
} else if( isset($_GET['bottleId'])){
  echo 'Drank';
  $bottleId = $_GET["bottleId"];
  $sql = "UPDATE bottles SET currentAmount = currentAmount-1  where id=" . $bottleId . ";";
  /** @var mixed $mysqli **/
  $mysqli->query($sql);
  unset($_GET['bottleId']);
  redirect('../../index.php');
} else{
	echo 'Pour';

//This will be used to choose between CSV or MYSQL DB
	$db = true;

	if($db){
		// Connect to the database
		$mysqli = db();		
		
		$config = getAllConfigs();	
		
		//This is an option to prevent pours from recording, like if you are cleaning the taps
		if(isset($config[ConfigNames::IgnorePours]) && $config[ConfigNames::IgnorePours]) return;
		
		// Creates arguments from info passed by python script from Flow Meters
		/** @var mixed $argv **/
		$ii = 1;
		$type = $argv[$ii++];
		if($type == 'Pour'){
			$RFID = $argv[$ii++];
			$PIN = $argv[$ii++];
			$PULSE_COUNT = $argv[$ii++];
			//$userId = '';
			$pourManager->pour($RFID, $PIN, $PULSE_COUNT);
			
		}else if($type == 'Kick'){
			$PIN = $argv[$ii++];
			$tap = $tapManager->GetByFlowPin($PIN);
			if($config[ConfigNames::AutoKickKegs]){
				if (!$tap) {
					echo "pours.php:Kick: No Active Tap Config for pin " .$PIN. "\n";
					exit();
				}
				if($tapManager->closeTapById($tap->get_id())){
					echo "Successfully Kicked Keg from ".$tap->get_tapNumber(). "\n";
				}else{
					echo "Could not Kick Keg from ".$tap->get_tapNumber(). "\n";
				}
			}else{
				echo "Ignoring Kick Keg from ".$tap->get_tapNumber(). "\n";			
			}
		}
	}
}
	// Refreshes connected pages
	if(isset($config[ConfigNames::AutoRefreshLocal]) && $config[ConfigNames::AutoRefreshLocal]){				
		exec(__DIR__."/refresh.sh");
	}
	

?>
