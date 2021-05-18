<?php
class Fermenter
{  
    private $_id;
    private $_label;
    private $_fermenterTypeId;
    private $_make;
    private $_model;
    private $_serial;
    private $_notes;
    private $_fermenterStatusCode;
    private $_weight;
    private $_weightUnit;
    private $_emptyWeight;
    private $_emptyWeightUnit;
    private $_maxVolume;
    private $_maxVolumeUnit;
    private $_startAmount;
    private $_startAmountUnit;
    private $_currentAmount;
    private $_currentAmountUnit;
    private $_fermentationPSI;
    private $_fermentationPSIUnit;
    private $_beerId;
    private $_beerBatchId;
    private $_active;
    private $_createdDate;
    private $_modifiedDate;
    
	public function __construct(){}

	public function get_id(){ return $this->_id; }
	public function set_id($_id){ $this->_id = $_id; }

	public function get_label(){ return $this->_label; }
	public function set_label($_label){ $this->_label = $_label; }

	public function get_fermenterTypeId(){ return $this->_fermenterTypeId; }
	public function set_fermenterTypeId($_fermenterTypeId){ $this->_fermenterTypeId = $_fermenterTypeId; }
	
	public function get_make(){ return $this->_make; }
	public function set_make($_make){ $this->_make = $_make; }

	public function get_model(){ return $this->_model; }
	public function set_model($_model){ $this->_model = $_model; }

	public function get_serial(){ return $this->_serial; }
	public function set_serial($_serial){ $this->_serial = $_serial; }

	public function get_notes(){ return $this->_notes; }
	public function set_notes($_notes){ $this->_notes = $_notes; }

	public function get_fermenterStatusCode(){ return $this->_fermenterStatusCode; }
	public function set_fermenterStatusCode($_fermenterStatusCode){ $this->_fermenterStatusCode = $_fermenterStatusCode; }
	
	public function get_weight(){ return $this->_weight; }
	public function set_weight($_weight){ 
	    $this->_weight = $_weight;
	    if($this->_emptyWeight > $this->_weight){ $this->_weight = $this->_emptyWeight; $this->_weightUnit = $this->_emptyWeightUnit;}
	}
	
	public function get_weightUnit(){ return $this->_weightUnit; }
	public function set_weightUnit($_weightUnit){ $this->_weightUnit = $_weightUnit;	}

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
	
	public function get_beerId(){ return $this->_beerId; }
	public function set_beerId($_beerId){ $this->_beerId = $_beerId; }

	public function get_beerBatchId(){ return $this->_beerBatchId; }
	public function set_beerBatchId($_beerBatchId){ $this->_beerBatchId = $_beerBatchId; }
	
	public function get_active(){ return $this->_active; }
	public function set_active($_active){ $this->_active = $_active; }
	
	public function get_createdDate(){ return $this->_createdDate; }
	public function set_createdDate($_createdDate){ $this->_createdDate = $_createdDate; }
	
	public function get_modifiedDate(){ return $this->_modifiedDate; }
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
        if (isset($postArr['fermenterTypeId']))
            $this->set_fermenterTypeId($postArr['fermenterTypeId']);
        else
            $this->set_fermenterTypeId(null);
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
        if (isset($postArr['fermenterStatusCode']))
            $this->set_fermenterStatusCode($postArr['fermenterStatusCode']);
        else
            $this->set_fermenterStatusCode(null);
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
        if (isset($postArr['fermentationPSI']))
            $this->set_fermentationPSI($postArr['fermentationPSI']);
        else
            $this->set_fermentationPSI(null);
        if (isset($postArr['fermentationPSIUnit']))
            $this->set_fermentationPSIUnit($postArr['fermentationPSIUnit']);
        else
            $this->set_fermentationPSIUnit(null);
        if (isset($postArr['beerId']))
            $this->set_beerId($postArr['beerId']);
        else
            $this->set_beerId(null);
        if (isset($postArr['beerBatchId']))
            $this->set_beerBatchId($postArr['beerBatchId']);
        else
            $this->set_beerBatchId(null);
        if (isset($postArr['active']))
            $this->set_active($postArr['active']);
        else
            $this->set_active(null);
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