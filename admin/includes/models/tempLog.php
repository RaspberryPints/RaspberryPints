<?php
class TempLog 
{  
	private $_id;  
	private $_probe;
	private $_temp;
	private $_tempUnit;
	private $_humidity;
	private $_takenDate; 
	private $_statePinState; 

	public function __construct(){}

	public function get_id(){ return $this->_id; }
	public function set_id($_id){ $this->_id = $_id; }

	public function get_probe(){ return $this->_probe; }
	public function set_probe($_probe){ $this->_probe = $_probe; }

	public function get_temp(){ return $this->_temp; }
	public function set_temp($_temp){ $this->_temp = $_temp; }

	public function get_tempUnit(){ return $this->_tempUnit; }
	public function set_tempUnit($_tempUnit){ $this->_tempUnit = $_tempUnit; }
	
	public function get_humidity(){ return $this->_humidity; }
	public function set_humidity($_humidity){ $this->_humidity = $_humidity; }
		
	public function get_takenDate(){ return $this->_takenDate; }
	public function get_takenDateFormatted(){ return Manager::format_time($this->_takenDate); }
	public function set_takenDate($_takenDate){ $this->_takenDate = $_takenDate; }
	
	public function get_statePinState(){ return $this->_statePinState; }
	public function set_statePinState($_statePinState){ $this->_statePinState = $_statePinState; }
	
	public function setFromArray($postArr)  
	{  	
		if( isset($postArr['id']) )
			$this->set_id($postArr['id']);
		else
			$this->set_id(null);
						
		if( isset($postArr['probe']) )
			$this->set_probe($postArr['probe']);
		else
			$this->set_probe(null);
			
		if( isset($postArr['temp']) )
			$this->set_temp($postArr['temp']);
		else
			$this->set_temp(0);
			
		if( isset($postArr['tempUnit']) )
		    $this->set_tempUnit($postArr['tempUnit']);
		else
		    $this->set_tempUnit(0);
			
		if( isset($postArr['humidity']) )
			$this->set_humidity($postArr['humidity']);
		else
			$this->set_humidity(null);
			
		if( isset($postArr['takenDate']) )
			$this->set_takenDate($postArr['takenDate']);
		else
			$this->set_takenDate(null);
		
		if( isset($postArr['statePinState']) )
		    $this->set_statePinState($postArr['statePinState']);
		else
		    $this->set_statePinState(null);
	}  
}
