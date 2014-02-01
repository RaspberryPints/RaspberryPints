<?php
require_once __DIR__.'/../models/keg.php';

class KegManager{

	function GetAll(){
		$sql="SELECT * FROM kegs ORDER BY label";
		$qry = mysql_query($sql);
		
		$kegs = array();
		while($i = mysql_fetch_array($qry)){
			$keg = new Keg();
			$keg->setFromArray($i);
			$kegs[$keg->get_id()] = $keg;
		}
		
		return $kegs;
	}
	
	function GetAllActive(){
		$sql="SELECT * FROM kegs WHERE active = 1 ORDER BY label";
		$qry = mysql_query($sql);
		
		$kegs = array();
		while($i = mysql_fetch_array($qry)){
			$keg = new Keg();
			$keg->setFromArray($i);
			$kegs[$keg->get_id()] = $keg;
		}
		
		return $kegs;
	}
	
	function GetAllAvailable(){
		$sql="SELECT * FROM kegs WHERE active = 1
			AND kegStatusCode != 'SERVING'
			AND kegStatusCode != 'SANITIZED'
			AND kegStatusCode != 'NEEDS_CLEANING'
			AND kegStatusCode != 'NEEDS_PARTS'
			AND kegStatusCode != 'NEEDS_REPAIRS'
			AND kegStatusCode != 'FLOODED'
		ORDER BY label";
		$qry = mysql_query($sql);
		
		$kegs = array();
		while($i = mysql_fetch_array($qry)){
			$keg = new Keg();
			$keg->setFromArray($i);
			$kegs[$keg->get_id()] = $keg;
		}
		
		return $kegs;
	}
			
	function GetById($id){
		$sql="SELECT * FROM kegs WHERE id = $id";
		$qry = mysql_query($sql);
		
		if( $i = mysql_fetch_array($qry) ){		
			$keg = new Keg();
			$keg->setFromArray($i);
			return $keg;
		}

		return null;
	}
	
	
	function Save($keg){
		$sql = "";
		if($keg->get_id()){
			$sql = 	"UPDATE kegs " .
					"SET " .
						"label = '" . $keg->get_label() . "', " .
						"kegTypeId = " . $keg->get_kegTypeId() . ", " .
						"make = '" . $keg->get_make() . "', " .
						"model = '" . $keg->get_model() . "', " .
						"serial = '" . $keg->get_serial() . "', " .
						"stampedOwner = '" . $keg->get_stampedOwner() . "', " .
						"stampedLoc = '" . $keg->get_stampedLoc() . "', " .
						"weight = '" . $keg->get_weight() . "', " .
						"notes = '" . $keg->get_notes() . "', " .
						"kegStatusCode = '" . $keg->get_kegStatusCode() . "', " .
						"modifiedDate = NOW() ".
					"WHERE id = " . $keg->get_id();
					
		}else{
			$sql = 	"INSERT INTO kegs(label, kegTypeId, make, model, serial, stampedOwner, stampedLoc, weight, notes, kegStatusCode, createdDate, modifiedDate ) " .
					"VALUES(" . 
						"'". $keg->get_label() . "', " . 
						$keg->get_kegTypeId() . ", " . 
						"'". $keg->get_make() . "', " . 
						"'". $keg->get_model() . "', " . 
						"'". $keg->get_serial() . "', " . 
						"'". $keg->get_stampedOwner() . "', " . 
						"'". $keg->get_stampedLoc() . "', " . 
						"'". $keg->get_weight() . "', " . 
						"'". $keg->get_notes() . "', " . 
						"'". $keg->get_kegStatusCode() . "', " . 
						"NOW(), NOW())";
		}
		
		//echo $sql; exit();
		
		mysql_query($sql);
	}
	
	function Inactivate($id){
		$sql = "SELECT * FROM taps WHERE kegId = $id AND active = 1";
		$qry = mysql_query($sql);
		
		if( mysql_fetch_array($qry) ){		
			$_SESSION['errorMessage'] = "Keg is associated with an active tap and could not be deleted.";
			return;
		}
	
		$sql="UPDATE kegs SET active = 0 WHERE id = $id";
		//echo $sql; exit();
		
		$qry = mysql_query($sql);
		
		$_SESSION['successMessage'] = "Keg successfully deleted.";
	}
}