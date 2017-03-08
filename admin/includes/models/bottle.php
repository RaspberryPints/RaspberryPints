<?php
class Bottle
{  
	private $_id;  
	private $_label;
	private $_bottleTypeId;
	private $_stampedOwner; 
	private $_stampedLoc; 
	private $_notes; 
	private $_kegStatusCode;
	private $_active;
	private $_createdDate; 
	private $_modifiedDate; 

	public function __construct(){}

	public function get_id(){ return $this->_id; }
	public function set_id($_id){ $this->_id = $_id; }

	public function get_label(){ return $this->_label; }
	public function set_label($_label){ $this->_label = $_label; }

	public function get_bottleTypeId(){ return $this->_bottleTypeId; }
	public function set_bottleTypeId($_bottleTypeId){ $this->_bottleTypeId = $_bottleTypeId; }

	public function get_stampedOwner(){ return $this->_stampedOwner; }
	public function set_stampedOwner($_stampedOwner){ $this->_stampedOwner = $_stampedOwner; }

	public function get_stampedLoc(){ return $this->_stampedLoc; }
	public function set_stampedLoc($_stampedLoc){ $this->_stampedLoc = $_stampedLoc; }

	public function get_notes(){ return $this->_notes; }
	public function set_notes($_notes){ $this->_notes = $_notes; }

	public function get_kegStatusCode(){ return $this->_kegStatusCode; }
	public function set_kegStatusCode($_kegStatusCode){ $this->_kegStatusCode = $_kegStatusCode; }
	
	public function get_active(){ return $this->_active; }
	public function set_active($_active){ $this->_active = $_active; }
	
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
			
		if( isset($postArr['bottleTypeId']) )
			$this->set_bottleTypeId($postArr['bottleTypeId']);
		else
			$this->set_bottleTypeId(null);
			
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
		
		if( isset($postArr['active']) )
			$this->set_active($postArr['active']);
		else
			$this->set_active(null);
			
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
			"bottleTypeId: " . $this->get_bottleTypeId() . ", " .
			"stampedOwner: " . $this->get_stampedOwner() . ", " .
			"stampedLoc: " . $this->get_stampedLoc() . ", " .
			"notes: " . $this->get_notes() . ", " .
			"kegStatusCode: " . $this->get_kegStatusCode() . ", " .
			"active: '" . $this->get_active() . "', " .
			"createdDate: new Date('" . $this->get_createdDate() . "'), " .
			"modifiedDate: new Date('" . $this->get_modifiedDate() . "') " .  
		"}";
	}
}