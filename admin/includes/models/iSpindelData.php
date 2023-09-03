<?php
require_once __DIR__.'/../functions.php';

class iSpindelData  
{  
    private $_id;
    private $_createdDate;
    private $_name;
    private $_iSpindelId;
    private $_angle;
    private $_temperature;
    private $_temperatureUnit;
    private $_battery;
    private $_resetFlag;
    private $_gravity;
    private $_gravityUnit;
    private $_userToken;
    private $_interval;
    private $_RSSI;
    private $_beerId;
    
	public function __construct(){}

	public function get_id(){ return $this->_id; }
    public function set_id($_id){ $this->_id = $_id; }
    
    public function get_createdDate(){ return $this->_createdDate; }
	public function get_createdDateFormatted(){ return Manager::format_time($this->_createdDate); }
    public function set_createdDate($_createdDate){ $this->_createdDate = $_createdDate; }
    
    public function get_name(){ return $this->_name; }
    public function set_name($_name){ $this->_name = $_name; }
    
    public function get_iSpindelId(){ return $this->_iSpindelId; }
    public function set_iSpindelId($_iSpindelId){ $this->_iSpindelId = $_iSpindelId; }
    
    public function get_angle(){ return $this->_angle; }
    public function set_angle($_angle){ $this->_angle = $_angle; }
    
    public function get_temperature(){ return $this->_temperature; }
    public function set_temperature($_temperature){ $this->_temperature = $_temperature; }
    
    public function get_temperatureUnit(){ return $this->_temperatureUnit; }
    public function set_temperatureUnit($_temperatureUnit){ $this->_temperatureUnit = $_temperatureUnit; }
    
    public function get_battery(){ return $this->_battery; }
    public function set_battery($_battery){ $this->_battery = $_battery; }
    
    public function get_resetFlag(){ return $this->_resetFlag; }
    public function set_resetFlag($_resetFlag){ $this->_resetFlag = $_resetFlag; }
    
    public function get_gravity(){ return $this->_gravity; }
    public function set_gravity($_gravity){ $this->_gravity = $_gravity; }
    
    public function get_gravityUnit(){ return $this->_gravityUnit; }
    public function set_gravityUnit($_gravityUnit){ $this->_gravityUnit = $_gravityUnit; }
    
    public function get_userToken(){ return $this->_userToken; }
    public function set_userToken($_userToken){ $this->_userToken = $_userToken; }
    
    public function get_interval(){ return $this->_interval; }
    public function set_interval($_interval){ $this->_interval = $_interval; }
    
    public function get_RSSI(){ return $this->_RSSI; }
    public function set_RSSI($_RSSI){ $this->_RSSI = $_RSSI; }
    
    public function get_beerId(){ return $this->_beerId; }
    public function set_beerId($_beerId){ $this->_beerId = $_beerId; }
    

	public function setFromArray($postArr)  
	{  
	    		if (isset($postArr['id']))
            $this->set_id($postArr['id']);
        else
            $this->set_id(null);
        if (isset($postArr['createdDate']))
            $this->set_createdDate($postArr['createdDate']);
        else
            $this->set_createdDate(null);
        if (isset($postArr['name']))
            $this->set_name($postArr['name']);
        else
            $this->set_name(null);
        if (isset($postArr['iSpindelId']))
            $this->set_iSpindelId($postArr['iSpindelId']);
        else
            $this->set_iSpindelId(null);
        if (isset($postArr['angle']))
            $this->set_angle($postArr['angle']);
        else
            $this->set_angle(null);
        if (isset($postArr['temperature']))
            $this->set_temperature($postArr['temperature']);
        else
            $this->set_temperature(null);
        if (isset($postArr['battery']))
            $this->set_battery($postArr['battery']);
        else
            $this->set_battery(null);
        if (isset($postArr['temperatureUnit']))
            $this->set_temperatureUnit($postArr['temperatureUnit']);
        else
            $this->set_temperatureUnit(null);
        if (isset($postArr['battery']))
            $this->set_battery($postArr['battery']);
        else
            $this->set_battery(null);
        
        if (isset($postArr['resetFlag']))
            $this->set_resetFlag($postArr['resetFlag']);
        else
            $this->set_resetFlag(null);
        if (isset($postArr['gravity']))
            $this->set_gravity($postArr['gravity']);
        else
            $this->set_gravity(null);
            if (isset($postArr['gravityUnit']))
                $this->set_gravityUnit($postArr['gravityUnit']);
                else
                    $this->set_gravityUnit(null);
        if (isset($postArr['userToken']))
            $this->set_userToken($postArr['userToken']);
        else
            $this->set_userToken(null);
        if (isset($postArr['interval']))
            $this->set_interval($postArr['interval']);
        else
            $this->set_interval(null);
        if (isset($postArr['RSSI']))
            $this->set_RSSI($postArr['RSSI']);
        else
            $this->set_RSSI(null);
        if (isset($postArr['beerId']) )			
            $this->set_beerId($postArr['beerId']);		
        else
            $this->set_beerId(null);
	    
	}  
	
	function toJson(){return json_encode(get_object_vars($this));}
}
