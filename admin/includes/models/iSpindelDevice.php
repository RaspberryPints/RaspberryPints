<?php
require_once __DIR__.'/../functions.php';

class iSpindelDevice  
{  
    private $_iSpindelId;
    private $_name;
    private $_active;
    private $_beerId;
    private $_beerBatchId;
    private $_const1;
    private $_const2;
    private $_const3;
    private $_interval;
    private $_token;
    private $_polynomial;
    private $_sent;
    private $_remoteConfigEnabled;
    private $_sqlEnabled;
    private $_csvEnabled;
    private $_csvOutpath;
    private $_csvDelimiter;
    private $_csvNewLine;
    private $_csvIncludeDateTime;
    private $_unidotsEnabled;
    private $_unidotsUseiSpindelToken;
    private $_unidotsToken;
    private $_forwardEnabled;
    private $_forwardAddress;
    private $_forwardPort;
    private $_fermentTrackEnabled;
    private $_fermentTrackAddress;
    private $_fermentTrackPort;
    private $_fermentTrackUseiSpindelToken;
    private $_fermentTrackToken;
    private $_brewPiLessEnabled;
    private $_brewPiLessAddress;
    private $_craftBeerPiEnabled;
    private $_craftBeerPiAddress;
    private $_craftBeerPiSendAngle;
    private $_brewSpyEnabled;
    private $_brewSpyAddress;
    private $_brewSpyPort;
    private $_brewSpyUseiSpindelToken;
    private $_brewSpyToken;
    private $_brewFatherEnabled;
    private $_brewFatherAddress;
    private $_brewFatherPort;
    private $_brewFatherUseiSpindelToken;
    private $_brewFatherToken;
    private $_brewFatherSuffix;
    private $_currentTemperature;
    private $_currentTemperatureUnit;
    private $_currentGravity;
    private $_currentGravityUnit;
    private $_gravityUnit;
    private $_createdDate;
    private $_modifiedDate; 
    

	public function __construct(){}

	public function get_id(){ return $this->_iSpindelId; }
	public function set_id($_id){ $this->_iSpindelId = $_id; }
	
	public function get_iSpindelId(){ return $this->_iSpindelId; }
	public function set_iSpindelId($_id){ $this->_iSpindelId = $_id; }
	
	public function get_name(){ return $this->_name; }
	public function set_name($_name){ $this->_name = $_name; }
	
	public function get_active(){ return $this->_active; }
    public function set_active($_active){ $this->_active = $_active; }

    public function get_beerId(){ return $this->_beerId; }
    public function set_beerId($_beerId){ $this->_beerId = $_beerId; }
    
    public function get_beerBatchId(){ return $this->_beerBatchId; }
    public function set_beerBatchId($_beerBatchId){ $this->_beerBatchId = $_beerBatchId; }
    
    public function get_const1(){ return $this->_const1; }
    public function set_const1($_const1){ $this->_const1 = $_const1; }
    
    public function get_const2(){ return $this->_const2; }
    public function set_const2($_const2){ $this->_const2 = $_const2; }
    
    public function get_const3(){ return $this->_const3; }
    public function set_const3($_const3){ $this->_const3 = $_const3; }
    
    public function get_interval(){ return $this->_interval; }
    public function set_interval($_interval){ $this->_interval = $_interval; }
    
    public function get_token(){ return $this->_token; }
    public function set_token($_token){ $this->_token = $_token; }
    
    public function get_polynomial(){ return $this->_polynomial; }
    public function set_polynomial($_polynomial){ $this->_polynomial = $_polynomial; }
    
    public function get_sent(){ return $this->_sent; }
    public function set_sent($_sent){ $this->_sent = $_sent; }
    
    public function get_remoteConfigEnabled(){ return $this->_remoteConfigEnabled; }
    public function set_remoteConfigEnabled($_remoteConfigEnabled){ $this->_remoteConfigEnabled = $_remoteConfigEnabled; }
    
    public function get_sqlEnabled(){ return $this->_sqlEnabled; }
    public function set_sqlEnabled($_sqlEnabled){ $this->_sqlEnabled = $_sqlEnabled; }
    
    public function get_csvEnabled(){ return $this->_csvEnabled; }
    public function set_csvEnabled($_csvEnabled){ $this->_csvEnabled = $_csvEnabled; }
        
