<?php
require_once __DIR__.'/../functions.php';

class Hop 
{  
    private $_id;  
	private $_name;
	private $_alpha;
	private $_beta; 
	private $_notes;  
	private $_createdDate; 
	private $_modifiedDate; 

	public function __construct(){}
  
	public function get_id(){ return $this->_id; }
	public function set_id($_id){ $this->_id = $_id; }

	public function get_name(){ return $this->_name; }
	public function set_name($_name){ $this->_name = $_name; }
	
	public function get_alpha(){ return $this->_alpha; }
	public function set_alpha($_alpha){ $this->_alpha = $_alpha; }
	
	public function get_beta(){ return $this->_beta; } 
	public function set_beta($_beta){ $this->_beta = $_beta; }
	
	public function get_notes(){ return $this->_notes; }
	public function set_notes($_notes){ $this->_notes = $_notes; }

    public function get_createdDate(){ return $this->_createdDate; }
	public function get_createdDateFormatted(){ return Manager::format_time($this->_createdDate); }
	public function set_createdDate($_createdDate){ $this->_createdDate = $_createdDate; }
	
	public function get_modifiedDate(){ return $this->_modifiedDate; }
	public function get_modifiedDateFormatted(){ return Manager::format_time($this->_modifiedDate); }
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
			
		if( isset($postArr['alpha']) )
			$this->set_alpha($postArr['alpha']);
		else
			$this->set_alpha(null);
			
		if( isset($postArr['beta']) )
			$this->set_beta($postArr['beta']);
		else
		    $this->set_beta(null);
			
		if( isset($postArr['notes']) )
			$this->set_notes($postArr['notes']);
		else
		    $this->set_notes(null);
			
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
			"name: " . $this->get_name() . ", " .
			"alpha: '" . encode($this->get_alpha()) . "', " .
			"beta: '" . $this->get_beta() . "', " .
			"notes: '" . $this->get_notes() . "', " .
			"createdDate: new Date('" . $this->get_createdDate() . "'), " .
			"modifiedDate: new Date('" . $this->get_modifiedDate() . "') " .  
		"}";
	}
}