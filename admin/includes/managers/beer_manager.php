<?php
require_once dirname(__FILE__) . '/../models/beer.php';

class BeerManager{
	
	function __construct() {
		$this->db = MysqliDb::getInstance();
	}
	
	function Save($beer){
		

		if($beer->get_id()){
			$data = array(
				'name' => encode($beer->get_name()),
				'beerStyleId' => encode($beer->get_beerStyleId()),
				'notes' => encode($beer->get_notes()),
				'ogEst' => $beer->get_og(),
				'fgEst' => $beer->get_fg(),
				'srmEst' => $beer->get_srm(),
				'ibuEst' => $beer->get_ibu(),
				'modifiedDate' => 'NOW()'
			);
			
			$this->db->where('id', $beer->get_id())->update('beers', $data);					
		}else{
			$data = array(
				'name' => encode($beer->get_name()),
				'beerStyleId' => encode($beer->get_beerStyleId()),
				'notes' => encode($beer->get_notes()),
				'ogEst' => $beer->get_og(),
				'fgEst' => $beer->get_fg(),
				'srmEst' => $beer->get_srm(),
				'ibuEst' => $beer->get_ibu(),
				'createdDate' => 'NOW()',
				'modifiedDate' => 'NOW()'
			);
			
			$this->db->insert('beers', $data);			
		}
	}
	
	function GetAll(){
		
		$beer_data = $this->db->orderBy('name', 'ASC')->get('beers');
		
		$beers = array();
		
		foreach ($beer_data as $b) {
			$beer = new Beer();
			$beer->setFromArray($b);
			$beers[$beer->get_id()] = $beer;
		}
		
		return $beers;
	}
	
	function GetAllActive(){
		
		$beer_data = $this->db->where('active', 1)->orderBy('name', 'ASC')->get('beers');
				
		$beers = array();
		
		foreach ($beer_data as $b) {
			$beer = new Beer();
			$beer->setFromArray($b);
			$beers[$beer->get_id()] = $beer;
		}
		
		return $beers;
	}
		
	function GetById($id){
		
		$beer_data = $this->db->where('id', $id)->getOne('beers');
		
		if( $this->db->count > 0 ){
			$beer = new Beer();
			$beer->setFromArray($beer_data);
			return $beer;
		}
		
		return null;
	}
	
	function Inactivate($id){
		$this->db->where('beerId', $id)->where('active', 1)->get('taps');
		
		if( $this->db->count > 0 ){		
			$_SESSION['errorMessage'] = "Beer is associated with an active tap and could not be deleted.";
			return;
		} else {
			if ($this->db->where('id', $id)->update('beers', array('active' => 0))) {
				$_SESSION['successMessage'] = "Beer successfully deleted.";
			}
		}
	}
}