<?php
require_once __DIR__.'/../models/beerStyle.php';

class BeerStyleManager{

	function GetAll(mysqli $con){
		$sql="SELECT * FROM beerStyles ORDER BY name";
		$qry = mysqli_query($con,$sql);
		
		$beerStyles = array();
		while($i = mysqli_fetch_array($qry)){
			$beerStyle = new beerStyle();
			$beerStyle->setFromArray($i);
			$beerStyles[$beerStyle->get_id()] = $beerStyle;
		}
		
		return $beerStyles;
	}



	function GetById(mysqli $con, $id){
		$sql="SELECT * FROM beerStyles WHERE id = " . $id;
		$qry = mysqli_query($con,$sql);
		
		if( $i = mysqli_fetch_array($qry) ){
			$beerStyle = new beerStyle();
			$beerStyle->setFromArray($i);
			return $beerStyle;
		}
		
		return null;
	}
}
