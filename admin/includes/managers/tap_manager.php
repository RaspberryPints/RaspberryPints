<?php
require_once __DIR__.'/../../../includes/config_names.php';
require_once __DIR__.'/../models/tap.php';

class TapManager{
	
	function Save($tap){
		$sql = "";
		if($tap->get_id()){
			$sql = 	"UPDATE taps " .
					"SET " .
						"beerId = " . $tap->get_beerId() . ", " .
						"kegId = " . $tap->get_kegId() . ", " .
						"tapNumber = " . $tap->get_tapNumber() . ", " .
						"ogAct = " . $tap->get_og() . ", " .
						"fgAct = " . $tap->get_fg() . ", " .
						"srmAct = " . $tap->get_srm() . ", " .
						"ibuAct = " . $tap->get_ibu() . ", " .
						"startAmount = " . $tap->get_startAmount() . ", " .
						"active = " . $tap->get_active() . ", " .
						"modifiedDate = NOW() ".
					"WHERE id = " . $tap->get_id();
					
		}else{
			$sql="UPDATE kegs k, taps t SET k.kegStatusCode = 'SERVING' WHERE t.kegId = k.id AND t.Id = " . $tap->get_kegId();
			mysql_query($sql);
		
			$sql="UPDATE taps SET active = 0, modifiedDate = NOW() WHERE active = 1 AND tapNumber = " . $tap->get_tapNumber();
			mysql_query($sql);		
		
			$sql = 	"INSERT INTO taps(beerId, kegId, tapNumber, ogAct, fgAct, srmAct, ibuAct, startAmount, currentAmount, active, createdDate, modifiedDate ) " .
					"VALUES(" . $tap->get_beerId() . ", " . $tap->get_kegId() . ", " . $tap->get_tapNumber() . ", " . $tap->get_og() . ", " . $tap->get_fg() . ", " . $tap->get_srm() . ", " . $tap->get_ibu() . ", " . $tap->get_startAmount() . ", " . $tap->get_startAmount() . ", " . $tap->get_active	() . ", NOW(), NOW())";
		}
		
		//echo $sql; exit();
		
		mysql_query($sql);
	}
	
	function GetById($id){
		$id = (int) preg_replace('/\D/', '', $id);
	
		$sql="SELECT * FROM taps WHERE id = $id";
		$qry = mysql_query($sql);
		
		if( $i = mysql_fetch_array($qry) ){		
			$tap = new Tap();
			$tap->setFromArray($i);
			return $tap;
		}
		
		return null;
	}

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
		while($i = mysql_fetch_array($qry)){
			$tap = new Tap();
			$tap->setFromArray($i);
			$taps[$tap->get_tapNumber()] = $tap;
		}
		
		return $taps;
	}
	
	function closeTap($id){
		$sql="UPDATE taps SET active = 0, modifiedDate = NOW() WHERE id = $id";
		mysql_query($sql);
		
		$sql="UPDATE kegs k, taps t SET k.kegStatusCode = 'NEEDS_CLEANING' WHERE t.kegId = k.id AND t.Id = $id";
		mysql_query($sql);
	}
}