    public function get_csvOutpath(){ return $this->_csvOutpath; }
    public function set_csvOutpath($_csvOutpath){ $this->_csvOutpath = $_csvOutpath; }
    
    public function get_csvDelimiter(){ return $this->_csvDelimiter; }
    public function set_csvDelimiter($_csvDelimiter){ $this->_csvDelimiter = $_csvDelimiter; }
    
    public function get_csvNewLine(){ return $this->_csvNewLine; }
    public function set_csvNewLine($_csvNewLine){ $this->_csvNewLine = $_csvNewLine; }
    
    public function get_csvIncludeDateTime(){ return $this->_csvIncludeDateTime; }
    public function set_csvIncludeDateTime($_csvIncludeDateTime){ $this->_csvIncludeDateTime = $_csvIncludeDateTime; }
    
    public function get_unidotsEnabled(){ return $this->_unidotsEnabled; }
    public function set_unidotsEnabled($_unidotsEnabled){ $this->_unidotsEnabled = $_unidotsEnabled; }
    
    public function get_unidotsUseiSpindelToken(){ return $this->_unidotsUseiSpindelToken; }
    public function set_unidotsUseiSpindelToken($_unidotsUseiSpindelToken){ $this->_unidotsUseiSpindelToken = $_unidotsUseiSpindelToken; }
    
    public function get_unidotsToken(){ return $this->_unidotsToken; }
    public function set_unidotsToken($_unidotsToken){ $this->_unidotsToken = $_unidotsToken; }
    
    public function get_forwardEnabled(){ return $this->_forwardEnabled; }
    public function set_forwardEnabled($_forwardEnabled){ $this->_forwardEnabled = $_forwardEnabled; }
    
    public function get_forwardAddress(){ return $this->_forwardAddress; }
    public function set_forwardAddress($_forwardAddress){ $this->_forwardAddress = $_forwardAddress; }
    
    public function get_forwardPort(){ return $this->_forwardPort; }
    public function set_forwardPort($_forwardPort){ $this->_forwardPort = $_forwardPort; }
    
    public function get_fermentTrackEnabled(){ return $this->_fermentTrackEnabled; }
    public function set_fermentTrackEnabled($_fermentTrackEnabled){ $this->_fermentTrackEnabled = $_fermentTrackEnabled; }
    
    public function get_fermentTrackAddress(){ return $this->_fermentTrackAddress; }
    public function set_fermentTrackAddress($_fermentTrackAddress){ $this->_fermentTrackAddress = $_fermentTrackAddress; }
    
    public function get_fermentTrackPort(){ return $this->_fermentTrackPort; }
    public function set_fermentTrackPort($_fermentTrackPort){ $this->_fermentTrackPort = $_fermentTrackPort; }
    
    public function get_fermentTrackUseiSpindelToken(){ return $this->_fermentTrackUseiSpindelToken; }
    public function set_fermentTrackUseiSpindelToken($_fermentTrackUseiSpindelToken){ $this->_fermentTrackUseiSpindelToken = $_fermentTrackUseiSpindelToken; }
    
    public function get_fermentTrackToken(){ return $this->_fermentTrackToken; }
    public function set_fermentTrackToken($_fermentTrackToken){ $this->_fermentTrackToken = $_fermentTrackToken; }
    
    public function get_brewPiLessEnabled(){ return $this->_brewPiLessEnabled; }
    public function set_brewPiLessEnabled($_brewPiLessEnabled){ $this->_brewPiLessEnabled = $_brewPiLessEnabled; }
    
    public function get_brewPiLessAddress(){ return $this->_brewPiLessAddress; }
    public function set_brewPiLessAddress($_brewPiLessAddress){ $this->_brewPiLessAddress = $_brewPiLessAddress; }
    
    public function get_craftBeerPiEnabled(){ return $this->_craftBeerPiEnabled; }
    public function set_craftBeerPiEnabled($_craftBeerPiEnabled){ $this->_craftBeerPiEnabled = $_craftBeerPiEnabled; }
    
    public function get_craftBeerPiAddress(){ return $this->_craftBeerPiAddress; }
    public function set_craftBeerPiAddress($_craftBeerPiAddress){ $this->_craftBeerPiAddress = $_craftBeerPiAddress; }
    
    public function get_craftBeerPiSendAngle(){ return $this->_craftBeerPiSendAngle; }
    public function set_craftBeerPiSendAngle($_craftBeerPiSendAngle){ $this->_craftBeerPiSendAngle = $_craftBeerPiSendAngle; }
    
