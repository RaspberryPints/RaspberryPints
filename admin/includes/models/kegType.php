<?php
class KegType  
{  
	private $_id;  
	private $_name;
	private $_maxAmount; 
	private $_maxAmountUnit; 
	private $_emptyWeight; 
	private $_emptyWeightUnit; 
	private $_createdDate; 
	private $_modifiedDate; 

	public function __construct(){}

	public function get_id(){ return $this->_id; }
	public function set_id($_id){ $this->_id = $_id; }

	public function get_name(){ return $this->_name; }
	public function set_name($_name){ $this->_name = $_name; }

	public function get_maxAmount(){ return $this->_maxAmount; }
	public function set_maxAmount($_maxAmount){ $this->_maxAmount = $_maxAmount; }
	
	public function get_maxAmountUnit(){ return $this->_maxAmountUnit; }
	public function set_maxAmountUnit($_maxAmountUnit){ $this->_maxAmountUnit = $_maxAmountUnit; }
	
	public function get_emptyWeight(){ return $this->_emptyWeight; }
	public function set_emptyWeight($_emptyWeight){ $this->_emptyWeight = $_emptyWeight; }
	
	public function get_emptyWeightUnit(){ return $this->_emptyWeightUnit; }
	public function set_emptyWeightUnit($_emptyWeightUnit){ $this->_emptyWeightUnit = $_emptyWeightUnit; }
	
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
		else if( isset($postArr['displayName']) )
			$this->set_name($postArr['displayName']);
		else
			$this->set_name(null);
			
		if( isset($postArr['maxAmount']) )
			$this->set_maxAmount($postArr['maxAmount']);
		else
			$this->set_maxAmount(null);
		
		if( isset($postArr['maxAmountUnit']) )
		    $this->set_maxAmountUnit($postArr['maxAmountUnit']);
		else
		    $this->set_maxAmountUnit(null);
		
		if( isset($postArr['emptyWeight']) )
			$this->set_emptyWeight($postArr['emptyWeight']);
		else
			$this->set_emptyWeight(null);
		
		if( isset($postArr['emptyWeightUnit']) )
		    $this->set_emptyWeightUnit($postArr['emptyWeightUnit']);
		else
		    $this->set_emptyWeightUnit(null);
		
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
			"name: '" . $this->get_name() . "', " .
			"maxAmount: " . $this->get_maxAmount() . ", " .
			"maxAmountUnit: " . $this->get_maxAmountUnit() . ", " .
			"emptyWeight: " . $this->get_emptyWeight() . ", " .
			"emptyWeightUnit: " . $this->get_emptyWeightUnit() . ", " .
			"createdDate: new Date('" . $this->get_createdDate() . "'), " .
			"modifiedDate: new Date('" . $this->get_modifiedDate() . "') " .  
		"}";
	}
}