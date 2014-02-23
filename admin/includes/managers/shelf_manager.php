<?php
require_once __DIR__.'/../../../includes/config_names.php';
require_once __DIR__.'/../models/tap.php';

class ShelfManager{
	
	function Save($tap){
		$sql = "";
		
		$sql="UPDATE bottles k SET k.kegStatusCode = 'SERVING', modifiedDate = NOW() WHERE id = " . $tap->get_bottleId();
		mysql_query($sql);
	
		$sql="UPDATE shelfs SET active = 0, modifiedDate = NOW() WHERE active = 1 AND shelfNumber = " . $tap->get_shelfNumber();
		mysql_query($sql);		
		
		if($tap->get_id()){
			$sql = 	"UPDATE shelves " .
					"SET " .
						"beerId = " . $tap->get_beerId() . ", " .
						"bottleId = " . $tap->get_bottleId() . ", " .
						"shelfNumber = " . $tap->get_shelfNumber() . ", " .
						"ogAct = " . $tap->get_og() . ", " .
						"fgAct = " . $tap->get_fg() . ", " .
						"srmAct = " . $tap->get_srm() . ", " .
						"ibuAct = " . $tap->get_ibu() . ", " .
						"startAmount = " . $tap->get_startAmount() . ", " .
						"active = " . $tap->get_active() . ", " .
						"modifiedDate = NOW() ".
					"WHERE id = " . $tap->get_id();
					
		}else{
			$sql = 	"INSERT INTO shelves(beerId, bottleId, shelfNumber, ogAct, fgAct, srmAct, ibuAct, startAmount, currentAmount, active, createdDate, modifiedDate ) " .
					"VALUES(" . $tap->get_beerId() . ", " . $tap->get_bottleId() . ", " . $tap->get_shelfNumber() . ", " . $tap->get_og() . ", " . $tap->get_fg() . ", " . $tap->get_srm() . ", " . $tap->get_ibu() . ", " . $tap->get_startAmount() . ", " . $tap->get_startAmount() . ", " . $tap->get_active	() . ", NOW(), NOW())";
		}		
		
		mysql_query($sql);
	}
	
	function GetById($id){
		$id = (int) preg_replace('/\D/', '', $id);
	
		$sql="SELECT * FROM shelfs WHERE id = $id";
		$qry = mysql_query($sql);
		
		if( $i = mysql_fetch_array($qry) ){
			$tap = new Tap();
			$tap->setFromArray($i);
			return $tap;
		}
		
		return null;
	}

	function updateShelfNumber($newShelfNumber){
		$sql="UPDATE config SET configValue = $newShelfNumber, modifiedDate = NOW() WHERE configName = '".ConfigNames::NumberOfShelves."'";
		mysql_query($sql);

		$sql="UPDATE bottles SET bottleStatusCode = 'SANITIZED', modifiedDate = NOW() WHERE id IN (SELECT kegId FROM Taps WHERE tapNumber > $newTapNumber AND active = 1) ";
		mysql_query($sql);
		
		$sql="UPDATE shelfs SET active = 0, modifiedDate = NOW() WHERE active = 1 AND tapNumber > $newTapNumber";
		mysql_query($sql);
	}

	function getShelfNumber(){
		$sql="SELECT configValue FROM config WHERE configName = '".ConfigNames::NumberOfShelves."'";

		$qry = mysql_query($sql);
		$config = mysql_fetch_array($qry);
		
		if( $config != false ){
			return $config['configValue'];
		}
	}

	function getActiveShelves(){
		$sql="SELECT * FROM shelves WHERE active = 1";
		$qry = mysql_query($sql);
		
		$shelves = array();
		while($i = mysql_fetch_array($qry)){
			$shelf = new Shelf();
			$shelf->setFromArray($i);
			$shelves[$shelf->get_shelfNumber()] = $shelf;
		}
		
		return $shelves;
	}
	
	function closeShelf($id){
		$sql="UPDATE shelfs SET active = 0, modifiedDate = NOW() WHERE id = $id";
		mysql_query($sql);
		
		$sql="UPDATE bottles k, shelfs t SET k.kegStatusCode = 'NEEDS_CLEANING' WHERE t.kegId = k.id AND t.Id = $id";
		mysql_query($sql);
	}
}