    public function get_brewSpyEnabled(){ return $this->_brewSpyEnabled; }
    public function set_brewSpyEnabled($_brewSpyEnabled){ $this->_brewSpyEnabled = $_brewSpyEnabled; }
    
    public function get_brewSpyAddress(){ return $this->_brewSpyAddress; }
    public function set_brewSpyAddress($_brewSpyAddress){ $this->_brewSpyAddress = $_brewSpyAddress; }
    
    public function get_brewSpyPort(){ return $this->_brewSpyPort; }
    public function set_brewSpyPort($_brewSpyPort){ $this->_brewSpyPort = $_brewSpyPort; }
    
    public function get_brewSpyUseiSpindelToken(){ return $this->_brewSpyUseiSpindelToken; }
    public function set_brewSpyUseiSpindelToken($_brewSpyUseiSpindelToken){ $this->_brewSpyUseiSpindelToken = $_brewSpyUseiSpindelToken; }
    
    public function get_brewSpyToken(){ return $this->_brewSpyToken; }
    public function set_brewSpyToken($_brewSpyToken){ $this->_brewSpyToken = $_brewSpyToken; }
    
    public function get_brewFatherEnabled(){ return $this->_brewFatherEnabled; }
    public function set_brewFatherEnabled($_brewFatherEnabled){ $this->_brewFatherEnabled = $_brewFatherEnabled; }
    
    public function get_brewFatherAddress(){ return $this->_brewFatherAddress; }
    public function set_brewFatherAddress($_brewFatherAddress){ $this->_brewFatherAddress = $_brewFatherAddress; }
    
    public function get_brewFatherPort(){ return $this->_brewFatherPort; }
    public function set_brewFatherPort($_brewFatherPort){ $this->_brewFatherPort = $_brewFatherPort; }
    
    public function get_brewFatherUseiSpindelToken(){ return $this->_brewFatherUseiSpindelToken; }
    public function set_brewFatherUseiSpindelToken($_brewFatherUseiSpindelToken){ $this->_brewFatherUseiSpindelToken = $_brewFatherUseiSpindelToken; }
    
    public function get_brewFatherToken(){ return $this->_brewFatherToken; }
    public function set_brewFatherToken($_brewFatherToken){ $this->_brewFatherToken = $_brewFatherToken; }
    
    public function get_brewFatherSuffix(){ return $this->_brewFatherSuffix; }
    public function set_brewFatherSuffix($_brewFatherSuffix){ $this->_brewFatherSuffix = $_brewFatherSuffix; }
    
    public function get_currentTemperature(){ return $this->_currentTemperature; }
    public function set_currentTemperature($_currentTemperature){ $this->_currentTemperature = $_currentTemperature; }
    
    public function get_currentTemperatureUnit(){ return $this->_currentTemperatureUnit; }
    public function set_currentTemperatureUnit($_currentTemperatureUnit){ $this->_currentTemperatureUnit = $_currentTemperatureUnit; }
    
    public function get_currentGravity(){ return $this->_currentGravity; }
    public function set_currentGravity($_currentGravity){ $this->_currentGravity = $_currentGravity; }
    
    public function get_currentGravityUnit(){ return $this->_currentGravityUnit; }
    public function set_currentGravityUnit($_currentGravityUnit){ $this->_currentGravityUnit = $_currentGravityUnit; }
    
    public function get_gravityUnit(){ return $this->_gravityUnit; }
    public function set_gravityUnit($_gravityUnit){ $this->_gravityUnit = $_gravityUnit; }
    
    public function get_createdDate(){ return $this->_createdDate; }
    public function set_createdDate($_createdDate){ $this->_createdDate = $_createdDate; }
    
    public function get_modifiedDate(){ return $this->_modifiedDate; }
    public function set_modifiedDate($_modifiedDate){ $this->_modifiedDate = $_modifiedDate; }

