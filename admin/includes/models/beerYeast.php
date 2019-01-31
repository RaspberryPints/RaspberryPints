<?php
require_once __DIR__.'/../functions.php';
require_once __DIR__.'/../models/yeast.php';

class BeerYeast 
{
    private $_id;  
    private $_beerID;
    private $_yeastsID;
    private $_amount;
    private $_yeast;

    public function __construct(){
        $this->_yeast = new Yeast();
    }
    
    public function get_id(){ return $this->_id; }
    public function set_id($_id){ $this->_id = $_id; }

	public function get_beerID(){ return $this->_beerID; }
	public function set_beerID($_beerID){ $this->_beerID = $_beerID; }

	public function get_yeastsID(){ return $this->_yeastsID; }
	public function set_yeastsID($_yeastsID){ $this->_yeastsID = $_yeastsID; }
	
	public function get_amount(){ return $this->_amount; }
	public function set_amount($_amount){ $this->_amount = $_amount; }
	
	public function get_yeast(){ return $this->_yeast; }
	public function set_yeast($_yeast){ $this->_yeast = $_yeast; }
	
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
			
		if( isset($postArr['yeastsId']) )
			$this->set_yeastsID($postArr['yeastsId']);
		else
		    $this->set_yeastsID(null);
		
	    if( isset($postArr['amount']) )
	        $this->set_amount($postArr['amount']);
        else
            $this->set_amount(null);		
        
        $this->_yeast->setFromArray($postArr);
    }  
	
	function toJson(){
	    return "{" .
	   	    "id: " . $this->get_id() . ", " .
			"beerID: '" . encode($this->get_beerID()) . "', " .
			"yeastsID: " . $this->get_yeastsID() . " " . 
		"}";
	}
}