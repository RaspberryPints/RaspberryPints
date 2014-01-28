<?php
class Keg
{  
    private $_id;  
    private $_label;
	private $_kegTypeId;
	private $_make; 
	private $_model; 
	private $_serial; 
	private $_stampedOwner; 
	private $_stampedLoc; 
	private $_notes; 
	private $_kegStatusCode;
	private $_createdDate; 
	private $_modifiedDate; 

	public function __construct(){}
  
	public function get_id(){ return $this->_id; }
	public function set_id($_id){ $this->_id = $_id; }

	public function get_label(){ return $this->_label; }
	public function set_label($_label){ $this->_label = $_label; }

	public function get_kegTypeId(){ return $this->_kegTypeId; }
	public function set_kegTypeId($_kegTypeId){ $this->_kegTypeId = $_kegTypeId; }
	
	public function get_make(){ return $this->_make; }
	public function set_make($_make){ $this->_make = $_make; }

	public function get_model(){ return $this->_model; }
	public function set_model($_model){ $this->_model = $_model; }

	public function get_serial(){ return $this->_serial; }
	public function set_serial($_serial){ $this->_serial = $_serial; }

	public function get_stampedOwner(){ return $this->_stampedOwner; }
	public function set_stampedOwner($_stampedOwner){ $this->_stampedOwner = $_stampedOwner; }

	public function get_stampedLoc(){ return $this->_stampedLoc; }
	public function set_stampedLoc($_stampedLoc){ $this->_stampedLoc = $_stampedLoc; }

	public function get_notes(){ return $this->_notes; }
	public function set_notes($_notes){ $this->_notes = $_notes; }

	public function get_kegStatusCode(){ return $this->_kegStatusCode; }
	public function set_kegStatusCode($_kegStatusCode){ $this->_kegStatusCode = $_kegStatusCode; }
	
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
			
		if( isset($postArr['label']) )
			$this->set_label($postArr['label']);
		else
			$this->set_label(null);
			
		if( isset($postArr['kegTypeId']) )
			$this->set_kegTypeId($postArr['kegTypeId']);
		else
			$this->set_kegTypeId(null);
			
		if( isset($postArr['make']) )
			$this->set_make($postArr['make']);
		else
			$this->set_make(null);
			
		if( isset($postArr['model']) )
			$this->set_model($postArr['model']);
		else
			$this->set_model(null);
			
		if( isset($postArr['serial']) )
			$this->set_serial($postArr['serial']);
		else
			$this->set_serial(null);
			
		if( isset($postArr['stampedOwner']) )
			$this->set_stampedOwner($postArr['stampedOwner']);
		else
			$this->set_stampedOwner(null);
			
		if( isset($postArr['stampedLoc']) )
			$this->set_stampedLoc($postArr['stampedLoc']);
		else
			$this->set_stampedLoc(null);
			
		if( isset($postArr['notes']) )
			$this->set_notes($postArr['notes']);
		else
			$this->set_notes(null);
			
		if( isset($postArr['kegStatusCode']) )
			$this->set_kegStatusCode($postArr['kegStatusCode']);
		else
			$this->set_kegStatusCode(null);
		
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
			"label: " . $this->get_label() . ", " .
			"kegTypeId: " . $this->get_kegTypeId() . ", " .
			"make: " . $this->get_maked() . ", " .
			"model: " . $this->get_model() . ", " .
			"serial: " . $this->get_serial() . ", " .
			"stampedOwner: " . $this->get_stampedOwner() . ", " .
			"stampedLoc: " . $this->get_stampedLoc() . ", " .
			"notes: " . $this->get_notes() . ", " .
			"kegStatusCode: " . $this->get_kegStatusCode() . ", " .
			"createdDate: new Date('" . $this->get_createdDate() . "'), " .
			"modifiedDate: new Date('" . $this->get_modifiedDate() . "') " .  
		"}";
	}
}