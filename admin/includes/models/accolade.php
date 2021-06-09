<?php
require_once __DIR__.'/../functions.php';

class Accolade  
{  
    private $_id;  
	private $_name;
	private $_type;
	private $_rank;
	private $_srm;  
	private $_rgb; 
	private $_notes;
	private $_createdDate; 
	private $_modifiedDate; 

	public function __construct(){}
  
	public function get_id(){ return $this->_id; }
	public function set_id($_id){ $this->_id = $_id; }

	public function get_name(){ return $this->_name; }
	public function set_name($_name){ $this->_name = $_name; }
	
	public function get_type(){ return $this->_type; }
	public function set_type($_type){ $this->_type = $_type; }
	
	public function get_rank(){ return $this->_rank; }
	public function set_rank($_rank){ $this->_rank = $_rank; }
	
	public function get_srm(){ return $this->_srm; }
	public function set_srm($_srm){ $this->_srm = $_srm; }
	
	public function get_rgb(){ return $this->_rgb; }
	public function set_rgb($_rgb){ $this->_rgb = $_rgb; }
	
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
			
		if( isset($postArr['rank']) )
		    $this->set_rank($postArr['rank']);
	    else
	        $this->set_rank(null);
	    
		if( isset($postArr['type']) )
			$this->set_type($postArr['type']);
		else
			$this->set_type(null);
			
		if( isset($postArr['srm']) )
			$this->set_srm($postArr['srm']);
		else
		    $this->set_srm(null);
		    
	    if( isset($postArr['rgb']) )
	        $this->set_rgb($postArr['rgb']);
        else
            $this->set_rgb(null);
			
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
			"type: '" . encode($this->get_type()) . "', " .
			"srm: '" . $this->get_srm() . "', " .
			"createdDate: new Date('" . $this->get_createdDate() . "'), " .
			"modifiedDate: new Date('" . $this->get_modifiedDate() . "') " .  
		"}";
	}
}