<?php
require_once __DIR__.'/../models/brewery.php';

class BreweryManager{

	function GetAll(){
		$sql="SELECT * FROM breweries ORDER BY name";
		$qry = mysql_query($sql);

		$breweries = array();
		while($i = mysql_fetch_array($qry)){
			$brewery = new Brewery();
			$brewery->setFromArray($i);
			$breweries[$brewery->get_id()] = $brewery;
		}

		return $breweries;
	}



	function GetById($id){
		$sql="SELECT * FROM breweries WHERE id = $id";
		$qry = mysql_query($sql);

		if( $i = mysql_fetch_array($qry) ){
			$brewery = new Brewery();
			$brewery->setFromArray($i);
			return $brewery;
		}

		return null;
	}
}
