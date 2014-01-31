<?php
require_once __DIR__.'/../models/beer.php';

class BeerManager{

	function Save($beer){
		$sql = "";
		if($beer->get_id()){
			$sql = 	"UPDATE beers " .
					"SET " .
						"name = '" . encode($beer->get_name()) . "', " .
						"beerTypeId = '" . encode($beer->get_beerTypeId()) . "', " .
						"notes = '" . encode($beer->get_notes()) . "', " .
						"ogEst = '" . $beer->get_og() . "', " .
						"fgEst = '" . $beer->get_fg() . "', " .
						"srmEst = '" . $beer->get_srm() . "', " .
						"ibuEst = '" . $beer->get_ibu() . "', " .
						"modifiedDate = NOW() ".
					"WHERE id = " . $beer->get_id();
					
		}else{		
			$sql = 	"INSERT INTO beers(name, beerTypeId, notes, ogEst, fgEst, srmEst, ibuEst, createdDate, modifiedDate ) " .
					"VALUES(" . 
					"'" . encode($beer->get_name()) . "', " .
					$beer->get_beerTypeId() . ", " .
					"'" . encode($beer->get_notes()) . "', " .
					"'" . $beer->get_og() . "', " . 
					"'" . $beer->get_fg() . "', " . 
					"'" . $beer->get_srm() . "', " . 
					"'" . $beer->get_ibu() . "' " .
					", NOW(), NOW())";
		}
		
		//echo $sql; exit();
		
		mysql_query($sql);
	}
	
	function GetAll(){
		$sql="SELECT * FROM beers ORDER BY name";
		$qry = mysql_query($sql);
		
		$beers = array();
		while($i = mysql_fetch_array($qry)){
			$beer = new Beer();
			$beer->setFromArray($i);
			$beers[$beer->get_id()] = $beer;		
		}
		
		return $beers;
	}
	
	function GetAllActive(){
		$sql="SELECT * FROM beers WHERE active = 1 ORDER BY name";
		$qry = mysql_query($sql);
		
		$beers = array();
		while($i = mysql_fetch_array($qry)){
			$beer = new Beer();
			$beer->setFromArray($i);
			$beers[$beer->get_id()] = $beer;	
		}
		
		return $beers;
	}
		
	function GetById($id){
		$sql="SELECT * FROM beers WHERE id = $id";
		$qry = mysql_query($sql);
		
		if( $i = mysql_fetch_array($qry) ){		
			$beer = new Beer();
			$beer->setFromArray($i);
			return $beer;
		}

		return null;
	}
	
	function Inactivate($id){
		$sql = "SELECT * FROM taps WHERE beerId = $id AND active = 1";
		$qry = mysql_query($sql);
		
		if( mysql_fetch_array($qry) ){		
			$_SESSION['errorMessage'] = "Beer is associated with an active tap and could not be deleted.";
			return;
		}
	
		$sql="UPDATE beers SET active = 0 WHERE id = $id";
		//echo $sql; exit();
		$qry = mysql_query($sql);
		
		$_SESSION['successMessage'] = "Beer successfully deleted.";
	}
}