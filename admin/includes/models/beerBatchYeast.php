<?php
require_once __DIR__.'/../functions.php';
require_once __DIR__.'/../models/yeast.php';

class BeerBatchYeast 
{
    private $_id;  
    private $_beerBatchID;
    private $_yeastsID;
    private $_amount;
    private $_yeast;

    public function __construct(){
        $this->_yeast = new Yeast();
    }
    
    public function get_id(){ return $this->_id; }
    public function set_id($_id){ $this->_id = $_id; }

	public function get_beerBatchID(){ return $this->_beerBatchID; }
	public function set_beerBatchID($_beerBatchID){ $this->_beerBatchID = $_beerBatchID; }

	public function get_yeastsID(){ return $this->_yeastsID; }
	public function set_yeastsID($_yeastsID){ $this->_yeastsID = $_yeastsID; }
	
	public function get_amount(){ return $this->_amount; }
	public function set_amount($_amount){ $this->_amount = $_amount; }
	
	public function get_yeast(){ return $this->_yeast; }
	public function set_yeast($_yeast){ $this->_yeast = $_yeast; if($_yeast)$this->set_yeastsID($_yeast->get_id()); }
	
    public function setFromArray($postArr)  
    {
        if( isset($postArr['id']) )
            $this->set_id($postArr['id']);
        else
            $this->set_id(null);
        
		if( isset($postArr['beerBatchId']) )
			$this->set_beerBatchID($postArr['beerBatchId']);
		else
			$this->set_beerBatchID(null);
			
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
	
	function toJson(){ return json_encode(get_object_vars($this)); }
}