<?php
require_once __DIR__.'/../functions.php';
require_once __DIR__.'/../models/fermentable.php';

class BeerFermentable
{
    private $_id;  
    private $_beerID;
    private $_fermentablesID;
    private $_amount;
    private $_time;
    private $_fermentable;
    
    public function __construct(){
        $this->_fermentable = new Fermentable();
    }
    
    public function get_id(){ return $this->_id; }
    public function set_id($_id){ $this->_id = $_id; }
    
    public function get_beerID(){ return $this->_beerID; }
    public function set_beerID($_beerID){ $this->_beerID = $_beerID; }
    
    public function get_fermentablesId(){ return $this->_fermentablesID; }
    public function set_fermentablesId($_fermentablesID){ $this->_fermentablesID = $_fermentablesID; }
    
    public function get_amount(){ return $this->_amount; }
    public function set_amount($_amount){ $this->_amount = $_amount; }
    
    public function get_time(){ return $this->_time; }
    public function set_time($_time){ $this->_time = $_time; }
    
    public function get_fermentable(){ return $this->_fermentable; }
    public function set_fermentable($_fermentable){ $this->_fermentable = $_fermentable; if($_fermentable)$this->set_fermentablesID($_fermentable->get_id()); }
    
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
        
        if( isset($postArr['fermentablesId']) )
            $this->set_fermentablesID($postArr['fermentablesId']);
        else
            $this->set_fermentablesID(null);
            
        if( isset($postArr['amount']) )
            $this->set_amount($postArr['amount']);
        else
            $this->set_amount(null);
            
        if( isset($postArr['time']) )
            $this->set_time($postArr['time']);
        else
            $this->set_time(null);
        
        $this->_fermentable->setFromArray($postArr);
    }
    
    function toJson(){
        return "{" .
            "id: " . $this->get_id() . ", " .
            "beerID: '" . encode($this->get_beerID()) . "', " .
            "fermentablesID: " . $this->get_fermentablesId() . " " .
            "}";
    }
}