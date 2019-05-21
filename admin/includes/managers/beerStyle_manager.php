<?php
require_once __DIR__.'/../models/beerStyle.php';

class BeerStyleManager{

	function GetAll(){
        global $con;
		$sql="SELECT * FROM beerStyles ORDER BY name";
		//$qry = mysql_query($sql);
        $qry = mysqli_query($con, $sql);
		
		$beerStyles = array();
		/* while($i = mysql_fetch_array($qry)){ */
		while($i = mysqli_fetch_assoc($qry)){
			$beerStyle = new beerStyle();
			$beerStyle->setFromArray($i);
			$beerStyles[$beerStyle->get_id()] = $beerStyle;
		}

		return $beerStyles;
	}
	
	
		
	function GetById($id){
        global $con;
		$sql="SELECT * FROM beerStyles WHERE id = $id";
		//$qry = mysql_query($sql);
        $qry = mysqli_query($con, $sql);
		
		//if( $i = mysql_fetch_array($qry) ){
        if( $i = mysqli_fetch_assoc($qry) ){
			$beerStyle = new beerStyle();
			$beerStyle->setFromArray($i);
			return $beerStyle;
		}

		return null;
	}
}