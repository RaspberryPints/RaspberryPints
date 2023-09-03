<?php
require_once __DIR__.'/../functions.php';

class BeerBatch 
{  
    private $_id;
    private $_beerId;
    private $_beerName;
    private $_batchNumber;
    private $_name;
    private $_notes;
    private $_startAmount;
    private $_startAmountUnit;
    private $_currentAmount;
    private $_currentAmountUnit;
    private $_fermentationTempMin;
    private $_fermentationTempMinUnit;
    private $_fermentationTempSet;
    private $_fermentationTempSetUnit;
    private $_fermentationTempMax;
    private $_fermentationTempMaxUnit;
    private $_abv;
    private $_og;
    private $_ogUnit;
    private $_fg;
    private $_fgUnit;
    private $_srm;
    private $_ibu;
    private $_rating;
    private $_createdDate;
    private $_modifiedDate;
    
	public function __construct(){}

	public function get_id(){ return $this->_id; }
    public function set_id($_id){ $this->_id = $_id; }
    
    public function get_beerId(){ return $this->_beerId; }
    public function set_beerId($_beerId){ $this->_beerId = $_beerId; }
    
    //Placeholder so we dont need to check Type when listing beers
    public function get_beerBatchId(){ return $this->_id; }
    public function set_beerBatchId($_id){ $this->_id = $_id; }
    
    public function get_beerName(){ return $this->_beerName; }
    public function set_beerName($_beerName){ $this->_beerName = $_beerName; }
    
    public function get_batchNumber(){ return $this->_batchNumber; }
    public function set_batchNumber($_batchNumber){ $this->_batchNumber = $_batchNumber; }
    
    public function get_name(){ return $this->_name; }
    public function set_name($_name){ $this->_name = $_name; }
    public function get_displayName(){ return $this->_beerName.' Batch '.($this->_name?$this->_name:$this->_batchNumber); }
    
    public function get_notes(){ return $this->_notes; }
    public function set_notes($_notes){ $this->_notes = $_notes; }
    
    public function get_startAmount(){ return $this->_startAmount; }
    public function set_startAmount($_startAmount){ $this->_startAmount = $_startAmount; }
    
    public function get_startAmountUnit(){ return $this->_startAmountUnit; }
    public function set_startAmountUnit($_startAmountUnit){ $this->_startAmountUnit = $_startAmountUnit; }
    
    public function get_currentAmount(){ return $this->_currentAmount; }
    public function set_currentAmount($_currentAmount){ $this->_currentAmount = $_currentAmount; }
    
    public function get_currentAmountUnit(){ return $this->_currentAmountUnit; }
    public function set_currentAmountUnit($_currentAmountUnit){ $this->_currentAmountUnit = $_currentAmountUnit; }
    
    public function get_fermentationTempMin(){ return $this->_fermentationTempMin; }
    public function set_fermentationTempMin($_fermentationTempMin){ $this->_fermentationTempMin = $_fermentationTempMin; }
    
    public function get_fermentationTempMinUnit(){ return $this->_fermentationTempMinUnit; }
    public function set_fermentationTempMinUnit($_fermentationTempMinUnit){ $this->_fermentationTempMinUnit = $_fermentationTempMinUnit; }
    
    public function get_fermentationTempSet(){ return $this->_fermentationTempSet; }
    public function set_fermentationTempSet($_fermentationTempSet){ $this->_fermentationTempSet = $_fermentationTempSet; }
    
    public function get_fermentationTempSetUnit(){ return $this->_fermentationTempSetUnit; }
    public function set_fermentationTempSetUnit($_fermentationTempSetUnit){ $this->_fermentationTempSetUnit = $_fermentationTempSetUnit; }
    
    public function get_fermentationTempMax(){ return $this->_fermentationTempMax; }
    public function set_fermentationTempMax($_fermentationTempMax){ $this->_fermentationTempMax = $_fermentationTempMax; }
    
    public function get_fermentationTempMaxUnit(){ return $this->_fermentationTempMaxUnit; }
    public function set_fermentationTempMaxUnit($_fermentationTempMaxUnit){ $this->_fermentationTempMaxUnit = $_fermentationTempMaxUnit; }
    
    public function get_abv(){ return $this->_abv; }
    public function set_abv($_abv){ $this->_abv = $_abv; }
    
