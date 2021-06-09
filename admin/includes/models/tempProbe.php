<?php
class TempProbe  
{  
	private $_id;  
	private $_name;
	private $_type;
	private $_pin;
	private $_manualAdj;
	private $_notes;
	private $_active;
	private $_statePin;
	private $_createdDate; 
	private $_modifiedDate; 

	public function __construct(){}

	public function get_id(){ return $this->_id; }
	public function set_id($_id){ $this->_id = $_id; }

	public function get_name(){ return $this->_name; }
	public function set_name($_name){ $this->_name = $_name; }

	public function get_type(){ return $this->_type; }
	public function set_type($_type){ $this->_type = $_type; }
	
	public function get_pin(){ return $this->_pin; }
	public function set_pin($_pin){ $this->_pin = $_pin; }
	
	public function get_manualAdj(){ return $this->_manualAdj; }
	public function set_manualAdj($_manualAdj){ $this->_manualAdj = $_manualAdj; }
	
	public function get_notes() { return $this->_notes; }
	public function set_notes($_pinId){ $this->_notes = $_pinId; }
	
	public function get_active(){ return $this->_active; }
	public function set_active($_active){ $this->_active = $_active; }
	
	public function get_statePin(){ return $this->_statePin; }
	public function set_statePin($_statePin){ $this->_statePin = $_statePin; }
	
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
			
		if( isset($postArr['type']) )
			$this->set_type($postArr['type']);
		else
			$this->set_type(0);
			
		if( isset($postArr['pin']) )
			$this->set_pin($postArr['pin']);
		else
			$this->set_pin(null);
			
		if( isset($postArr['statePin']) )
		    $this->set_statePin($postArr['statePin']);
		else
		    $this->set_statePin(null);
			
		if( isset($postArr['manualAdj']) )
			$this->set_manualAdj($postArr['manualAdj']);
		else
		    $this->set_manualAdj(0);
		    		
		if( isset($postArr['notes']) )
			$this->set_notes($postArr['notes']);
		else
		    $this->set_notes(null);
		    
	    if( isset($postArr['active']) )
	        $this->set_active($postArr['active']);
        else
            $this->set_active(0);
	        
		if( isset($postArr['createdDate']) )
			$this->set_createdDate($postArr['createdDate']);
		else
			$this->set_createdDate(null);
			
		if( isset($postArr['modifiedDate']) )
			$this->set_modifiedDate($postArr['modifiedDate']);
		else
			$this->set_modifiedDate(null);
	}  
}
