<?php
require_once __DIR__.'/../functions.php';

class BeerBatchDateType 
{
    private $_type;  
    private $_displayName;
    private $_createdDate;
    private $_modifiedDate; 

    public function __construct(){}
    
    public function get_type(){ return $this->_type; }
    public function set_type($_type){ $this->_type = $_type; }

	public function get_displayName(){ return $this->_displayName; }
	public function set_displayName($_displayName){ $this->_displayName = $_displayName; }
	
	public function get_createdDate(){ return $this->_createdDate; }
	public function set_createdDate($_createdDate){ $this->_createdDate = $_createdDate; }
	
	public function get_modifiedDate(){ return $this->_modifiedDate; }
	public function set_modifiedDate($_modifiedDate){ $this->_modifiedDate = $_modifiedDate; }
	
    public function setFromArray($postArr)  
    {
        if( isset($postArr['type']) )
            $this->set_type($postArr['type']);
        else
            $this->set_type(null);
        
		if( isset($postArr['displayName']) )
			$this->set_displayName($postArr['displayName']);
		else
			$this->set_displayName(null);
			
		if (isset($postArr['createdDate']))
            $this->set_createdDate($postArr['createdDate']);
        else
            $this->set_createdDate(null);

        if (isset($postArr['modifiedDate']))
            $this->set_modifiedDate($postArr['modifiedDate']);
        else
            $this->set_modifiedDate(null);
			                
    }  
	
	function toJson(){ return json_encode(get_object_vars($this)); }
}