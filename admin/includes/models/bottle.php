<?php
class Bottle  
{  
	private $_id;  
	private $_bottleTypeId;
	private $_beerId;
	private $_beerBatchId;
	private $_capRgba;
	private $_capNumber;
	private $_startAmount; 
	private $_currentAmount; 
	private $_active;
	private $_createdDate; 
	private $_modifiedDate; 

	public function __construct(){}

	public function get_id(){ return $this->_id; }
	public function set_id($_id){ $this->_id = $_id; }

	public function get_bottleTypeId(){ return $this->_bottleTypeId; }
	public function set_bottleTypeId($_bottleTypeId){ $this->_bottleTypeId = $_bottleTypeId; }

	public function get_beerId(){ return $this->_beerId; }
	public function set_beerId($_beerId){ $this->_beerId = $_beerId; }
	
	public function get_beerBatchId(){ return $this->_beerBatchId; }
	public function set_beerBatchId($_beerBatchId){ $this->_beerBatchId = $_beerBatchId; }

	public function get_capRgba(){ return $this->_capRgba; }
	public function set_capRgba($_capRgba){ $this->_capRgba = $_capRgba; }
	
	public function get_capNumber() { return $this->_capNumber; }
	public function set_capNumber($_capNumber){ $this->_capNumber = $_capNumber; }
	
	public function get_startAmount(){ return $this->_startAmount; }
	public function set_startAmount($_startAmount){ $this->_startAmount = $_startAmount; }
	
	public function get_currentAmount(){ return $this->_currentAmount; }
	public function set_currentAmount($_currentAmount){ $this->_currentAmount = $_currentAmount; }
	
	public function get_active(){ return $this->_active; }
	public function set_active($_active){ $this->_active = $_active; }
	
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
			
		if( isset($postArr['bottleTypeId']) )
			$this->set_bottleTypeId($postArr['bottleTypeId']);
		else
			$this->set_bottleTypeId(null);
			
		if( isset($postArr['beerId']) )
			$this->set_beerId($postArr['beerId']);
		else
			$this->set_beerId(null);
			
		if( isset($postArr['beerBatchId']) )
		    $this->set_beerBatchId($postArr['beerBatchId']);
		else
		    $this->set_beerBatchId(null);
			
		if( isset($postArr['capRgba']) )
			$this->set_capRgba($postArr['capRgba']);
		else
			$this->set_capRgba(null);
			
		if( isset($postArr['capNumber']) )
			$this->set_capNumber($postArr['capNumber']);
		else
			$this->set_capNumber('0');
							
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

	function toJson(){
		return "{" . 
			"id: " . $this->get_id() . ", " .
			"bottleTypeId: " . $this->get_bottleTypeId() . ", " .
			"beerId: " . $this->get_beerId() . ", " .
			"beerBatchId: " . $this->get_beerBatchId() . ", " .
			"capRgba: " . $this->get_capRgba() . ", " .
			"capNumber: " . $this->get_capNumber() . ", " .
			"startAmount: " . $this->get_startAmount() . ", " .
			"currentAmount: " . $this->get_currentAmount() . ", " .
			"active: '" . $this->get_active() . "', " .
			"createdDate: new Date('" . $this->get_createdDate() . "'), " .
			"modifiedDate: new Date('" . $this->get_modifiedDate() . "') " .  
		"}";
	}
}
