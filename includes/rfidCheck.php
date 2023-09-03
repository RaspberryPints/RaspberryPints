<?php

//Includes the Database and config information
require_once '../../admin/includes/managers/config_manager.php';
require_once '../../admin/includes/managers/user_manager.php';
require_once __DIR__.'/config.php';
$userManager = new UserManager();

$ii = 1;

// Connect to the database
/** @var mixed $mysqli **/
$mysqli = db();		

$config = getAllConfigs();	

// Creates arguments from info passed by python script from Flow Meters
/** @var mixed $argv **/
$rfid = $argv[$ii++];
$user = $userManager->getByRFID($rfid);

if ( $user )
{
	echo $user->get_id();
}
else 
{

	if($config[ConfigNames::SaveNonUserRfids]){
		$userManager->addRFID($userManager->getUnknownUserId(), $rfid, "No User Scan:".date('Y-m-d H:i:s'));
	}
	echo $userManager->getUnknownUserId();
}


?>
