<?php
require_once __DIR__.'/../../../includes/config_names.php';
require_once __DIR__.'/../models/tap.php';

class TapManager{
	
	function Save(mysqli $con, $tap){
		$sql = "";
		
		$sql="UPDATE kegs k SET k.kegStatusCode = 'SERVING', modifiedDate = NOW() WHERE id = " . $tap->get_kegId();
		mysqli_query($con, $sql);
	
		$sql="UPDATE taps SET active = 0, modifiedDate = NOW() WHERE active = 1 AND tapNumber = " . $tap->get_tapNumber();
		mysqli_query($con, $sql);		
		
		if($tap->get_id()){
			$sql = 	"UPDATE taps " .
					"SET " .
						"beerId = " . $tap->get_beerId() . ", " .
						"kegId = " . $tap->get_kegId() . ", " .
						"tapNumber = " . $tap->get_tapNumber() . ", " .
						"pinId = " . $tap->get_pinId() . "," .
						"ogAct = " . $tap->get_og() . ", " .
						"fgAct = " . $tap->get_fg() . ", " .
						"srmAct = " . $tap->get_srm() . ", " .
						"ibuAct = " . $tap->get_ibu() . ", " .
						"startAmount = " . $tap->get_startAmount() . ", " .
						"active = " . $tap->get_active() . ", " .
						"modifiedDate = NOW() ".
					"WHERE id = " . $tap->get_id();
					
		}else{
			$sql = 	"INSERT INTO taps(beerId, kegId, tapNumber,pinId, ogAct, fgAct, srmAct, ibuAct, startAmount, currentAmount, active, createdDate, modifiedDate ) " .
					"VALUES(" . $tap->get_beerId() . ", " . $tap->get_kegId() . ", " . $tap->get_tapNumber() . "," . $tap->get_pinId() . ", " . $tap->get_og() . ", " . $tap->get_fg() . ", " . $tap->get_srm() . ", " . $tap->get_ibu() . ", " . $tap->get_startAmount() . ", " . $tap->get_startAmount() . ", " . $tap->get_active	() . ", NOW(), NOW())";
		}		
		
		//echo $sql; exit();
		
		mysqli_query($con, $sql);
	}
	
	function GetById(mysqli $con, $id){
		$id = (int) preg_replace('/\D/', '', $id);
	
		$sql="SELECT * FROM taps WHERE id = " . $id;
		$qry = mysqli_query($con, $sql);
		
		if( $i = mysqli_fetch_array($qry) ){
			$tap = new Tap();
			$tap->setFromArray($i);
			return $tap;
		}
		
		return null;
	}

	function updateTapNumber(mysqli $con, $newTapNumber){
		$sql="UPDATE config SET configValue = $newTapNumber, modifiedDate = NOW() WHERE configName = '".ConfigNames::NumberOfTaps."'";
		mysqli_query($con, $sql);

		$sql="UPDATE kegs SET kegStatusCode = 'SANITIZED', modifiedDate = NOW() WHERE id IN (SELECT kegId FROM Taps WHERE tapNumber > " .
			$newTapNumber . " AND active = 1) ";
		mysqli_query($con, $sql);
		
		$sql="UPDATE taps SET active = 0, modifiedDate = NOW() WHERE active = 1 AND tapNumber > " . $newTapNumber;
		mysqli_query($con, $sql);
	}

	function getTapNumber(mysqli $con){
		$sql="SELECT configValue FROM config WHERE configName = '" . ConfigNames::NumberOfTaps . "'";

		$qry = mysqli_query($con, $sql);
		$config = mysqli_fetch_array($qry);
		
		if( $config != false ){
			return $config['configValue'];
		}
	}

	function getActiveTaps(mysqli $con){
		$sql="SELECT * FROM taps WHERE active = 1";
		$qry = mysqli_query($con, $sql);
		
		$taps = array();
		while($i = mysqli_fetch_array($qry)){
			$tap = new Tap();
			$tap->setFromArray($i);
			$taps[$tap->get_tapNumber()] = $tap;
		}
		
		return $taps;
	}
	
	function closeTap(mysqli $con, $id){
		$sql="UPDATE taps SET active = 0, modifiedDate = NOW() WHERE id = " . $id;
		mysqli_query($con, $sql);
		
		$sql="UPDATE kegs k, taps t SET k.kegStatusCode = 'NEEDS_CLEANING' WHERE t.kegId = k.id AND t.Id = " . $id;
		mysqli_query($con, $sql);
	}
}