    public function get_og(){ return $this->_og; }
    public function set_og($_og){ $this->_og = $_og; }
    
    public function get_ogUnit(){ return $this->_ogUnit; }
    public function set_ogUnit($_ogUnit){ $this->_ogUnit = $_ogUnit; }
    
    public function get_fg(){ return $this->_fg; }
    public function set_fg($_fg){ $this->_fg = $_fg; }
    
    public function get_fgUnit(){ return $this->_fgUnit; }
    public function set_fgUnit($_fgUnit){ $this->_fgUnit = $_fgUnit; }
    
    public function get_srm(){ return $this->_srm; }
    public function set_srm($_srm){ $this->_srm = $_srm; }
    
    public function get_ibu(){ return $this->_ibu; }
    public function set_ibu($_ibu){ $this->_ibu = $_ibu; }
    
    public function get_rating(){ return $this->_rating; }
    public function set_rating($_rating){ $this->_rating = $_rating; }
    
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
        if (isset($postArr['beerId']))
            $this->set_beerId($postArr['beerId']);
        else
            $this->set_beerName(null);
        if (isset($postArr['beerName']))
            $this->set_beerName($postArr['beerName']);
        else
            $this->set_beerName(null);
        if (isset($postArr['batchNumber']))
            $this->set_batchNumber($postArr['batchNumber']);
        else
            $this->set_batchNumber(null);
        if (isset($postArr['name']))
            $this->set_name($postArr['name']);
        else
            $this->set_name(null);
        if (isset($postArr['notes']))
            $this->set_notes($postArr['notes']);
        else
            $this->set_notes(null);
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
            
        if (isset($postArr['fermentationTempMin']))
            $this->set_fermentationTempMin($postArr['fermentationTempMin']);
        else
            $this->set_fermentationTempMin(null);
        if (isset($postArr['fermentationTempMinUnit']))
            $this->set_fermentationTempMinUnit($postArr['fermentationTempMinUnit']);
        else
            $this->set_fermentationTempMinUnit(null);

        if (isset($postArr['fermentationTempSet']))
            $this->set_fermentationTempSet($postArr['fermentationTempSet']);
        else
            $this->set_fermentationTempSet(null);
        if (isset($postArr['fermentationTempSetUnit']))
            $this->set_fermentationTempSetUnit($postArr['fermentationTempSetUnit']);
        else
            $this->set_fermentationTempSetUnit(null);

        if (isset($postArr['fermentationTempMax']))
            $this->set_fermentationTempMax($postArr['fermentationTempMax']);
        else
            $this->set_fermentationTempMax(null);
        if (isset($postArr['fermentationTempMaxUnit']))
            $this->set_fermentationTempMaxUnit($postArr['fermentationTempMaxUnit']);
        else
            $this->set_fermentationTempMaxUnit(null);
        
        if (isset($postArr['abv']))
            $this->set_abv($postArr['abv']);
        else
            $this->set_abv(null);
        if (isset($postArr['og']))
            $this->set_og($postArr['og']);
        else
            $this->set_og(null);
        if (isset($postArr['ogUnit']))
            $this->set_ogUnit($postArr['ogUnit']);
        else
            $this->set_ogUnit(null);
        if (isset($postArr['fg']))
            $this->set_fg($postArr['fg']);
        else
            $this->set_fg(null);
        if (isset($postArr['fgUnit']))
            $this->set_fgUnit($postArr['fgUnit']);
        else
            $this->set_fgUnit(null);
        if (isset($postArr['srm']))
            $this->set_srm($postArr['srm']);
        else
            $this->set_srm(null);
        if (isset($postArr['ibu']))
            $this->set_ibu($postArr['ibu']);
        else
            $this->set_ibu(null);
        if (isset($postArr['rating']))
            $this->set_rating($postArr['rating']);
        else
            $this->set_rating(null);
        if (isset($postArr['createdDate']))
            $this->set_createdDate($postArr['createdDate']);
        else
            $this->set_createdDate(null);
        if (isset($postArr['modifiedDate']))
            $this->set_modifiedDate($postArr['modifiedDate']);
        else
            $this->set_modifiedDate(null);
	    
	}  
	
	function toJson(){
		return json_encode($this);
	}
}
