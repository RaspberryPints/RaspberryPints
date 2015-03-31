<?php
require_once __DIR__.'/../models/beerStyle.php';

class BeerStyleManager{
	
	function __construct() {
		$this->db = MysqliDb::getInstance();
	}

	function GetAll(){
		
		$style_data = $this->db->orderBy('name', 'ASC')->get('beerStyles');
		
		$beerStyles = array();
		
		foreach ($style_data as $s) {
			$beerStyle = new beerStyle();
			$beerStyle->setFromArray($s);
			$beerStyles[$beerStyle->get_id()] = $beerStyle;
		}
		
		return $beerStyles;
	}



	function GetById($id){
		$style_data = $this->db->where('id', $id)->getOne('beerStyles');
		
		if( $this->db->count > 0 ){
			$beerStyle = new beerStyle();
			$beerStyle->setFromArray($style_data);
			return $beerStyle;
		}
		
		return null;
	}
}