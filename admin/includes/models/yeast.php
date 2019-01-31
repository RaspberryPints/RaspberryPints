<?php
require_once __DIR__.'/../functions.php';

class Yeast 
{  
    private $_id;  
	private $_name;
	private $_strand;
	private $_format; 
	private $_minTemp;  
	private $_maxTemp;  
	private $_minAttenuation;  
	private $_maxAttenuation;  
	private $_flocculation;  
	private $_notes;  
	private $_createdDate; 
	private $_modifiedDate; 

	public function __construct(){}
  
	public function get_id(){ return $this->_id; }
	public function set_id($_id){ $this->_id = $_id; }

	public function get_name(){ return $this->_name; }
	public function set_name($_name){ $this->_name = $_name; }
	
	public function get_strand(){ return $this->_strand; }
	public function set_strand($_strand){ $this->_strand = $_strand; }
	
	public function get_format(){ return $this->_format; } 
	public function set_format($_format){ $this->_format = $_format; }
	
	public function get_minTemp(){ return $this->_minTemp; } 
	public function set_minTemp($_minTemp){ $this->_minTemp = $_minTemp; }
	public function get_maxTemp(){ return $this->_maxTemp; } 
	public function set_maxTemp($_maxTemp){ $this->_maxTemp = $_maxTemp; }
	
	public function get_minAttenuation(){ return $this->_minAttenuation; } 
	public function set_minAttenuation($_minAttenuation){ $this->_minAttenuation = $_minAttenuation; }
	public function get_maxAttenuation(){ return $this->_maxAttenuation; } 
	public function set_maxAttenuation($_maxAttenuation){ $this->_maxAttenuation = $_maxAttenuation; }
	
	public function get_flocculation(){ return $this->_flocculation; } 
	public function set_flocculation($_flocculation){ $this->_flocculation = $_flocculation; }
	
	public function get_notes(){ return $this->_notes; }
	public function set_notes($_notes){ $this->_notes = $_notes; }

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
			
		if( isset($postArr['strand']) )
		    $this->set_strand($postArr['strand']);
	    else
	        $this->set_strand(null);
	        
        if( isset($postArr['format']) )
            $this->set_format($postArr['format']);
        else
            $this->set_format(null);
        
		if( isset($postArr['minTemp']) )
			$this->set_minTemp($postArr['minTemp']);
		else
		    $this->set_minTemp(null);
		
		if( isset($postArr['maxTemp']) )
			$this->set_maxTemp($postArr['maxTemp']);
		else
		    $this->set_maxTemp(null);
			
		if( isset($postArr['minAttenuation']) )
			$this->set_minAttenuation($postArr['minAttenuation']);
		else
		    $this->set_minAttenuation(null);
		
		if( isset($postArr['maxAttenuation']) )
		    $this->set_maxAttenuation($postArr['maxAttenuation']);
		else
		    $this->set_maxAttenuation(null);
			
	    if( isset($postArr['flocculation']) )
	        $this->set_flocculation($postArr['flocculation']);
		else
		    $this->set_flocculation(null);
			
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
}