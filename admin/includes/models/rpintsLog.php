<?php
class RPintsLog 
{  
	private $_id;  
	private $_process;
	private $_category;
	private $_text;
	private $_occurances;
	private $_createdDate; 
	private $_modifiedDate; 

	public function __construct(){}

	public function get_id(){ return $this->_id; }
	public function set_id($_id){ $this->_id = $_id; }

	public function get_process(){ return $this->_process; }
	public function set_process($_process){ $this->_process = $_process; }

	public function get_category(){ return $this->_category; }
	public function set_category($_category){ $this->_category = $_category; }

	public function get_text(){ return $this->_text; }
	public function set_text($_text){ $this->_text = $_text; }
	
	public function get_occurances(){ return $this->_occurances; }
	public function set_occurances($_occurances){ $this->_occurances = $_occurances; }
	
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
						
		if( isset($postArr['process']) )
			$this->set_process($postArr['process']);
		else
			$this->set_process(null);
			
		if( isset($postArr['category']) )
			$this->set_category($postArr['category']);
		else
			$this->set_category(null);
			
		if( isset($postArr['text']) )
		    $this->set_text($postArr['text']);
		else
		    $this->set_text(null);
			
		if( isset($postArr['occurances']) )
			$this->set_occurances($postArr['occurances']);
		else
			$this->set_occurances(1);
			
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
	   	    '"id": "' . $this->get_id() . '",' .
	   	    '"process": "' . $this->get_process() . '",' .
	   	    '"category": "' . encode($this->get_category()) . '",' .
	   	    '"text": "' . $this->get_text() . '",' .
	   	    '"occurances": "' . $this->get_occurances() . '",' .
	   	    '"createdDate": "' . $this->get_createdDate() . '",' .
	   	    '"modifiedDate": "' . $this->get_modifiedDate() . '"' .
	   	    "}";
	}
}
