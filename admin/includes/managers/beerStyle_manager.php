<?php
require_once __DIR__.'/../models/beerStyle.php';

class BeerStyleManager{

  public $link;

  function __construct()
  {
    include __DIR__.'/../conn.php';
    $this->link = $con;
  }

	function GetAll(){
		$sql="SELECT * FROM beerStyles ORDER BY name";
		$qry = mysqli_query($this->link,$sql);
		
		$beerStyles = array();
		while($i = mysqli_fetch_array($qry)){
			$beerStyle = new beerStyle();
			$beerStyle->setFromArray($i);
			$beerStyles[$beerStyle->get_id()] = $beerStyle;
		}
		
		return $beerStyles;
	}



	function GetById($id){
		$sql="SELECT * FROM beerStyles WHERE id = $id";
		$qry = mysqli_query($this->link,$sql);
		
		if( $i = mysqli_fetch_array($qry) ){
			$beerStyle = new beerStyle();
			$beerStyle->setFromArray($i);
			return $beerStyle;
		}
		
		return null;
	}
}
