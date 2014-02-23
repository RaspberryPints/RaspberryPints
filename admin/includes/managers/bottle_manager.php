<?php
require_once __DIR__.'/../models/bottle.php';

class BottleManager{

	function GetAll(){
		$sql="SELECT * FROM bottles ORDER BY label";
		$qry = mysql_query($sql);
		
		$kegs = array();
		while($i = mysql_fetch_array($qry)){
			$keg = new Shelf();
			$keg->setFromArray($i);
			$kegs[$keg->get_id()] = $keg;
		}
		
		return $kegs;
	}
	
	function GetAllActive(){
		$sql="SELECT * FROM bottles WHERE active = 1 ORDER BY label";
		$qry = mysql_query($sql);
		
		$bottles = array();
		while($i = mysql_fetch_array($qry)){
			$bottle = new Bottle();
			$bottle->setFromArray($i);
			$bottles[$bottle->get_id()] = $bottle;
		}
		
		return $bottles;
	}
	
	function GetAllAvailable(){
		$sql="SELECT * FROM bottles WHERE active = 1
			AND kegStatusCode != 'SERVING'
			AND kegStatusCode != 'NEEDS_CLEANING'
			AND kegStatusCode != 'NEEDS_PARTS'
			AND kegStatusCode != 'NEEDS_REPAIRS'
		ORDER BY label";
		$qry = mysql_query($sql);
		$bottles = array();
		while($i = mysql_fetch_array($qry)){
			$bottle = new Bottle();
			$bottle->setFromArray($i);
			$bottles[$bottle->get_id()] = $bottle;
		}
		
		return $bottles;
	}
			
	function GetById($id){
		$sql="SELECT * FROM bottles WHERE id = $id";
		$qry = mysql_query($sql);
		
		if( $i = mysql_fetch_array($qry) ){		
			$bottle = new Bottle();
			$bottle->setFromArray($i);
			return $bottle;
		}

		return null;
	}
	
	
	function Save($keg){
		$sql = "";
		if($keg->get_id()){
			$sql = 	"UPDATE bottles " .
					"SET " .
						"label = '" . $keg->get_label() . "', " .
						"bottleTypeId = " . $keg->get_bottleTypeId() . ", " .
						"stampedOwner = '" . $keg->get_stampedOwner() . "', " .
						"stampedLoc = '" . $keg->get_stampedLoc() . "', " .
						"notes = '" . $keg->get_notes() . "', " .
						"kegStatusCode = '" . $keg->get_kegStatusCode() . "', " .
						"modifiedDate = NOW() ".
					"WHERE id = " . $keg->get_id();
					
		}else{
			$sql = 	"INSERT INTO bottles(label, bottleTypeId, stampedOwner, stampedLoc,  notes, kegStatusCode, createdDate, modifiedDate ) " .
					"VALUES(" . 
						"'". $keg->get_label() . "', " . 
						$keg->get_bottleTypeId() . ", " .  
						"'". $keg->get_stampedOwner() . "', " . 
						"'". $keg->get_stampedLoc() . "', " . 
						"'". $keg->get_notes() . "', " . 
						"'". $keg->get_kegStatusCode() . "', " . 
						"NOW(), NOW())";
		}
		
		//echo $sql; exit();
		
		$result = mysql_query($sql);
		if (!$result){
			die('Invalid query: ' . mysql_error() . $sql);
		}
	}
	
	function Inactivate($id){
		$sql = "SELECT * FROM shelves WHERE bottleId = $id AND active = 1";
		$qry = mysql_query($sql);
		
		if( mysql_fetch_array($qry) ){		
			$_SESSION['errorMessage'] = "Bottle is associated with an active shelf and could not be deleted.";
			return;
		}
	
		$sql="UPDATE bottles SET active = 0 WHERE id = $id";
		//echo $sql; exit();
		
		$qry = mysql_query($sql);
		
		$_SESSION['successMessage'] = "Bottle successfully deleted.";
	}
}
