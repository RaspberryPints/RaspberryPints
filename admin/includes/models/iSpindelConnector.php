<?php
require_once __DIR__.'/../functions.php';

class iSpindelConnector
{  
    private $_id;
    private $_address;
    private $_port;
    private $_allowedConnections = 5;
    private $_createdDate;
    private $_modifiedDate;
    
	public function __construct(){}

	public function get_id(){ return $this->_id; }
    public function set_id($_id){ $this->_id = $_id; }
    
    public function get_address(){ return $this->_address; }
    public function set_address($_address){ $this->_address = $_address; }
    
    public function get_port(){ return $this->_port; }
    public function set_port($_port){ $this->_port = $_port; }
    
    public function get_allowedConnections(){ return $this->_allowedConnections; }
    public function set_allowedConnections($_allowedConnections){ $this->_allowedConnections = $_allowedConnections; }
    
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
        if (isset($postArr['address']))
            $this->set_address($postArr['address']);
        else
            $this->set_address(null);
        if (isset($postArr['port']))
            $this->set_port($postArr['port']);
        else
            $this->set_port(null);
        if (isset($postArr['allowedConnections']))
            $this->set_allowedConnections($postArr['allowedConnections']);
        else
            $this->set_allowedConnections(5);
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
		return "{" . 
	  		"id: '" . $this->get_id() . "'," .
	  		"address: '" . $this->get_address() . "'," .
	  		"port: '" . $this->get_port() . "'," .
	  		"allowedConnections: '" . $this->get_allowedConnections() . "'," .
	  		"createdDate: '" . $this->get_createdDate() . "'," .
	  		"modifiedDate: '" . $this->get_modifiedDate() . "'" .
		"}";
	}
}
