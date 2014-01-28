<?php
require_once __DIR__.'/../models/beer.php';

class BeerManager{

	function GetAll(){
		$sql="SELECT * FROM beers";
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
}