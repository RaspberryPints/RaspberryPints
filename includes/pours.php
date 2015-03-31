<?php
//Includes the Database and config information
require_once dirname(__FILE__) . '/config_names.php';
require_once dirname(__FILE__) . '/config.php';

//Unused at the moment will call untappdPHP library to post to Untappd
//include __DIR__."/app/library/UntappdPHP/lib/untappdPHP.php";

//Pulls config information (not currently used)
$config = array();
$config_values = $db->get('config');
if ($db->count > 0) {
	foreach ($config_values as $c) {
		$config[$c['configName']] = $c['configValue'];
	}
}
		
// Creates arguments from info passed by python script from Flow Meters
$PIN = $argv[1];
$PULSE_COUNT = $argv[2];
		
//Unused SQL call at the moment
//$sql = "select tapIndex,batchId,PulsesPerLiter from taps where pinAddress = $PIN";

// SQL call to get corresponding tapID to pinId.
// Code for new kegs that are not full
$tapId = $db->where('pinId', $PIN)->where('active', 1)->getValue('taps', 'id');
//$amount = $PULSE_COUNT / 165;
		
// Sets the amount to be a fraction of a gallon based on 165 ounces per pulse
$amount = $PULSE_COUNT / 21120;

if (!$tapId) {
        echo "No Active Taps";
} else {
	//Unused Query at the moment, based on future table
	//$qry = "INSERT INTO pours(tapId,amountPoured,batchId,pinAddress,pulseCount,pulsesPerLiter,liters) values ('".$taps[0]."','".$amount."','".$taps[1]."','".$PIN."','".$PULSE_COUNT."','".$taps[2]."','".$PULSE_COUNT / $taps[2]."')";

	// Inserts in to the pours table
	$data = array(
		"tapId" => $tapId,
		"pinId" => $PIN,
		"amountPoured" => $amount,
		"pulses" => $PULSE_COUNT
	);
	
	$db->insert('pours', $data);
}

// REFRESHES CHROMIUM BROWSER ON LOCAL HOST ONLY
// COMMENT OUT TO DISABLE
exec(__DIR__."/refresh.sh");

?>
