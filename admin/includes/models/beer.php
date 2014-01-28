<?php
require_once __DIR__.'/../functions.php';

class Beer  
{  
    private $_id;  
    private $_name;
	private $_og; 
	private $_fg;  
	private $_srm;  
	private $_ibu;
	private $_createdDate; 
	private $_modifiedDate; 

	public function __construct(){}
  
	public function get_id(){ return $this->_id; }
	public function set_id($_id){ $this->_id = $_id; }

	public function get_name(){ return $this->_name; }
	public function set_name($_name){ $this->_name = $_name; }

	public function get_og(){ return $this->_og; } 
	public function set_og($_og){ $this->_og = $_og; }
	
	public function get_fg(){ return $this->_fg; }
	public function set_fg($_fg){ $this->_fg = $_fg;}

	public function get_srm(){ return $this->_srm; }
	public function set_srm($_srm){ $this->_srm = $_srm; }

	public function get_ibu(){ return $this->_ibu; }
	public function set_ibu($_ibu){ $this->_ibu = $_ibu; }
	
	public function get_createdDate(){ return $this->_createdDate; }
	public function set_createdDate($_createdDate){ $this->_createdDate = $_createdDate; }
	
	public function get_modifiedDate(){ return $this->_modifiedDate; }
	public function set_modifiedDate($_modifiedDate){ $this->_modifiedDate = $_modifiedDate; }
	
    public function setFromArray($postArr)  
    {  
		if( isset($postArr['id']) )
			$this->set_id($postArr['id']);
		else
			$this->set_id(null);
			
		if( isset($postArr['name']) )
			$this->set_name($postArr['name']);
		else
			$this->set_name(null);
			
		if( isset($postArr['ogAct']) )
			$this->set_og($postArr['ogAct']);
		else if( isset($postArr['ogEst']) )
			$this->set_og($postArr['ogEst']);
		else
			$this->set_og(null);
			
		if( isset($postArr['fgAct']) )
			$this->set_fg($postArr['fgAct']);
		else if( isset($postArr['fgEst']) )
			$this->set_fg($postArr['fgEst']);
		else
			$this->set_fg(null);
			
		if( isset($postArr['srmAct']) )
			$this->set_srm($postArr['srmAct']);
		else if( isset($postArr['srmEst']) )
			$this->set_srm($postArr['srmEst']);
		else
			$this->set_srm(null);
			
		if( isset($postArr['srmAct']) )
			$this->set_srm($postArr['srmAct']);
		else if( isset($postArr['srmEst']) )
			$this->set_srm($postArr['srmEst']);
		else
			$this->set_srm(null);
			
		if( isset($postArr['ibuAct']) )
			$this->set_ibu($postArr['ibuAct']);
		else if( isset($postArr['ibuEst']) )
			$this->set_ibu($postArr['ibuEst']);
		else
			$this->set_ibu(null);
		
		if( isset($postArr['createdDate']) )
			$this->set_createdDate($postArr['createdDate']);
		else
			$this->set_createdDate(null);
			
		if( isset($postArr['modifiedDate']) )
			$this->set_modifiedDate($postArr['modifiedDate']);
		else
			$this->set_modifiedDate(null);
    }  
	
	function toJson(){
		return "{" . 
			"id: " . $this->get_id() . ", " .
			"name: '" . encode($this->get_name()) . "', " .
			"srm: '" . $this->get_srm() . "', " .
			"og: '" . $this->get_og() . "', " .
			"fg: '" . $this->get_fg() . "', " .
			"ibu: '" . $this->get_ibu() . "', " .
			"createdDate: new Date('" . $this->get_createdDate() . "'), " .
			"modifiedDate: new Date('" . $this->get_modifiedDate() . "') " .  
		"}";
	}
}