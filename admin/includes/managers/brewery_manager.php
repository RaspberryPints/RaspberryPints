<?php
require_once __DIR__.'/../models/brewery.php';

class BreweryManager{

	function Save($brewery){

		// download the image so we have it locally
		if ($brewery->get_imageUrl()) {
			$uniquename = uniqid("brewery-") .  ".png";
			$imagepath = "../data/images/" . $uniquename;
			copy($brewery->get_imageUrl(), $imagepath);
				if (file_exists($imagepath)) {
 				  $brewery->set_imageUrl("/data/images/" . $uniquename);
  			}
		}

		$sql = "";
		if($brewery->get_id()){
			$sql = 	"UPDATE breweries " .
					"SET " .
						"name = '" . encode($brewery->get_name()) . "', " .
						"imageUrl = '" . encode($brewery->get_imageUrl()) . "' " .
					"WHERE id = " . $brewery->get_id();

		}else{
			$sql = 	"INSERT INTO breweries(name, imageUrl ) " .
					"VALUES(" .
					"'" . encode($brewery->get_name()) . "', " .
					"'" . encode($brewery->get_imageUrl()) . "')";
		}

    mysql_query($sql);
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

	function GetAllActive(){
		$sql="SELECT * FROM breweries WHERE active = 1 ORDER BY name";
		$qry = mysql_query($sql);

		$beers = array();
		while($i = mysql_fetch_array($qry)){
			$beer = new Brewery();
			$beer->setFromArray($i);
			$beers[$beer->get_id()] = $beer;
		}

		return $beers;
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

	function Inactivate($id){

		$sql="UPDATE breweries SET active = 0 WHERE id = $id";
		//echo $sql; exit();
		$qry = mysql_query($sql);

		$_SESSION['successMessage'] = "Brewery successfully deleted.";
	}
}
