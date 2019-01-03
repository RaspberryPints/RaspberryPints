<?php
class MotionDetector
{
    private $_id;  
	private $_name;
	private $_pin;
	private $_type;
	private $_priority;

	public function __construct(){}
	
	public function get_id(){ return $this->_id; }
	public function set_id($_id){ $this->_id = $_id; }
	
	public function get_name(){ return $this->_name; }
	public function set_name($_name){ $this->_name = $_name; }

	public function get_pin(){ return $this->_pin; }
	public function set_pin($_pin){ $this->_pin = $_pin; }
	
	public function get_type(){ return $this->_type; }
	public function set_type($_type){ $this->_type = $_type; }
	
	public function get_priority(){ return $this->_priority; }
	public function set_priority($_priority){ $this->_priority = $_priority; }
	
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

		if( isset($postArr['pin']) )
			$this->set_pin($postArr['pin']);
		else
			$this->set_pin(null);
		
		if( isset($postArr['type']) )
			$this->set_type($postArr['type']);
		else
			$this->set_type(null);
		
		if( isset($postArr['priority']) )
			$this->set_priority($postArr['priority']);
		else
			$this->set_priority(null);
	}

	function toJson(){
	    return "{" .
	   	    "id: " . $this->get_id() . ", " .
	   	    "name: '" . $this->get_name() . "', " .
	   	    "type: '" . $this->get_type() . "', " .
	   	    "pin: '" . $this->get_pin() . "', " .
	   	    "priority: '" . $this->get_priority() . "', " .
		"}";
	}
}
