<?php
require_once __DIR__.'/../models/keg.php';

class KegManager{
	
	function __construct() {
		$this->db = MysqliDb::getInstance();
	}

	function GetAll(){
		
		$keg_data = $this->db->orderBy('label', 'ASC')->get('kegs');
		
		$kegs = array();
		
		foreach ($keg_data as $k) {
			$keg = new Keg();
			$keg->setFromArray($k);
			$kegs[$keg->get_id()] = $keg;
		}
		
		return $kegs;
	}
	
	function GetAllActive(){
		
		$keg_data = $this->db->where('active', 1)->orderBy('label', 'ASC')->get('kegs');
		
		$kegs = array();
		
		foreach ($keg_data as $k) {
			$keg = new Keg();
			$keg->setFromArray($k);
			$kegs[$keg->get_id()] = $keg;
		}
		
		return $kegs;
	}
	
	function GetAllAvailable(){
		
		$keg_data = $this->db->where('active',1)->where('kegStatusCode', 'SERVING', '!=')->where('kegStatusCode', 'NEEDS_CLEANING', '!=')->where('kegStatusCode', 'NEEDS_PARTS', '!=')->where('kegStatusCode', 'NEEDS_REPAIRS', '!=')->get('kegs');
		
		$kegs = array();
		
		foreach ($keg_data as $k) {
			$keg = new Keg();
			$keg->setFromArray($k);
			$kegs[$keg->get_id()] = $keg;
		}
		
		return $kegs;
	}
			
	function GetById($id){
		
		$keg_data = $this->db->where('id', $id)->getOne('kegs');
		
		if( $this->db->count > 0 ){
			$keg = new Keg();
			$keg->setFromArray($keg_data);
			return $keg;
		}
		
		return null;
	}
	
	
	function Save($keg){
		if($keg->get_id()){
			$data = array(
				'label' =>  $keg->get_label(),
				'kegTypeId' => $keg->get_kegTypeId(),
				'make' => $keg->get_make(),
				'model' => $keg->get_model(),
				'serial' => $keg->get_serial(),
				'stampedOwner' => $keg->get_stampedOwner(),
				'stampedLoc' => $keg->get_stampedLoc(),
				'weight' => $keg->get_weight(),
				'notes' => $keg->get_notes(),
				'kegStatusCode' => $keg->get_kegStatusCode(),
				'modifiedDate' => 'NOW()'
			);
			
			$this->db->where('id', $keg->get_id())->update('kegs', $data);					
		} else {
			$data = array(
				'label' =>  $keg->get_label(),
				'kegTypeId' => $keg->get_kegTypeId(),
				'make' => $keg->get_make(),
				'model' => $keg->get_model(),
				'serial' => $keg->get_serial(),
				'stampedOwner' => $keg->get_stampedOwner(),
				'stampedLoc' => $keg->get_stampedLoc(),
				'weight' => $keg->get_weight(),
				'notes' => $keg->get_notes(),
				'kegStatusCode' => $keg->get_kegStatusCode(),
				'createdDate' => 'NOW()',
				'modifiedDate' => 'NOW()'
			);
			
			$this->db->insert('kegs', $data);
		}
	}
	
	function Inactivate($id){
		
		$this->db->where('kegId', $id)->where('active', 1)->get('taps');
	
		
		if ($this->db->count > 0) {
			$_SESSION['errorMessage'] = "Keg is associated with an active tap and could not be deleted.";
			return;
		} else {
			if ($this->db->where('id', $id)->update('kegs', array('active' => 0))) {
				$_SESSION['successMessage'] = "Keg successfully deleted.";
			}
		}
	}
}