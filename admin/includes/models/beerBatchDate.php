<?php
require_once __DIR__.'/../functions.php';
require_once __DIR__.'/../models/yeast.php';

class BeerBatchDate
{
    private $_id;  
    private $_beerBatchID;
    private $_type;
    private $_createdDate; 

    public function __construct(){ }
    
    public function get_id(){ return $this->_id; }
    public function set_id($_id){ $this->_id = $_id; }

	public function get_beerBatchID(){ return $this->_beerBatchID; }
	public function set_beerBatchID($_beerBatchID){ $this->_beerBatchID = $_beerBatchID; }

	public function get_type(){ return $this->_type; }
	public function set_type($_type){ $this->_type = $_type; }
		
	public function get_createdDate(){ return $this->_createdDate; }
	public function set_createdDate($_createdDate){ $this->_createdDate = $_createdDate; }
	
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
			
		if( isset($postArr['type']) )
			$this->set_type($postArr['type']);
		else
		    $this->set_type(null);
		            
        if (isset($postArr['createdDate']))
            $this->set_createdDate($postArr['createdDate']);
        else
            $this->set_createdDate(null);
    }  
	
	function toJson(){ return json_encode(get_object_vars($this)); }
}