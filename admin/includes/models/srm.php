<?php
class Srm  
{  
	private $_id;  
	private $_srm;
	private $_rgb; 

	public function __construct(){}
	
	public static function fromColors($srm, $rgb){
		$newSrm = new Srm();
		$newSrm->set_srm($srm);
		$newSrm->set_rgb($rgb);	
		return $newSrm;
	}

	public function get_id(){ return $this->_id; }
	public function set_id($_id){ $this->_id = $_id; }

	public function get_srm(){ return $this->_srm; }
	public function set_srm($_srm){ $this->_srm = $_srm; }
	
	public function get_rgb(){ return $this->_rgb; }
	public function set_rgb($_rgb){ $this->_rgb = $_rgb; }
	
	public function setFromArray($postArr)  
	{  	
		if( isset($postArr['id']) )
			$this->set_id($postArr['id']);
		else
			$this->set_id(null);
			
		if( isset($postArr['srm']) )
			$this->set_srm($postArr['srm']);
		else
			$this->set_srm(null);
			
		if( isset($postArr['rgb']) )
			$this->set_rgb($postArr['rgb']);
		else
			$this->set_rgb(null);
	}
}
