<?php
require_once __DIR__.'/../models/beerType.php';

class BeerTypeManager{

	function GetAll(){
		$sql="SELECT * FROM beerTypes ORDER BY name";
		$qry = mysql_query($sql);
		
		$beerTypes = array();
		while($i = mysql_fetch_array($qry)){
			$beerType = new beerType();
			$beerType->setFromArray($i);
			$beerTypes[$beerType->get_id()] = $beerType;		
		}
		
		return $beerTypes;
	}
	
	
		
	function GetById($id){
		$sql="SELECT * FROM beerTypes WHERE id = $id";
		$qry = mysql_query($sql);
		
		if( $i = mysql_fetch_array($qry) ){		
			$beerType = new beerType();
			$beerType->setFromArray($i);
			return $beerType;
		}

		return null;
	}
}