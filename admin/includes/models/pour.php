<?php
require_once __DIR__.'/../functions.php';

class Pour  
{  
	private $_id;  
	private $_tapNumber;
	private $_tapRgba;
	private $_beerName;
	private $_beerUntID;
	private $_breweryImageUrl;
	private $_amountPoured;
	private $_userName;
	private $_tapId;
	private $_flowPinId;
	private $_pulses;
	private $_beerId;
	private $_conversion;
	private $_userId;
	
	private $_createdDate;

	public function __construct(){}

	public function get_id(){ return $this->_id; }
	public function set_id($_id){ $this->_id = $_id; }

	public function get_tapNumber(){ return $this->_tapNumber; }
	public function set_tapNumber($_tapNumber){ $this->_tapNumber = $_tapNumber; }

	public function get_tapRgba(){ return $this->_tapRgba; }
	public function set_tapRgba($_tapRgba){ $this->_tapRgba = $_tapRgba; }
	
	public function get_beerName(){ return $this->_beerName; }
	public function set_beerName($_beerName){ $this->_beerName = $_beerName; }

	public function get_beerUntID(){return $this->_beerUntID;}
	public function set_beerUntID($_beerUntID){ $this->_beerUntID = $_beerUntID; }

	public function get_breweryImageUrl(){ return $this->_breweryImageUrl; }
	public function set_breweryImageUrl($_breweryImageUrl){ $this->_breweryImageUrl = $_breweryImageUrl; }
	
	public function get_amountPoured(){ return $this->_amountPoured; }
	public function set_amountPoured($_amountPoured){ $this->_amountPoured = $_amountPoured; }

	public function get_userName(){ return $this->_userName; } 
	public function set_userName($_userName){ $this->_userName = $_userName; }

	public function get_tapId(){ return $this->_tapId; } 
	public function set_tapId($_tapId){ $this->_tapId = $_tapId; }
	
	public function get_flowPinId(){ return $this->_flowPinId; } 
	public function set_flowPinId($_flowPinId){ $this->_flowPinId= $_flowPinId; }
	
	public function get_pulses(){ return $this->_pulses; } 
	public function set_pulses($_pulses){ $this->_pulses = $_pulses; }
	
	public function get_beerId(){ return $this->_beerId; } 
	public function set_beerId($_beerId){ $this->_beerId = $_beerId; }
	
	public function get_conversion(){ return $this->_conversion; } 
	public function set_conversion($_conversion){ $this->_conversion = $_conversion; }
	
	public function get_userId(){ return $this->_userId; } 
	public function set_userId($_userId){ $this->_userId = $_userId; }
	
	public function get_createdDate(){ return $this->_createdDate; } 
	public function set_createdDate($_createdDate){ $this->_createdDate = $_createdDate; }
	
	public function setFromArray($postArr)  
	{  
		if( isset($postArr['id']) )
			$this->set_id($postArr['id']);
		else
			$this->set_id(null);
			
		if( isset($postArr['tapNumber']) )
			$this->set_tapNumber($postArr['tapNumber']);
		else
			$this->set_tapNumber(null);
			
		if( isset($postArr['tapRgba']) )
			$this->set_tapRgba($postArr['tapRgba']);
		else
			$this->set_tapRgba(null);
			
		if( isset($postArr['beerName']) )
			$this->set_beerName($postArr['beerName']);
		else
			$this->set_beerName(null);
			
		if( isset($postArr['beerUntID']) )
			$this->set_beerUntID($postArr['beerUntID']);
		else
			$this->set_beerUntID(null);
						
		if( isset($postArr['breweryImageUrl']) )
			$this->set_breweryImageUrl($postArr['breweryImageUrl']);
		else
			$this->set_breweryImageUrl(null);
			
		if( isset($postArr['amountPoured']) )
			$this->set_amountPoured($postArr['amountPoured']);
		else
			$this->set_amountPoured(null);
			
		if( isset($postArr['userName']) )
			$this->set_userName($postArr['userName']);
		else
			$this->set_userName(null);
			
		if( isset($postArr['createdDate']) )
			$this->set_createdDate($postArr['createdDate']);
		else
			$this->set_createdDate(null);
			
		if( isset($postArr['tapId']) )
			$this->set_tapId($postArr['tapId']);
		else
			$this->set_tapId(null);
			
		if( isset($postArr['pinId']) )
			$this->set_pinId($postArr['pinId']);
		else
			$this->set_pinId(null);
			
		if( isset($postArr['pulses']) )
			$this->set_pulses($postArr['pulses']);
		else
			$this->set_pulses(null);
			
		if( isset($postArr['beerId']) )
			$this->set_beerId($postArr['beerId']);
		else
			$this->set_beerId(null);
			
		if( isset($postArr['conversion']) )
			$this->set_conversion($postArr['conversion']);
		else
			$this->set_conversion(null);
			
		if( isset($postArr['userId']) )
			$this->set_userId($postArr['userId']);
		else
			$this->set_userId(null);
	}  
	
	function toJson(){
		return "{" . 
			"id: " . $this->get_id() . ", " .
			"tapNumber: '" . encode($this->get_tapNumber()) . "', " .
			"tapRgba: '" . encode($this->get_tapRgba()) . "', " .
			"beerName: '" . encode($this->get_beerName()) . "', " .
			"beerUntID: " . $this->get_beerUntID() . ", " .
			"breweryImageUrl: " . $this->get_breweryImageUrl() . ", " .
			"amountPoured: '" . encode($this->get_amountPoured()) . "', " .
			"userName: '" . $this->get_userName() . "', " .
			"tapId: '" . encode($this->get_tapId()) . "', " .
			"flowPinId: '" . encode($this->get_pinId()) . "', " .
			"pulses: '" . encode($this->get_pulses()) . "', " .
			"beerId: '" . encode($this->get_beerId()) . "', " .
			"conversion: '" . encode($this->get_conversion()) . "', " .
			"userId: '" . encode($this->get_userId()) . "', " .
			"createdDate: '" . $this->get_createdDate() . "' " .

		"}";
		
	}
}
