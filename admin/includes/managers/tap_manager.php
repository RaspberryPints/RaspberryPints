<?php
require_once __DIR__.'/../../../includes/config_names.php';
require_once __DIR__.'/../models/tap.php';

class TapManager{
	
	function __construct() {
		$this->db = MysqliDb::getInstance();
	}
	
	function Save($tap){
		
		$data = array(
			'kegStatusCode' => 'SERVING'
		);
		
		$this->db->where('id', $tap->get_kegId())->update('kegs', $data);		
		
		
		
		$data = array(
			'active' => 0,
			'modifiedDate' => 'NOW()'
		);
		
		$this->db->where('active', 1)->where('tapNumber', $tap->get_tapNumber())->update('taps', $data);		
		
		if($tap->get_id()){
			$data = array(
				'beerId' => $tap->get_beerId(),
				'kegId' => $tap->get_kegId(),
				'tapNumber' => $tap->get_tapNumber(),
				'ogAct' => $tap->get_og(),
				'fgAct' => $tap->get_fg(),
				'srmAct' => $tap->get_srm(),
				'ibuAct' => $tap->get_ibu(),
				'startAmount' => $tap->get_startAmount(),
				'active' => $tap->get_active(),
				'modifiedDate' => 'NOW()'
			);
			
			$this->db->where('id', $tap->get_id())->update('taps', $data);					
		}else{
			$data = array(
				'beerId' => $tap->get_beerId(),
				'kegId' => $tap->get_kegId(),
				'tapNumber' => $tap->get_tapNumber(),
				'ogAct' => $tap->get_og(),
				'fgAct' => $tap->get_fg(),
				'srmAct' => $tap->get_srm(),
				'ibuAct' => $tap->get_ibu(),
				'startAmount' => $tap->get_startAmount(),
				'currentAmount' => $tap->get_startAmount(),
				'active' => $tap->get_active(),
				'createdDate' => 'NOW()',
				'modifiedDate' => 'NOW()'
			);
			
			$this->db->insert('taps', $data);
		}		
	}
	
	function GetById($id){
		$id = (int) preg_replace('/\D/', '', $id);
		
		$tap_data = $this->db->where('id', $id)->getOne('taps');
		
		if( $this->db->count > 0 ){
			$tap = new Tap();
			$tap->setFromArray($tap_data);
			return $tap;
		}
		
		return null;
	}

	function updateTapNumber($newTapNumber){
		
		$data = array(
			'configValue' => $newTapNumber
		);
		
		$this->db->where('configName', ConfigNames::NumberOfTaps)->update('config', $data);
		
		
		$data = array(
			'active' => 0,
			'modifiedDate' => 'NOW()'
		);
		
		$this->db->where('active', 1)->where('tapNumber', $newTapNumber, '>')->update('taps', $data);
	}

	function getTapNumber(){
		$config = $this->db->where('configName', ConfigNames::NumberOfTaps)->getValue('config', 'configValue');
		
		if( $config != false ){
			return $config;
		}
	}

	function getActiveTaps(){
		$tap_data = $this->db->where('active', 1)->get('taps');
		
		$taps = array();
		
		if( $this->db->count > 0 ){
			foreach ($tap_data as $t) {
				$tap = new Tap();
				$tap->setFromArray($t);
				$taps[$tap->get_tapNumber()] = $tap;
			}
		}
		
		return $taps;
	}
	
	function closeTap($id){
		
		$data = array(
			'active' => 0,
			'modifiedDate' => 'NOW()'
		);
		
		$this->db->where('id', $id)->update('taps', $data);
		
		
		$data = array(
			'kegStatusCode' => 'NEEDS_CLEANING'
		);
	
		
		$this->db->rawQuery("UPDATE kegs k, taps t SET k.kegStatusCode = 'NEEDS_CLEANING' WHERE t.kegId = k.id AND t.Id = ?", array($id));
	}
}
?>