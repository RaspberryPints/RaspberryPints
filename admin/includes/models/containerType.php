<?php
class ContainerType  
{  
	private $_id;  
	private $_name;
	private $_volume; 
	private $_total; 
	private $_used; 
	private $_createdDate; 
	private $_modifiedDate; 

	public function __construct(){}

	public function get_id(){ return $this->_id; }
	public function set_id($_id){ $this->_id = $_id; }

	public function get_name(){ return $this->_name; }
	public function set_name($_name){ $this->_name = $_name; }

	public function get_volume(){ return $this->_volume; }
	public function set_volume($_volume){ $this->_volume = $_volume; }
	
	public function get_total(){ return $this->_total; }
	public function set_total($_total){ $this->_total = $_total; }
	
	public function get_used(){ return $this->_used; }
	public function set_used($_used){ $this->_used = $_used; }
	
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
		else if( isset($postArr['displayName']) )
			$this->set_name($postArr['displayName']);
		else
			$this->set_name(null);
			
		if( isset($postArr['volume']) )
			$this->set_volume($postArr['volume']);
		else
			$this->set_volume(null);
			
		if( isset($postArr['total']) )
			$this->set_total($postArr['total']);
		else
			$this->set_total(null);
			
		if( isset($postArr['used']) )
			$this->set_used($postArr['used']);
		else
			$this->set_used(null);
		
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
			"name: '" . $this->get_name() . "', " .
			"volume: " . $this->get_volume() . ", " .
			"total: " . $this->get_total() . ", " .
			"used: " . $this->get_used() . ", " .
			"createdDate: new Date('" . $this->get_createdDate() . "'), " .
			"modifiedDate: new Date('" . $this->get_modifiedDate() . "') " .  
		"}";
	}
}
