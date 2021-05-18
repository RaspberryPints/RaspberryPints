<?php
require_once __DIR__.'/../functions.php';

class Beer  
{  
    private $_id;
    private $_batchNumber;
	private $_name;
	private $_untID;
	private $_beerStyleId;
	private $_notes;
	private $_abv;
	private $_og;
	private $_ogUnit;
	private $_fg;  
	private $_fgUnit;  
	private $_srm;  
	private $_ibu;
	private $_rating;
	private $_active;
	private $_containerId;
	private $_createdDate; 
	private $_modifiedDate; 
	private $_breweryId;
	private $_lastBatchNumber;

	public function __construct(){}

	public function get_id(){ return $this->_id; }
	public function set_id($_id){ $this->_id = $_id; }
	
	//Placeholders so we dont need to check Type when listing beers
	public function get_beerId(){ return $this->_id; }
	public function set_beerId($_id){ $this->_id = $_id; }
	
	public function get_beerBatchId(){ return 0; }
	public function set_beerBatchId($_id){  }

	public function get_name(){ return $this->_name; }
	public function set_name($_name){ $this->_name = $_name; }
	public function get_displayName(){ return $this->_name; }

	public function get_untID(){return $this->_untID;}
	public function set_untID($_untID){ $this->_untID = $_untID; }

	public function get_beerStyleId(){ return $this->_beerStyleId; }
	public function set_beerStyleId($_beerStyleId){ $this->_beerStyleId = $_beerStyleId; }
	
	public function get_notes(){ return $this->_notes; }
	public function set_notes($_notes){ $this->_notes = $_notes; }
	
	public function get_abv(){ return $this->_abv; }
	public function set_abv($_abv){ $this->_abv = $_abv; }

	public function get_og(){ return $this->_og; } 
	public function set_og($_og){ $this->_og = $_og; }
	
	public function get_ogUnit(){ return $this->_ogUnit; } 
	public function set_ogUnit($_ogUnit){ $this->_ogUnit = $_ogUnit; }
	
	public function get_fg(){ return $this->_fg; }
	public function set_fg($_fg){ $this->_fg = $_fg;}
	
	public function get_fgUnit(){ return $this->_fgUnit; }
	public function set_fgUnit($_fgUnit){ $this->_fgUnit = $_fgUnit;}

	public function get_srm(){ return $this->_srm; }
	public function set_srm($_srm){ $this->_srm = $_srm; }

	public function get_ibu(){ return $this->_ibu; }
	public function set_ibu($_ibu){ $this->_ibu = $_ibu; }
	
	public function get_rating(){ return $this->_rating; }
	public function set_rating($_rating){ $this->_rating = $_rating; }
	
	public function get_active(){ return $this->_active; }
	public function set_active($_active){ $this->_active = $_active; }
	
	public function get_createdDate(){ return $this->_createdDate; }
	public function set_createdDate($_createdDate){ $this->_createdDate = $_createdDate; }
	
	public function get_modifiedDate(){ return $this->_modifiedDate; }
	public function set_modifiedDate($_modifiedDate){ $this->_modifiedDate = $_modifiedDate; }
	
	public function get_breweryId(){ return $this->_breweryId; }
	public function set_breweryId($_breweryId){ $this->_breweryId = $_breweryId; }
	
	public function get_containerId(){ return $this->_containerId; }
	public function set_containerId($_containerId){ $this->_containerId = $_containerId; }
	
	public function get_lastBatchNumber(){ return $this->_lastBatchNumber; }
	public function set_lastBatchNumber($_lastBatchNumber){ $this->_lastBatchNumber = $_lastBatchNumber; }
	
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
			
	    if( isset($postArr['beerStyleId']) )
				$this->set_beerStyleId($postArr['beerStyleId']);
	    else if( isset($postArr['beerStyleList']) )
	    {
	      if( isset($postArr['beerStyleId'.$postArr['beerStyleList']]) )
				$this->set_beerStyleId($postArr['beerStyleId'.$postArr['beerStyleList']]);		  		
	    }
	    else
			$this->set_beerStyleId(null);

