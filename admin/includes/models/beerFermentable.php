<?php
require_once __DIR__.'/../functions.php';

class BeerFermentable  
{  
    private $_id;  
    private $_beerID;
	private $_name;
	private $_type;
	private $_amount; 
	private $_srm;  
	private $_createdDate; 
	private $_modifiedDate; 

	public function __construct(){}
  
	public function get_id(){ return $this->_id; }
	public function set_id($_id){ $this->_id = $_id; }

	public function get_beerID(){ return $this->_beerID; }
	public function set_beerID($_beerID){ $this->_name = $_beerID; }

	public function get_name(){ return $this->_name; }
	public function set_name($_name){ $this->_name = $_name; }
	
	public function get_type(){ return $this->_type; }
	public function set_type($_type){ $this->_type = $_type; }
	
	public function get_amount(){ return $this->_amount; } 
	public function set_amount($_amount){ $this->_amount = $_amount; }
	
	public function get_srm(){ return $this->_srm; }
	public function set_srm($_srm){ $this->_srm = $_srm; }

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
			
		if( isset($postArr['beerID']) )
			$this->set_beerID($postArr['beerID']);
		else
			$this->set_beerID(null);
			
		if( isset($postArr['name']) )
			$this->set_name($postArr['name']);
		else
			$this->set_name(null);
			
		if( isset($postArr['type']) )
			$this->set_type($postArr['type']);
		else
			$this->set_type(null);
			
		if( isset($postArr['amount']) )
			$this->set_amount($postArr['amount']);
		else
			$this->set_amount(null);
			
		if( isset($postArr['srm']) )
			$this->set_srm($postArr['srm']);
		else
			$this->set_srm(null);
			
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
			"beerID: '" . encode($this->get_beerID()) . "', " .
			"name: " . $this->get_name() . ", " .
			"type: '" . encode($this->get_type()) . "', " .
			"srm: '" . $this->get_srm() . "', " .
			"amount: '" . $this->get_amount() . "', " .
			"fg: '" . $this->get_fg() . "', " .
			"createdDate: new Date('" . $this->get_createdDate() . "'), " .
			"modifiedDate: new Date('" . $this->get_modifiedDate() . "') " .  
		"}";
	}
}