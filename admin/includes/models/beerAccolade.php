<?php
require_once __DIR__.'/../functions.php';
require_once __DIR__.'/../models/accolade.php';

class BeerAccolade
{
    private $_id;  
    private $_beerID;
    private $_accoladeID;
    private $_amount;
    private $_accolade;
    
    public function __construct(){
        $this->_accolade = new Accolade();
    }
    
    public function get_id(){ return $this->_id; }
    public function set_id($_id){ $this->_id = $_id; }
    
    public function get_beerID(){ return $this->_beerID; }
    public function set_beerID($_beerID){ $this->_beerID = $_beerID; }
    
    public function get_accoladeID(){ return $this->_accoladeID; }
    public function set_accoladeID($_accoladeID){ $this->_accoladeID = $_accoladeID; }
    
    public function get_amount(){ return $this->_amount; }
    public function set_amount($_amount){ $this->_amount = $_amount; }
    
    public function get_accolade(){ return $this->_accolade; }
    public function set_accolade($_accolade){ $this->_accolade = $_accolade; if($_accolade)$this->set_accoladeID($_accolade->get_id()); }
    
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
                
        if( isset($postArr['accoladeId']) )
            $this->set_accoladeID($postArr['accoladeId']);
        else
            $this->set_accoladeID(null);
        
        if( isset($postArr['amount']) )
            $this->set_amount($postArr['amount']);
        else
            $this->set_amount(null);
        
        $this->_accolade->setFromArray($postArr);
    }
    
    function toJson(){
        return "{" .
            "id: " . $this->get_id() . ", " .
            "beerID: '" . encode($this->get_beerID()) . "', " .
            "accolade: " . $this->get_accoladesID() . " " .
            "}";
    }
}