		if( isset($postArr['untID']) )
			$this->set_untID($postArr['untID']);
		else
			$this->set_untID(null);
						
		if( isset($postArr['notes']) )
			$this->set_notes($postArr['notes']);
		else
			$this->set_notes(null);
			
		if( isset($postArr['rating']) )
			$this->set_rating($postArr['rating']);
		else
			$this->set_rating(null);
			
		if( isset($postArr['abv']) )
			$this->set_abv($postArr['abv']);
		else
			$this->set_abv(null);
			
		if( isset($postArr['ogAct']) )
			$this->set_og($postArr['ogAct']);
		else if( isset($postArr['ogEst']) )
			$this->set_og($postArr['ogEst']);
		else if( isset($postArr['og']) )
			$this->set_og($postArr['og']);
		else
			$this->set_og(null);
			
		if( isset($postArr['ogUnit']) )
		    $this->set_ogUnit($postArr['ogUnit']);
		else
		    $this->set_ogUnit(null);
			
		if( isset($postArr['fgAct']) )
			$this->set_fg($postArr['fgAct']);
		else if( isset($postArr['fgEst']) )
			$this->set_fg($postArr['fgEst']);
		else if( isset($postArr['fg']) )
			$this->set_fg($postArr['fg']);
		else
			$this->set_fg(null);
		
		if( isset($postArr['fgUnit']) )
		    $this->set_fgUnit($postArr['fgUnit']);
		else
		    $this->set_fgUnit(null);
			
		if( isset($postArr['srmAct']) )
			$this->set_srm($postArr['srmAct']);
		else if( isset($postArr['srmEst']) )
			$this->set_srm($postArr['srmEst']);
		else if( isset($postArr['srm']) )
			$this->set_srm($postArr['srm']);
		else
			$this->set_srm(null);
						
		if( isset($postArr['ibuAct']) )
			$this->set_ibu($postArr['ibuAct']);
		else if( isset($postArr['ibuEst']) )
			$this->set_ibu($postArr['ibuEst']);
		else if( isset($postArr['ibu']) )
			$this->set_ibu($postArr['ibu']);
		else
			$this->set_ibu(null);
			
		if( isset($postArr['active']) )
			$this->set_active($postArr['active']);
		else
			$this->set_active(null);
			
		if( isset($postArr['containerId']) )
		    $this->set_containerId($postArr['containerId']);
	    else
	        $this->set_containerId(null);
			        
			
		if( isset($postArr['createdDate']) )
			$this->set_createdDate($postArr['createdDate']);
		else
			$this->set_createdDate(null);
			
		if( isset($postArr['modifiedDate']) )
			$this->set_modifiedDate($postArr['modifiedDate']);
		else
			$this->set_modifiedDate(null);

		if( isset($postArr['breweryId']) ){
				$this->set_breweryId($postArr['breweryId']);
			}else{
				$this->set_breweryId(0);
			}
			
		if( isset($postArr['lastBatchNumber']) ){
		    $this->set_lastBatchNumber($postArr['lastBatchNumber']);
		}else{
		    $this->set_lastBatchNumber(0);
		}
	}  
	
	function toJson(){
		return "{" . 
			"id: " . $this->get_id() . ", " .
			"name: '" . encode($this->get_name()) . "', " .
			"untID: " . $this->get_untID() . ", " .
			"beerStyleId: " . $this->get_beerStyleId() . ", " .
			"notes: '" . encode($this->get_notes()) . "', " .
			"srm: '" . $this->get_srm() . "', " .
			"abv: '" . $this->get_abv() . "'," .
			"og: '" . $this->get_og() . "', " .
			"fg: '" . $this->get_fg() . "', " .
			"ibu: '" . $this->get_ibu() . "', " .
			"active: '" . $this->get_active() . "', " .
			"breweryId: " . $this->get_breweryId() . ", " .
			"createdDate: new Date('" . $this->get_createdDate() . "'), " .
			"modifiedDate: new Date('" . $this->get_modifiedDate() . "') " .  

		"}";
	}
}
