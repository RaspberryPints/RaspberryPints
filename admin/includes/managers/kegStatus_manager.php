<?php
require_once __DIR__.'/../models/kegStatus.php';

class KegStatusManager{
	
	function __construct() {
		$this->db = MysqliDb::getInstance();
	}

	function GetAll(){
		
		$kegStatus_data = $this->db->orderBy('name', 'ASC')->get('kegStatuses');
		
		$kegStatuses = array();
		
		foreach ($kegStatus_data as $k) {
			$kegStatus = new KegStatus();
			$kegStatus->setFromArray($k);
			$kegStatuses[$kegStatus->get_code()] = $kegStatus;
		}
				
		return $kegStatuses;
	}	
		
	function GetByCode($code){
		$kegStatus_data = $this->db->where('code', $code)->getOne('kegStatuses');
		
		if( $this->db->count > 0 ){
			$kegStatus = new KegStatus();
			$kegStatus->setFromArray($kegStatus_data);
			return $kegStatus;
		}
	}
}