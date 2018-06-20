<?php
class Tap  
{  
	private $_id;  
	private $_kegId;
	private $_beerId;
	private $_tapNumber;
	private $_tapRgba;
	private $_flowPinId;
	private $_count; 
	private $_valvePinId;
	private $_valveOn; 
	private $_startAmount; 
	private $_currentAmount; 
	private $_active;
	private $_createdDate; 
	private $_modifiedDate; 

	public function __construct(){}

	public function get_id(){ return $this->_id; }
	public function set_id($_id){ $this->_id = $_id; }

	public function get_kegId(){ return $this->_kegId; }
	public function set_kegId($_kegId){ $this->_kegId = $_kegId; }

	public function get_beerId(){ return $this->_beerId; }
	public function set_beerId($_beerId){ $this->_beerId = $_beerId; }
	
	public function get_tapNumber(){ return $this->_tapNumber; }
	public function set_tapNumber($_tapNumber){ $this->_tapNumber = $_tapNumber; }
	
	public function get_tapRgba(){ return $this->_tapRgba; }
	public function set_tapRgba($_tapRgba){ $this->_tapRgba = $_tapRgba; }
	
	public function get_valvePinId() { return $this->_valvePinId; }
	public function set_valvePinId($_pinId){ $this->_valvePinId = $_pinId; }
	
	public function get_valveOn() { return $this->_valveOn; }
	public function set_valveOn($_valveOn){ $this->_valveOn = $_valveOn; }
	
	public function get_flowPinId() { return $this->_pinId; }
	public function set_flowPinId($_pinId){ $this->_pinId = $_pinId; }
	
	public function get_count(){ return $this->_count; }
	public function set_count($_count){ $this->_count = $_count; }
	
	public function get_startAmount(){ return $this->_startAmount; }
	public function set_startAmount($_startAmount){ $this->_startAmount = $_startAmount; }
	
	public function get_currentAmount(){ return $this->_currentAmount; }
	public function set_currentAmount($_currentAmount){ $this->_currentAmount = $_currentAmount; }
	
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
						
		if( isset($postArr['kegId']) )
			$this->set_kegId($postArr['kegId']);
		else
			$this->set_kegId(null);
			
		if( isset($postArr['beerId']) )
			$this->set_beerId($postArr['beerId']);
		else
			$this->set_beerId(null);
			
		if( isset($postArr['tapNumber']) )
			$this->set_tapNumber($postArr['tapNumber']);
		else
			$this->set_tapNumber(null);
			
		if( isset($postArr['tapRgba']) )
			$this->set_tapRgba($postArr['tapRgba']);
		else
			$this->set_tapRgba(null);
		
		if( isset($postArr['flowPin']) )
			$this->set_flowPinId($postArr['flowPin']);
		else
			$this->set_flowPinId('0');
			
		if( isset($postArr['count']) )
			$this->set_count($postArr['count']);
		else
			$this->set_count('0');
		
		if( isset($postArr['valvePin']) )
			$this->set_valvePinId($postArr['valvePin']);
		else
			$this->set_valvePinId('0');
			
		if( isset($postArr['valveOn']) )
			$this->set_valveOn($postArr['valveOn']);
		else
			$this->set_valveOn('0');
				
		if( isset($postArr['startAmount']) )
			$this->set_startAmount($postArr['startAmount']);
		else
			$this->set_startAmount(null);
				
		if( isset($postArr['currentAmount']) )
			$this->set_currentAmount($postArr['currentAmount']);
		else
			$this->set_currentAmount(null);
		
		if( isset($postArr['active']) )
			$this->set_active($postArr['active']);
		else
			$this->set_active(false);
		
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
