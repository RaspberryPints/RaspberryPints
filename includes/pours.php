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
		
		// Creates arguments from info passed by python script from Flow Meters
		$PIN = $argv[1];
		$PULSE_COUNT = $argv[2];
		
		//Unused SQL call at the moment
		//$sql = "select tapIndex,batchId,PulsesPerLiter from taps where pinAddress = $PIN";

		// SQL call to get corresponding tapID to pinId.
		$sql = "select id from taps where pinId = '".$PIN."' and active = '1'";
		$qry = mysql_query($sql);
		$taps = mysql_fetch_array($qry);
		//$amount = $PULSE_COUNT / 165;
		
		// Sets the amount to be a fraction of a gallon based on 165 ounces per pulse
		$amount = $PULSE_COUNT / 10560;

		//Unused Query at the moment, based on future table
		//$qry = "INSERT INTO pours(tapId,amountPoured,batchId,pinAddress,pulseCount,pulsesPerLiter,liters) values ('".$taps[0]."','".$amount."','".$taps[1]."','".$PIN."','".$PULSE_COUNT."','".$taps[2]."','".$PULSE_COUNT / $taps[2]."')";

		// Inserts in to the pours table 
		$qry = "INSERT INTO pours(tapId, pinId, amountPoured) values ('".$taps[0]."','".$PIN."','".$amount."')";
		mysql_query($qry);
	
		// The rest is unused except for the refresh.sh script which causes the browser to refresh automatically after a pour
		//echo $PIN;
		//echo $PULSE_COUNT;
	        //echo $taps[0];
		//echo $amount;
		/*
		$sql =  "SELECT * FROM vwGetTaps where tapIndex = ".$taps[0]."";
		$qry = mysql_query($sql);
		$aTaps = mysql_fetch_array($qry);
		$beerID = $aTaps[5];
		if ($beerID != '0') {
		$client_id = "F991DC82D5A3CD53E49DBE4B8AB36DD4052A881D";

		$client_secret = "0B632BB937A7D1D809CE06005318112BE4257916";
		$redirect_uri = "";
		$sql = "SELECT * from users where id ='2'";
		$qry = mysql_query($sql);
		$users = mysql_fetch_array($qry);
		$access_token = $users[5];
		//echo $access_token;
		if (!$access_token) {
		
		} else {
		// create your UT instance
		
		$ut = new UntappdPHP($client_id, $client_secret, $redirect_uri);		
		$ut->setToken($access_token);
		$checkins = array(
		'gmt_offset' => '-5',
		'timezone' => 'EST',
		'bid' => $beerID,
		'twitter' => 'on',
		'shout' => 'Poured with love'
		 );
		//Update Checkin
		$checkin = $ut->post("/checkin/add", $checkins);
		$checkinr = $checkin->response->result;
		print_r ($checkinr);
		 }
} 
*/
}

		// REFRESHES CHROMIUM BROWSER ON LOCAL HOST ONLY
		// COMMENT OUT TO DISABLE
		exec(__DIR__."/refresh.sh");

?>