	public function setFromArray($postArr)  
	{  
		if( isset($postArr['id']) )
		    $this->set_id($postArr['id']);
		else if( isset($postArr['iSpindelId']) )
		        $this->set_id($postArr['iSpindelId']);
		else
			$this->set_id(null);
					
		if (isset($postArr['name']))
		    $this->set_name($postArr['name']);
        else
            $this->set_name(null);
        
		if (isset($postArr['active']))
            $this->set_active($postArr['active']);
        else
            $this->set_active(null);
        
        if (isset($postArr['beerId']))
            $this->set_beerId($postArr['beerId']);
        else
            $this->set_beerId(null);
        
        if (isset($postArr['beerBatchId']))
            $this->set_beerBatchId($postArr['beerBatchId']);
        else
            $this->set_beerBatchId(null);
        
        if (isset($postArr['const1']))
            $this->set_const1($postArr['const1']);
        else
            $this->set_const1(null);
        
        if (isset($postArr['const2']))
            $this->set_const2($postArr['const2']);
        else
            $this->set_const2(null);
        
        if (isset($postArr['const3']))
            $this->set_const3($postArr['const3']);
        else
            $this->set_const3(null);
        
        if (isset($postArr['interval']))
            $this->set_interval($postArr['interval']);
        else
            $this->set_interval(null);
        
        if (isset($postArr['token']))
            $this->set_token($postArr['token']);
        else
            $this->set_token(null);
        
        if (isset($postArr['polynomial']))
            $this->set_polynomial($postArr['polynomial']);
        else
            $this->set_polynomial(null);
        
        if (isset($postArr['sent']))
            $this->set_sent($postArr['sent']);
        else
            $this->set_sent(0);
        
        if (isset($postArr['remoteConfigEnabled']))
            $this->set_remoteConfigEnabled($postArr['remoteConfigEnabled']);
        else
            $this->set_remoteConfigEnabled(0);
        
        if (isset($postArr['sqlEnabled']))
            $this->set_sqlEnabled($postArr['sqlEnabled']);
        else
            $this->set_sqlEnabled(0);
        
        if (isset($postArr['csvEnabled']))
            $this->set_csvEnabled($postArr['csvEnabled']);
        else
            $this->set_csvEnabled(0);
                
        if (isset($postArr['csvOutpath']))
            $this->set_csvOutpath($postArr['csvOutpath']);
        else
            $this->set_csvOutpath(null);
        
        if (isset($postArr['csvDelimiter']))
            $this->set_csvDelimiter($postArr['csvDelimiter']);
        else
            $this->set_csvDelimiter(null);
        
        if (isset($postArr['csvNewLine']))
            $this->set_csvNewLine($postArr['csvNewLine']);
        else
            $this->set_csvNewLine(null);
        if (isset($postArr['csvIncludeDateTime']))
            $this->set_csvIncludeDateTime($postArr['csvIncludeDateTime']);
        else
            $this->set_csvIncludeDateTime(0);
        
        if (isset($postArr['unidotsEnabled']))
            $this->set_unidotsEnabled($postArr['unidotsEnabled']);
        else
            $this->set_unidotsEnabled(0);
        
        if (isset($postArr['unidotsUseiSpindelToken']))
            $this->set_unidotsUseiSpindelToken($postArr['unidotsUseiSpindelToken']);
        else
            $this->set_unidotsUseiSpindelToken(0);
        
        if (isset($postArr['unidotsToken']))
            $this->set_unidotsToken($postArr['unidotsToken']);
        else
            $this->set_unidotsToken(null);
        
        if (isset($postArr['forwardEnabled']))
            $this->set_forwardEnabled($postArr['forwardEnabled']);
        else
            $this->set_forwardEnabled(0);
        
        if (isset($postArr['forwardAddress']))
            $this->set_forwardAddress($postArr['forwardAddress']);
        else
            $this->set_forwardAddress(null);
        
        if (isset($postArr['forwardPort']))
            $this->set_forwardPort($postArr['forwardPort']);
        else
            $this->set_forwardPort(null);
        
        if (isset($postArr['fermentTrackEnabled']))
            $this->set_fermentTrackEnabled($postArr['fermentTrackEnabled']);
        else
            $this->set_fermentTrackEnabled(0);
        
        if (isset($postArr['fermentTrackAddress']))
            $this->set_fermentTrackAddress($postArr['fermentTrackAddress']);
        else
            $this->set_fermentTrackAddress(null);
        
        if (isset($postArr['fermentTrackPort']))
            $this->set_fermentTrackPort($postArr['fermentTrackPort']);
        else
            $this->set_fermentTrackPort(null);
        
        if (isset($postArr['fermentTrackUseiSpindelToken']))
            $this->set_fermentTrackUseiSpindelToken($postArr['fermentTrackUseiSpindelToken']);
        else
            $this->set_fermentTrackUseiSpindelToken(0);
        
        if (isset($postArr['fermentTrackToken']))
            $this->set_fermentTrackToken($postArr['fermentTrackToken']);
        else
            $this->set_fermentTrackToken(null);
        
        if (isset($postArr['brewPiLessEnabled']))
            $this->set_brewPiLessEnabled($postArr['brewPiLessEnabled']);
        else
            $this->set_brewPiLessEnabled(0);
        
        if (isset($postArr['brewPiLessAddress']))
            $this->set_brewPiLessAddress($postArr['brewPiLessAddress']);
        else
            $this->set_brewPiLessAddress(null);
        
        if (isset($postArr['craftBeerPiEnabled']))
            $this->set_craftBeerPiEnabled($postArr['craftBeerPiEnabled']);
        else
            $this->set_craftBeerPiEnabled(0);
        
        if (isset($postArr['craftBeerPiAddress']))
            $this->set_craftBeerPiAddress($postArr['craftBeerPiAddress']);
        else
            $this->set_craftBeerPiAddress(null);
        
        if (isset($postArr['craftBeerPiSendAngle']))
            $this->set_craftBeerPiSendAngle($postArr['craftBeerPiSendAngle']);
        else
            $this->set_craftBeerPiSendAngle(0);
        
        if (isset($postArr['brewSpyEnabled']))
            $this->set_brewSpyEnabled($postArr['brewSpyEnabled']);
        else
            $this->set_brewSpyEnabled(0);
        if (isset($postArr['brewSpyAddress']))
            $this->set_brewSpyAddress($postArr['brewSpyAddress']);
        else
            $this->set_brewSpyAddress(null);
        
        if (isset($postArr['brewSpyPort']))
            $this->set_brewSpyPort($postArr['brewSpyPort']);
        else
            $this->set_brewSpyPort(null);
        
        if (isset($postArr['brewSpyUseiSpindelToken']))
            $this->set_brewSpyUseiSpindelToken($postArr['brewSpyUseiSpindelToken']);
        else
            $this->set_brewSpyUseiSpindelToken(0);
        
        if (isset($postArr['brewSpyToken']))
            $this->set_brewSpyToken($postArr['brewSpyToken']);
        else
            $this->set_brewSpyToken(null);
        
        if (isset($postArr['brewFatherEnabled']))
            $this->set_brewFatherEnabled($postArr['brewFatherEnabled']);
        else
            $this->set_brewFatherEnabled(0);
        
        if (isset($postArr['brewFatherAddress']))
            $this->set_brewFatherAddress($postArr['brewFatherAddress']);
        else
            $this->set_brewFatherAddress(null);
        
        if (isset($postArr['brewFatherPort']))
            $this->set_brewFatherPort($postArr['brewFatherPort']);
        else
            $this->set_brewFatherPort(null);
        
        if (isset($postArr['brewFatherUseiSpindelToken']))
            $this->set_brewFatherUseiSpindelToken($postArr['brewFatherUseiSpindelToken']);
        else
            $this->set_brewFatherUseiSpindelToken(0);
        
        if (isset($postArr['brewFatherToken']))
            $this->set_brewFatherToken($postArr['brewFatherToken']);
        else
            $this->set_brewFatherToken(null);
        
        if (isset($postArr['brewFatherSuffix']))
            $this->set_brewFatherSuffix($postArr['brewFatherSuffix']);		
        else			
            $this->set_brewFatherSuffix(null);
        
        if (isset($postArr['currentTemperature']))
            $this->set_currentTemperature($postArr['currentTemperature']);		
        else			
            $this->set_currentTemperature(null);
            
        if (isset($postArr['currentTemperatureUnit']))
            $this->set_currentTemperatureUnit($postArr['currentTemperatureUnit']);
        else
            $this->set_currentTemperatureUnit(null);

        if (isset($postArr['currentGravity']))
            $this->set_currentGravity($postArr['currentGravity']);
        else
            $this->set_currentGravity(null);
        
        if (isset($postArr['currentGravityUnit']))
            $this->set_currentGravityUnit($postArr['currentGravityUnit']);		
        else			
            $this->set_currentGravityUnit(null);
            
        if (isset($postArr['gravityUnit']))
            $this->set_gravityUnit($postArr['gravityUnit']);
        else
            $this->set_gravityUnit(null);

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
