<?php
class MotionDetector
{
    private $_id;  
	private $_name;
	private $_pin;
	private $_type;
	private $_priority;
	private $_ledPin;
	private $_soundFile;
	private $_mqttCommand;
	private $_mqttEvent;
	private $_mqttUser;
	private $_mqttPass;
	private $_mqttHost;
	private $_mqttPort;
	private $_mqttInterval;

	public function __construct(){}
	
	public function get_id(){ return $this->_id; }
	public function set_id($_id){ $this->_id = $_id; }
	
	public function get_name(){ return $this->_name; }
	public function set_name($_name){ $this->_name = $_name; }

	public function get_pin(){ return $this->_pin; }
	public function set_pin($_pin){ $this->_pin = $_pin; }
	
	public function get_type(){ return $this->_type; }
	public function set_type($_type){ $this->_type = $_type; }
	
	public function get_priority(){ return $this->_priority; }
	public function set_priority($_priority){ $this->_priority = $_priority; }
	
	public function get_ledPin(){ return $this->_ledPin; }
	public function set_ledPin($_ledPin){ $this->_ledPin = $_ledPin; }
	
	public function get_soundFile(){ return $this->_soundFile; }
	public function set_soundFile($_soundFile){ $this->_soundFile = $_soundFile; }
	
	public function get_mqttCommand(){ return $this->_mqttCommand; }
	public function set_mqttCommand($_mqttCommand){ $this->_mqttCommand = $_mqttCommand; }
	
	public function get_mqttEvent(){ return $this->_mqttEvent; }
	public function set_mqttEvent($_mqttEvent){ $this->_mqttEvent = $_mqttEvent; }
	
	public function get_mqttUser(){ return $this->_mqttUser; }
	public function set_mqttUser($_mqttUser){ $this->_mqttUser = $_mqttUser; }
	
	public function get_mqttPass(){ return $this->_mqttPass; }
	public function set_mqttPass($_mqttPass){ $this->_mqttPass = $_mqttPass; }
	
	public function get_mqttHost(){ return $this->_mqttHost; }
	public function set_mqttHost($_mqttHost){ $this->_mqttHost = $_mqttHost; }
	
	public function get_mqttPort(){ return $this->_mqttPort; }
	public function set_mqttPort($_mqttPort){ $this->_mqttPort = $_mqttPort; }
	
	public function get_mqttInterval(){ return $this->_mqttInterval?$this->_mqttInterval:100; }
	public function set_mqttInterval($_mqttInterval){ $this->_mqttInterval = $_mqttInterval; }
	
	public function setFromArray($postArr)
	{
	    if( isset($postArr['id']) )
	        $this->set_id($postArr['id']);
	        else
	            $this->set_id(null);
	        
		if( isset($postArr['name']) )
			$this->set_name($postArr['name']);
		else
			$this->set_name(null);

		if( isset($postArr['pin']) )
			$this->set_pin($postArr['pin']);
		else
			$this->set_pin(null);
		
		if( isset($postArr['type']) )
			$this->set_type($postArr['type']);
		else
			$this->set_type(null);
		
		if( isset($postArr['priority']) )
			$this->set_priority($postArr['priority']);
		else
			$this->set_priority(null);

        if (isset($postArr['ledPin']))
            $this->set_ledPin($postArr['ledPin']);
        else
            $this->set_ledPin(null);
        
        if (isset($postArr['soundFile']))
            $this->set_soundFile($postArr['soundFile']);
        else
            $this->set_soundFile(null);
        
        if (isset($postArr['mqttCommand']))
            $this->set_mqttCommand($postArr['mqttCommand']);
        else
            $this->set_mqttCommand(null);
        
        if (isset($postArr['mqttEvent']))
            $this->set_mqttEvent($postArr['mqttEvent']);
        else
            $this->set_mqttEvent(null);
        
        if (isset($postArr['mqttUser']))
            $this->set_mqttUser($postArr['mqttUser']);
        else
            $this->set_mqttUser(null);
        
        if (isset($postArr['mqttPass']))
            $this->set_mqttPass($postArr['mqttPass']);
        else
            $this->set_mqttPass(null);
        
        if (isset($postArr['mqttHost']))
            $this->set_mqttHost($postArr['mqttHost']);
        else
            $this->set_mqttHost(null);
        
        if (isset($postArr['mqttPort']))
            $this->set_mqttPort($postArr['mqttPort']);
        else
            $this->set_mqttPort(null);
        
        if (isset($postArr['mqttInterval']) )			
            $this->set_mqttInterval($postArr['mqttInterval']);
        else			
            $this->set_mqttInterval(null);
			
	}
	
	function toJson(){return json_encode(get_object_vars($this));}
}
