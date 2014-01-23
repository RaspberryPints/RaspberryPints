<?php
require_once 'includes/models/tap.php';

class TapManager{

	function updateTapNumber($newTapNumber){
		$sql="UPDATE config SET configValue = $newTapNumber WHERE configName = '".ConfigNames::NumberOfTaps."'";
		mysql_query($sql);
		
		$sql="UPDATE taps SET active = 0, modifiedDate = NOW() WHERE active = 1 AND tapNumber > $newTapNumber";
		mysql_query($sql);
	}

	function getTapNumber(){
		$sql="SELECT configValue FROM config WHERE configName = '".ConfigNames::NumberOfTaps."'";

		$qry = mysql_query($sql);
		$config = mysql_fetch_array($qry);
		
		if( $config != false ){
			return $config['configValue'];
		}
	}

	function getActiveTaps(){
		$sql="SELECT * FROM taps WHERE active = 1";
		$qry = mysql_query($sql);
		
		$taps = array();
		while($t = mysql_fetch_array($qry)){
			$tap = new Tap();
			$tap->setFromArray($t);
			$taps[$tap->get_tapNumber()] = $tap;
		}
		
		return $taps;
	}
}