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
	private $_weightUnit; 
	private $_notes; 
	private $_kegStatusCode;
	private $_beerId;
	private $_beerBatchId;
	private $_active;
	private $_onTapId;
	private $_tapNumber;
	private $_emptyWeight;
	private $_emptyWeightUnit;
	private $_maxVolume;
	private $_maxVolumeUnit;
	private $_startAmount;
	private $_startAmountUnit;
	private $_currentAmount;
	private $_currentAmountUnit;
	private $_fermenationPSI;
	private $_fermenationPSIUnit;
	private $_keggingTemp;
	private $_keggingTempUnit;
	private $_hasContinuousLid;
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
	
	public function get_weightUnit(){ return $this->_weightUnit; }
	public function set_weightUnit($_weightUnit){ $this->_weightUnit = $_weightUnit;	}

	public function get_notes(){ return $this->_notes; }
	public function set_notes($_notes){ $this->_notes = $_notes; }

	public function get_kegStatusCode(){ return $this->_kegStatusCode; }
	public function set_kegStatusCode($_kegStatusCode){ $this->_kegStatusCode = $_kegStatusCode; }
	
	public function get_beerId(){ return $this->_beerId; }
	public function set_beerId($_beerId){ $this->_beerId = $_beerId; }
	
	public function get_beerBatchId(){ return $this->_beerBatchId; }
	public function set_beerBatchId($_beerBatchId){ $this->_beerBatchId = $_beerBatchId; }
	
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
	
	public function get_emptyWeightUnit(){ return $this->_emptyWeightUnit; }
	public function set_emptyWeightUnit($_emptyWeightUnit){ $this->_emptyWeightUnit = $_emptyWeightUnit; }
	
	public function get_maxVolume(){ return $this->_maxVolume; }
	public function set_maxVolume($_maxVolume){ $this->_maxVolume = $_maxVolume; }
	
	public function get_maxVolumeUnit(){ return $this->_maxVolumeUnit; }
	public function set_maxVolumeUnit($_maxVolumeUnit){ $this->_maxVolumeUnit = $_maxVolumeUnit; }
	
	public function get_startAmount(){ return $this->_startAmount; }
	public function set_startAmount($_startAmount){ $this->_startAmount = $_startAmount; }
	
	public function get_startAmountUnit(){ return $this->_startAmountUnit; }
	public function set_startAmountUnit($_startAmountUnit){ $this->_startAmountUnit = $_startAmountUnit; }
	
	public function get_currentAmount(){ return $this->_currentAmount; }
	public function set_currentAmount($_currentAmount){ $this->_currentAmount = $_currentAmount; }
	
	public function get_currentAmountUnit(){ return $this->_currentAmountUnit; }
	public function set_currentAmountUnit($_currentAmountUnit){ $this->_currentAmountUnit = $_currentAmountUnit; }
	
	public function get_fermentationPSI(){ return $this->_fermentationPSI; }
	public function set_fermentationPSI($_fermentationPSI){ $this->_fermentationPSI = $_fermentationPSI; }
	
	public function get_fermentationPSIUnit(){ return $this->_fermentationPSIUnit; }
	public function set_fermentationPSIUnit($_fermentationPSIUnit){ $this->_fermentationPSIUnit = $_fermentationPSIUnit; }
	
	public function get_keggingTemp(){ return $this->_keggingTemp; }
	public function set_keggingTemp($_keggingTemp){ $this->_keggingTemp = $_keggingTemp; }
	
	public function get_keggingTempUnit(){ return $this->_keggingTempUnit; }
	public function set_keggingTempUnit($_keggingTempUnit){ $this->_keggingTempUnit = $_keggingTempUnit; }
	
	public function get_hasContinuousLid(){ return $this->_hasContinuousLid; }
	public function set_hasContinuousLid($_hasContinuousLid){ $this->_hasContinuousLid = $_hasContinuousLid; }
	
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
			
		if( isset($postArr['weightUnit']) )
		    $this->set_weightUnit($postArr['weightUnit']);
		else
		    $this->set_weightUnit(null);
		
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
		
		if( isset($postArr['beerBatchId']) )
		    $this->set_beerBatchId($postArr['beerBatchId']);
		else
		    $this->set_beerBatchId(null);
		
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
		
		if( isset($postArr['emptyWeightUnit']) )
		    $this->set_emptyWeightUnit($postArr['emptyWeightUnit']);
		else
		    $this->set_emptyWeightUnit(null);
		
		if( isset($postArr['maxVolume']) )
			$this->set_maxVolume($postArr['maxVolume']);
		else
			$this->set_maxVolume(null);
		
		if( isset($postArr['maxVolumeUnit']) )
		    $this->set_maxVolumeUnit($postArr['maxVolumeUnit']);
		else
		    $this->set_maxVolumeUnit(null);
			
		if( isset($postArr['startAmount']) )
		    $this->set_startAmount($postArr['startAmount']);
	    else
	        $this->set_startAmount(null);
	        
		if( isset($postArr['startAmountUnit']) )
		    $this->set_startAmountUnit($postArr['startAmountUnit']);
	    else
	        $this->set_startAmountUnit(null);
	        
        if( isset($postArr['currentAmount']) )
            $this->set_currentAmount($postArr['currentAmount']);
        else
            $this->set_currentAmount(null);
            
        if( isset($postArr['currentAmountUnit']) )
            $this->set_currentAmountUnit($postArr['currentAmountUnit']);
        else
            $this->set_currentAmountUnit(null);
            
        if( isset($postArr['fermentationPSI']) )
            $this->set_fermentationPSI($postArr['fermentationPSI']);
        else
            $this->set_fermentationPSI(null);
        
        if( isset($postArr['fermentationPSIUnit']) )
            $this->set_fermentationPSIUnit($postArr['fermentationPSIUnit']);
        else
            $this->set_fermentationPSIUnit(null);
        
        if( isset($postArr['keggingTemp']) )
            $this->set_keggingTemp($postArr['keggingTemp']);
        else
            $this->set_keggingTemp(null);
        
        if( isset($postArr['keggingTempUnit']) )
            $this->set_keggingTempUnit($postArr['keggingTempUnit']);
        else
            $this->set_keggingTempUnit(null);
        
        if( isset($postArr['hasContinuousLid']) )
            $this->set_hasContinuousLid($postArr['hasContinuousLid']);
        else
            $this->set_hasContinuousLid(0);
        
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
			"weightUnit: " . $this->get_weightUnit() . ", " .
			"notes: " . $this->get_notes() . ", " .
			"kegStatusCode: " . $this->get_kegStatusCode() . ", " .
			"onTapId: " . $this->get_onTapId() . ", " .
			"beerId: " . $this->get_beerId() . ", " .
			"beerBatchId: " . $this->get_beerBatchId() . ", " .
			"active: '" . $this->get_active() . "', " .
			"emptyWeight: " . $this->get_emptyWeight() . ", " .
			"emptyWeightUnit: " . $this->get_emptyWeightUnit() . ", " .
			"maxVolume: " . $this->get_maxVolume() . ", " .
			"maxVolumeUnit: " . $this->get_maxVolumeUnit() . ", " .
			"startAmount: " . $this->get_startAmount() . ", " .
			"startAmountUnit: " . $this->get_startAmountUnit() . ", " .
			"currentAmount: " . $this->get_currentAmount() . ", " .
			"currentAmountUnit: " . $this->get_currentAmountUnit() . ", " .
			"fermentationPSI: " . $this->get_fermentationPSI() . ", " .
			"fermentationPSIUnit: " . $this->get_fermentationPSIUnit() . ", " .
			"keggingTemp: " . $this->get_keggingTemp() . ", " .
			"keggingTempUnit: " . $this->get_keggingTempUnit() . ", " .
			"hasContinuousLid: " . $this->get_hasContinuousLid() . ", " .
			"createdDate: new Date('" . $this->get_createdDate() . "'), " .
			"modifiedDate: new Date('" . $this->get_modifiedDate() . "') " .  
		"}";
	}
}