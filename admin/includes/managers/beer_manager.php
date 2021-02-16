<?php
require_once __DIR__.'/../models/beer.php';

class BeerManager{

	function Save(mysqli $con, $beer){
		$sql = "";
		if($beer->get_id()){
			$sql = 	"UPDATE beers " .
					"SET " .
						"name = '" . encode($beer->get_name()) . "', " .
						"beerStyleId = '" . encode($beer->get_beerStyleId()) . "', " .
						"notes = '" . encode($beer->get_notes()) . "', " .
						"ogEst = '" . $beer->get_og() . "', " .
						"fgEst = '" . $beer->get_fg() . "', " .
						"srmEst = '" . $beer->get_srm() . "', " .
						"ibuEst = '" . $beer->get_ibu() . "', " .
						"modifiedDate = NOW() ".
					"WHERE id = " . $beer->get_id();
					
		}else{		
			$sql = 	"INSERT INTO beers(name, beerStyleId, notes, ogEst, fgEst, srmEst, ibuEst, createdDate, modifiedDate ) " .
					"VALUES(" . 
					"'" . encode($beer->get_name()) . "', " .
					$beer->get_beerStyleId() . ", " .
					"'" . encode($beer->get_notes()) . "', " .
					"'" . $beer->get_og() . "', " . 
					"'" . $beer->get_fg() . "', " . 
					"'" . $beer->get_srm() . "', " . 
					"'" . $beer->get_ibu() . "' " .
					", NOW(), NOW())";
		}
		
		//echo $sql; exit();
		
		mysqli_query($con, $sql);
	}
	
	function GetAll(mysqli $con){
		$sql="SELECT * FROM beers ORDER BY name";
		$qry = mysqli_query($con,$sql);
		
		$beers = array();
		while($i = mysqli_fetch_array($qry)){
			$beer = new Beer();
			$beer->setFromArray($i);
			$beers[$beer->get_id()] = $beer;		
		}
		
		return $beers;
	}
	
	function GetAllActive(mysqli $con){
		$sql="SELECT * FROM beers WHERE active = 1 ORDER BY name";
		$qry = mysqli_query($con,$sql);
		
		$beers = array();
		while($i = mysqli_fetch_array($qry)){
			$beer = new Beer();
			$beer->setFromArray($i);
			$beers[$beer->get_id()] = $beer;	
		}
		
		return $beers;
	}
		
	function GetById(mysqli $con, $id){
		$sql="SELECT * FROM beers WHERE id = " . $id;
		$qry = mysqli_query($con,$sql);
		
		if( $i = mysqli_fetch_array($qry) ){		
			$beer = new Beer();
			$beer->setFromArray($i);
			return $beer;
		}

		return null;
	}
	
	function Inactivate(mysqli $con, $id){
		$sql = "SELECT * FROM taps WHERE beerId = " . $id . "AND active = 1";
		$qry = mysqli_query($con,$sql);
		
		if( mysqli_fetch_array($qry) ){		
			$_SESSION['errorMessage'] = "Beer is associated with an active tap and could not be deleted.";
			return;
		}
	
		$sql="UPDATE beers SET active = 0 WHERE id = " .$id;
		//echo $sql; exit();
		$qry = mysqli_query($con,$sql);
		
		$_SESSION['successMessage'] = "Beer successfully deleted.";
	}
}
