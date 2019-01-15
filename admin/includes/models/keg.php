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
	private $_weight; 
	private $_notes; 
	private $_kegStatusCode;
	private $_beerId;
	private $_active;
	private $_onTapId;
	private $_tapNumber;
	private $_emptyWeight;
	private $_maxVolume;
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

	public function get_weight(){ return $this->_weight; }
	public function set_weight($_weight){ 
	    $this->_weight = $_weight;
	    if($this->_emptyWeight > $this->_weight) $this->_weight = $this->_emptyWeight;
	}

	public function get_notes(){ return $this->_notes; }
	public function set_notes($_notes){ $this->_notes = $_notes; }

	public function get_kegStatusCode(){ return $this->_kegStatusCode; }
	public function set_kegStatusCode($_kegStatusCode){ $this->_kegStatusCode = $_kegStatusCode; }
	
	public function get_beerId(){ return $this->_beerId; }
	public function set_beerId($_beerId){ $this->_beerId = $_beerId; }
	
	public function get_active(){ return $this->_active; }
	public function set_active($_active){ $this->_active = $_active; }
	
	public function get_onTapId(){ return $this->_onTapId; }
	public function set_onTapId($_onTapId){ $this->_onTapId = $_onTapId; }
	
	public function get_tapNumber(){ return $this->_tapNumber; }
	public function set_tapNumber($_tapNumber){ $this->_tapNumber = $_tapNumber; }
	
	public function get_emptyWeight(){ return $this->_emptyWeight; }
	public function set_emptyWeight($_emptyWeight){ 
	    $this->_emptyWeight = $_emptyWeight; 
	    if($this->_emptyWeight > $this->_weight) $this->_weight = $this->_emptyWeight;
	}
	
	public function get_maxVolume(){ return $this->_maxVolume; }
	public function set_maxVolume($_maxVolume){ $this->_maxVolume = $_maxVolume; }
	
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
			
		if( isset($postArr['weight']) )
			$this->set_weight($postArr['weight']);
		else
			$this->set_weight(null);
			
		if( isset($postArr['notes']) )
			$this->set_notes($postArr['notes']);
		else
			$this->set_notes(null);
			
		if( isset($postArr['kegStatusCode']) )
			$this->set_kegStatusCode($postArr['kegStatusCode']);
		else
			$this->set_kegStatusCode(null);
		
		if( isset($postArr['beerId']) )
			$this->set_beerId($postArr['beerId']);
		else
			$this->set_beerId(null);
		
		if( isset($postArr['active']) )
			$this->set_active($postArr['active']);
		else
			$this->set_active(null);
			
		if( isset($postArr['onTapId']) )
			$this->set_onTapId($postArr['onTapId']);
		else
			$this->set_onTapId($this->get_onTapId());
		
		if( isset($postArr['tapNumber']) )
			$this->set_tapNumber($postArr['tapNumber']);
		else
			$this->set_tapNumber($this->get_tapNumber());
		
		if( isset($postArr['emptyWeight']) )
			$this->set_emptyWeight($postArr['emptyWeight']);
		else
			$this->set_emptyWeight(null);
		
		if( isset($postArr['maxVolume']) )
			$this->set_maxVolume($postArr['maxVolume']);
		else
			$this->set_maxVolume(null);
		
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
			"make: " . $this->get_make() . ", " .
			"model: " . $this->get_model() . ", " .
			"serial: " . $this->get_serial() . ", " .
			"stampedOwner: " . $this->get_stampedOwner() . ", " .
			"stampedLoc: " . $this->get_stampedLoc() . ", " .
			"weight: " . $this->get_weight() . ", " .
			"notes: " . $this->get_notes() . ", " .
			"kegStatusCode: " . $this->get_kegStatusCode() . ", " .
			"onTapId: " . $this->get_onTapId() . ", " .
			"beerId: " . $this->get_beerId() . ", " .
			"active: '" . $this->get_active() . "', " .
			"emptyWeight: " . $this->get_emptyWeight() . ", " .
			"maxVolume: " . $this->get_maxVolume() . ", " .
			"createdDate: new Date('" . $this->get_createdDate() . "'), " .
			"modifiedDate: new Date('" . $this->get_modifiedDate() . "') " .  
		"}";
	}
}