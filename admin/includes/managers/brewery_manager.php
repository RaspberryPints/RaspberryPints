<?php
require_once __DIR__.'/../models/brewery.php';

class BreweryManager{

	function Save($brewery){
		$sql = "";
		if($brewery->get_id()){
			$sql = 	"UPDATE beers " .
					"SET " .
						"name = '" . encode($brewery->get_name()) . "', " .
						"imageUrl = '" . encode($brewery->get_imageUrl()) .
					" WHERE id = " . $brewery->get_id();

		}else{
			$sql = 	"INSERT INTO breweries(name, imageUrl ) " .
					"VALUES(" .
					"'" . encode($brewery->get_name()) . "', " .
					"'" . encode($brewery->get_imageUrl()) . "')";
		}

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
