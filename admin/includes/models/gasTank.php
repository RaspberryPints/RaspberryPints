<?php
class GasTank
{  
    private $_id;
    private $_label;
    private $_gasTankTypeId;
    private $_make;
    private $_model;
    private $_serial;
    private $_notes;
    private $_gasTankStatusCode;
    private $_weight;
    private $_weightUnit;
    private $_emptyWeight;
    private $_emptyWeightUnit;
    private $_maxWeight;
    private $_maxWeightUnit;
    private $_maxVolume;
    private $_maxVolumeUnit;
    private $_startAmount;
    private $_startAmountUnit;
    private $_currentAmount;
    private $_currentAmountUnit;
    private $_active;
    private $_loadCellCmdPin;
    private $_loadCellRspPin;
    private $_loadCellScaleRatio;
    private $_loadCellTareOffset;
    private $_loadCellUnit;
    private $_loadCellTareDate;
    private $_createdDate;
    private $_modifiedDate;
    
    
	public function __construct(){}

	public function get_id(){ return $this->_id; }
	public function set_id($_id){ $this->_id = $_id; }

	public function get_label(){ return $this->_label; }
	public function set_label($_label){ $this->_label = $_label; }

	public function get_gasTankTypeId(){ return $this->_gasTankTypeId; }
	public function set_gasTankTypeId($_gasTankTypeId){ $this->_gasTankTypeId = $_gasTankTypeId; }
	
	public function get_make(){ return $this->_make; }
	public function set_make($_make){ $this->_make = $_make; }

	public function get_model(){ return $this->_model; }
	public function set_model($_model){ $this->_model = $_model; }

	public function get_serial(){ return $this->_serial; }
	public function set_serial($_serial){ $this->_serial = $_serial; }

	public function get_notes(){ return $this->_notes; }
	public function set_notes($_notes){ $this->_notes = $_notes; }

	public function get_gasTankStatusCode(){ return $this->_gasTankStatusCode; }
	public function set_gasTankStatusCode($_gasTankStatusCode){ $this->_gasTankStatusCode = $_gasTankStatusCode; }
	
	public function get_weight(){ return $this->_weight; }
	public function set_weight($_weight){ 
	    $this->_weight = $_weight;
	    if($this->_emptyWeight > $this->_weight){ $this->_weight = $this->_emptyWeight; $this->_weightUnit = $this->_emptyWeightUnit;}
	}
	public function get_currentWeight(){ return $this->get_weight(); }
	public function set_currentWeight($_weight){ $this->set_weight($_weight); }
	
	public function get_weightUnit(){ return $this->_weightUnit; }
	public function set_weightUnit($_weightUnit){ $this->_weightUnit = $_weightUnit;	}
	public function get_currentWeightUnit(){ return $this->_weightUnit; }
	public function set_currentWeightUnit($_weightUnit){ $this->_weightUnit = $_weightUnit;	}

	public function get_emptyWeight(){ return $this->_emptyWeight; }
	public function set_emptyWeight($_emptyWeight){ 
	    $this->_emptyWeight = $_emptyWeight; 
	    if($this->_emptyWeight > $this->_weight) $this->_weight = $this->_emptyWeight;
	}
	
	public function get_emptyWeightUnit(){ return $this->_emptyWeightUnit; }
	public function set_emptyWeightUnit($_emptyWeightUnit){ $this->_emptyWeightUnit = $_emptyWeightUnit; }
	
	public function get_maxWeight(){ return $this->_maxWeight; }
	public function set_maxWeight($_maxWeight){ $this->_maxWeight = $_maxWeight; }
	
	public function get_maxWeightUnit(){ return $this->_maxWeightUnit; }
	public function set_maxWeightUnit($_maxWeightUnit){ $this->_maxWeightUnit = $_maxWeightUnit; }
	
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
	
	public function get_active(){ return $this->_active; }
	public function set_active($_active){ $this->_active = $_active; }
	
	public function get_loadCellCmdPin(){ return $this->_loadCellCmdPin; }
	public function set_loadCellCmdPin($_loadCellCmdPin){ $this->_loadCellCmdPin = $_loadCellCmdPin; }
	
	public function get_loadCellRspPin(){ return $this->_loadCellRspPin; }
	public function set_loadCellRspPin($_loadCellRspPin){ $this->_loadCellRspPin = $_loadCellRspPin; }
	
	public function get_loadCellScaleRatio(){ return $this->_loadCellScaleRatio; }
	public function set_loadCellScaleRatio($_loadCellScaleRatio){ $this->_loadCellScaleRatio = $_loadCellScaleRatio; }
	
	public function get_loadCellTareOffset(){ return $this->_loadCellTareOffset; }
	public function set_loadCellTareOffset($_loadCellTareOffset){ $this->_loadCellTareOffset = $_loadCellTareOffset; }
	
	public function get_loadCellUnit(){ return $this->_loadCellUnit; }
	public function set_loadCellUnit($_loadCellUnit){ $this->_loadCellUnit = $_loadCellUnit; }
	
	public function get_loadCellTareDate(){ return $this->_loadCellTareDate; }
	public function get_loadCellTareDateFormatted(){ return Manager::format_time($this->_loadCellTareDate); }
	public function set_loadCellTareDate($_loadCellTareDate){ $this->_loadCellTareDate = $_loadCellTareDate; }
	
