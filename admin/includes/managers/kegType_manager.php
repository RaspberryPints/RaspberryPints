<?php
require_once __DIR__.'/../models/kegType.php';

class KegTypeManager{
	
	function __construct() {
		$this->db = MysqliDb::getInstance();
	}

	function GetAll(){
		
		$kegType_data = $this->db->orderBy('displayName', 'ASC')->get('kegTypes');
		
		$kegTypes = array();
		
		foreach ($kegType_data as $k) {
			$kegType = new KegType();
			$kegType->setFromArray($k);
			$kegTypes[$kegType->get_id()] = $kegType;
		}
				
		return $kegTypes;
	}
	
	
		
	function GetById($id){
		
		$kegType_data = $this->db->where('id', $id)->getOne('kegTypes');
		
		if( $this->db->count > 0 ){
			$kegType = new KegType();
			$kegType->setFromArray($kegType_data);
			return $kegType;
		}
		
		return null;
	}
}