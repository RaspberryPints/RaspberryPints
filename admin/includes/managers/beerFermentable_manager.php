<?php
require_once __DIR__.'/../models/beerFermentable.php';

class BeerFermentableManager{

	function Save($beerFermentable){
		$sql = "";
		if($beerFermentable->get_id()){
			$sql = 	"UPDATE beers_fermentables " .
					"SET " .
						"name = '" . encode($beerFermentable->get_name()) . "', " .
						"beer_id = '" . encode($beerFermentable->get_beerID) . "', " .
						"name = '" . encode($beerFermentable->get_name()) . "', " .
						"type = '" . $beerFermentable->get_type() . "', " .
						"amount = '" . $beerFermentable->get_amount() . "', " .
						"srm = '" . $beerFermentable->get_srm() . "', " .
						"modifiedDate = NOW() ".
					"WHERE id = " . $beerFermentable->get_id();
					
		}else{		
			$sql = 	"INSERT INTO beers_fermentables(beer_id, name, type, amount, srm, createdDate, modifiedDate ) " .
					"VALUES(" . 
					"'" . encode($beerFermentable->get_beerID()) . "', " .
					$beerFermentable->get_name() . ", " .
					"'" . encode($beerFermentable->get_type()) . "', " .
					"'" . $beerFermentable->get_amount() . "', " . 
					"'" . $beerFermentable->get_srm() . "', " . 
					", NOW(), NOW())";
		}
		

		mysql_query($sql);
	}
	
	function GetById($id){
		$sql="SELECT * FROM beers_fermentables WHERE beer_id = $id";
		$qry = mysql_query($sql);
		
		 $beerFermentables = array();
		 while($i = mysql_fetch_array($qry)){
			 $beerFermentable = new beerFermentable();
			 $beerFermentable->setFromArray($i);
			 $beerFermentables[$beerFermentable->get_id()] = $beerFermentable;	
		 }
		
		 return $beerFermentables;
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