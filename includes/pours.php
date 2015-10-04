<?php

//Includes the Database and config information
require_once 'config_names.php';
require_once 'config.php';

//Unused at the moment will call untappdPHP library to post to Untappd
//include __DIR__."/app/library/UntappdPHP/lib/untappdPHP.php";

//This can be used to choose between CSV or MYSQL DB
	$db = true;

if($db){
		// Connect to the database
		db();
		
		$config = array();
		//Pulls config information (not currently used)
		$sql = "SELECT * FROM config";
		$qry = mysql_query($sql);
		while($c = mysql_fetch_array($qry)){
			$config[$c['configName']] = $c['configValue'];
		}
		
		$pourCountConversion = $config[ConfigNames::PourCountConversion];
		
		// Creates arguments from info passed by python script from Flow Meters
		$PIN = $argv[1];
		$PULSE_COUNT = $argv[2];
		
		echo "pours.php: pour on pin: " . $PIN . ", count: " . $PULSE_COUNT;
		
		// SQL call to get corresponding tapID to pinId.
		$sql = "select tapNumber from tapconfig where flowPin = '".$PIN."'";
		$qry = mysql_query($sql);
		$tapconfig = mysql_fetch_array($qry);
		if (!$tapconfig[0]) {
			echo "No Active Tap Config for pin " .$PIN. "\n";
			exit();
		}
				
		$sql = "select id from taps where tapNumber = '". $tapconfig[0] ."' and active = '1'";
		$qry = mysql_query($sql);
		$taps = mysql_fetch_array($qry);
		
		// Sets the amount to be a fraction of a gallon based on 165 ounces per pulse
		$amount = $PULSE_COUNT / $pourCountConversion;
		 if (!$taps[0]) {
                echo "No Active Taps\n";
                } else {

		// Inserts in to the pours table 
		$qry = "INSERT INTO pours(tapId, pinId, amountPoured, pulses, createdDate, modifiedDate) values ('".$taps[0]."','".$PIN."','".$amount."','".$PULSE_COUNT."', 'NOW()', 'NOW()' )";
		mysql_query($qry);
} 

}

		// REFRESHES CHROMIUM BROWSER ON LOCAL HOST ONLY
		// COMMENT OUT TO DISABLE
		//exec(__DIR__."/refresh.sh");

?>