    public function get_createdDate(){ return $this->_createdDate; }
	public function get_createdDateFormatted(){ return Manager::format_time($this->_createdDate); }
	public function set_createdDate($_createdDate){ $this->_createdDate = $_createdDate; }
	
	public function get_modifiedDate(){ return $this->_modifiedDate; }
	public function get_modifiedDateFormatted(){ return Manager::format_time($this->_modifiedDate); }
	public function set_modifiedDate($_modifiedDate){ $this->_modifiedDate = $_modifiedDate; }
	
	public function setFromArray($postArr)  
	{
	    if (isset($postArr['id']))
            $this->set_id($postArr['id']);
        else
            $this->set_id(null);
        if (isset($postArr['label']))
            $this->set_label($postArr['label']);
        else
            $this->set_label(null);
        if (isset($postArr['gasTankTypeId']))
            $this->set_gasTankTypeId($postArr['gasTankTypeId']);
        else
            $this->set_gasTankTypeId(null);
        if (isset($postArr['make']))
            $this->set_make($postArr['make']);
        else
            $this->set_make(null);
        if (isset($postArr['model']))
            $this->set_model($postArr['model']);
        else
            $this->set_model(null);
        if (isset($postArr['serial']))
            $this->set_serial($postArr['serial']);
        else
            $this->set_serial(null);
        if (isset($postArr['notes']))
            $this->set_notes($postArr['notes']);
        else
            $this->set_notes(null);
        if (isset($postArr['gasTankStatusCode']))
            $this->set_gasTankStatusCode($postArr['gasTankStatusCode']);
        else
            $this->set_gasTankStatusCode(null);
        if (isset($postArr['weight']))
            $this->set_weight($postArr['weight']);
        else
            $this->set_weight(null);
        if (isset($postArr['weightUnit']))
            $this->set_weightUnit($postArr['weightUnit']);
        else
            $this->set_weightUnit(null);
        if (isset($postArr['emptyWeight']))
            $this->set_emptyWeight($postArr['emptyWeight']);
        else
            $this->set_emptyWeight(null);
        if (isset($postArr['emptyWeightUnit']))
            $this->set_emptyWeightUnit($postArr['emptyWeightUnit']);
        else
            $this->set_emptyWeightUnit(null);
        if (isset($postArr['maxWeight']))
            $this->set_maxWeight($postArr['maxWeight']);
        else
            $this->set_maxWeight(null);
        if (isset($postArr['maxWeightUnit']))
            $this->set_maxWeightUnit($postArr['maxWeightUnit']);
        else
            $this->set_maxWeightUnit(null);
        if (isset($postArr['maxVolume']))
            $this->set_maxVolume($postArr['maxVolume']);
        else
            $this->set_maxVolume(null);
        if (isset($postArr['maxVolumeUnit']))
            $this->set_maxVolumeUnit($postArr['maxVolumeUnit']);
        else
            $this->set_maxVolumeUnit(null);
        if (isset($postArr['startAmount']))
            $this->set_startAmount($postArr['startAmount']);
        else
            $this->set_startAmount(null);
        if (isset($postArr['startAmountUnit']))
            $this->set_startAmountUnit($postArr['startAmountUnit']);
        else
            $this->set_startAmountUnit(null);
        if (isset($postArr['currentAmount']))
            $this->set_currentAmount($postArr['currentAmount']);
        else
            $this->set_currentAmount(null);
        if (isset($postArr['currentAmountUnit']))
            $this->set_currentAmountUnit($postArr['currentAmountUnit']);
        else
            $this->set_currentAmountUnit(null);
        if (isset($postArr['active']))
            $this->set_active($postArr['active']);
        else
            $this->set_active(null);
            
        if( isset($postArr['loadCellCmdPin']))
            $this->set_loadCellCmdPin($postArr['loadCellCmdPin']);
        else
            $this->set_loadCellCmdPin(null);

        if (isset($postArr['loadCellRspPin']))
            $this->set_loadCellRspPin($postArr['loadCellRspPin']);
        else
            $this->set_loadCellRspPin(null);

        if (isset($postArr['loadCellScaleRatio']))
            $this->set_loadCellScaleRatio($postArr['loadCellScaleRatio']);
        else
            $this->set_loadCellScaleRatio(null);

        if (isset($postArr['loadCellTareOffset']))
            $this->set_loadCellTareOffset($postArr['loadCellTareOffset']);
        else
            $this->set_loadCellTareOffset(null);

        if (isset($postArr['loadCellUnit']))
            $this->set_loadCellUnit($postArr['loadCellUnit']);
        else
            $this->set_loadCellUnit(null);

        if (isset($postArr['loadCellTareDate']))
            $this->set_loadCellTareDate($postArr['loadCellTareDate']);
        else
            $this->set_loadCellTareDate(null);
                                                            
        if (isset($postArr['createdDate']))
            $this->set_createdDate($postArr['createdDate']);
        else
            $this->set_createdDate(null);
        if (isset($postArr['modifiedDate']))
            $this->set_modifiedDate($postArr['modifiedDate']);
        else
            $this->set_modifiedDate(null);
	    
	}
	
	function toJson(){return json_encode(get_object_vars($this));}
}