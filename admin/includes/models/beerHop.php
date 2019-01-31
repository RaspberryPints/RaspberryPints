<?php
require_once __DIR__.'/../functions.php';
require_once __DIR__.'/../models/hop.php';

class BeerHop
{
    private $_id;  
    private $_beerID;
    private $_hopsID;
    private $_amount;
    private $_time;
    private $_hop;
    
    public function __construct(){
        $this->_hop = new Hop();
    }
    
    public function get_id(){ return $this->_id; }
    public function set_id($_id){ $this->_id = $_id; }
    
    public function get_beerID(){ return $this->_beerID; }
    public function set_beerID($_beerID){ $this->_beerID = $_beerID; }
    
    public function get_hopsID(){ return $this->_hopsID; }
    public function set_hopsID($_hopsID){ $this->_hopsID = $_hopsID; }
    
    public function get_amount(){ return $this->_amount; }
    public function set_amount($_amount){ $this->_amount = $_amount; }
    
    public function get_time(){ return $this->_time; }
    public function set_time($_time){ $this->_time = $_time; }
    
    public function get_hop(){ return $this->_hop; }
    public function set_hop($_hop){ $this->_hop = $_hop; }
    
    public function setFromArray($postArr)
    {
        if( isset($postArr['id']) )
            $this->set_id($postArr['id']);
        else
            $this->set_id(null);
        
        if( isset($postArr['beerId']) )
            $this->set_beerID($postArr['beerId']);
        else
            $this->set_beerID(null);
            
        if( isset($postArr['hopsId']) )
            $this->set_hopsID($postArr['hopsId']);
        else
            $this->set_hopsID(null);
        
        if( isset($postArr['amount']) )
            $this->set_amount($postArr['amount']);
        else
            $this->set_amount(null);	
            
        if( isset($postArr['time']) )
            $this->set_time($postArr['time']);
        else
            $this->set_time(null);
        
        $this->_hop->setFromArray($postArr);
    }
    
    function toJson(){
        return "{" .
            "id: " . $this->get_id() . ", " .
            "beerID: '" . encode($this->get_beerID()) . "', " .
            "hopsID: " . $this->get_hopsID() . " " .
            "}";
    }
}