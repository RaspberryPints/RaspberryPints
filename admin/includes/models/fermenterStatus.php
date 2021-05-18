<?php
class FermenterStatus  
{  
	private $_code;  
	private $_name;
	private $_createdDate; 
	private $_modifiedDate; 

	public function __construct(){}

	public function get_code(){ return $this->_code; }
	public function set_code($_code){ $this->_code = $_code; }

	public function get_name(){ return $this->_name; }
	public function set_name($_name){ $this->_name = $_name; }
	
	public function get_createdDate(){ return $this->_createdDate; }
	public function set_createdDate($_createdDate){ $this->_createdDate = $_createdDate; }
	
	public function get_modifiedDate(){ return $this->_modifiedDate; }
	public function set_modifiedDate($_modifiedDate){ $this->_modifiedDate = $_modifiedDate; }
	
	public function setFromArray($postArr)  
	{  	
		if( isset($postArr['code']) )
			$this->set_code($postArr['code']);
		else
			$this->set_code(null);
			
		if( isset($postArr['name']) )
			$this->set_name($postArr['name']);
		else
			$this->set_name(null);
			
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
		return json_encode($this);
	}
}