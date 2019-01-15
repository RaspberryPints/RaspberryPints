<?php
require_once __DIR__.'/../functions.php';

class IoPin
{  
	private $_shield;  
	private $_pin;
	private $_displayPin;
	private $_name;
	private $_notes;
	private $_col;
	private $_row;
	private $_rgb;
	private $_pinSide;
	private $_hardware;
	
	public function __construct(){}
	
	public function get_id(){ return $this->_shield.$this->_pin; }
	
	public function get_shield(){ return $this->_shield; }
	public function set_shield($_shield){ $this->_shield = $_shield; }

	public function get_pin(){return $this->_pin;}
	public function set_pin($_pin){ $this->_pin = $_pin; }
	
	public function get_displayPin(){return $this->_displayPin;}
	public function set_displayPin($_displayPin){ $this->_displayPin = $_displayPin; }
	
	public function get_name(){ return $this->_name; }
	public function set_name($_name){ $this->_name = $_name; }

	public function get_notes(){ return $this->_notes; }
	public function set_notes($_notes){ $this->_notes = $_notes; }
	
	public function get_col(){ return $this->_col; }
	public function set_col($_col){ $this->_col = $_col; }
	
	public function get_row(){ return $this->_row; }
	public function set_row($_row){ $this->_row = $_row; }
	
	public function get_rgb(){ return $this->_rgb; }
	public function set_rgb($_rgb){ $this->_rgb = $_rgb; }
	
	public function get_pinSide(){return $this->_pinSide;}
	public function set_pinSide($_pinSide){ $this->_pinSide = $_pinSide; }
	
	public function get_hardware(){ return $this->_hardware; }
	public function set_hardware($_hardware){ $this->_hardware = $_hardware; }

	public function setFromArray($postArr)  
	{  
		if( isset($postArr['shield']) )
			$this->set_shield($postArr['shield']);
		else
			$this->set_shield(null);
			
		if (isset($postArr['pin']))
		    $this->set_pin($postArr['pin']);
	    else
	        $this->set_pin(null);
			        
		if (isset($postArr['displayPin']))
		    $this->set_displayPin($postArr['displayPin']);
	    else
	        $this->set_displayPin(null);
	    
		if( isset($postArr['name']) )
			$this->set_name($postArr['name']);
		else
			$this->set_name(null);
		
		if( isset($postArr['notes']) )
			$this->set_notes($postArr['notes']);
		else
			$this->set_notes(null);
	
		if( isset($postArr['col']) )
		    $this->set_col($postArr['col']);
	    else
	        $this->set_col(null);
    
        if( isset($postArr['row']) )
            $this->set_row($postArr['row']);
        else
            $this->set_row(null);
            
        if( isset($postArr['rgb']) )
            $this->set_rgb($postArr['rgb']);
        else
            $this->set_rgb(null);
                
        if( isset($postArr['pinSide']) )
            $this->set_pinSide($postArr['pinSide']);
        else
            $this->set_pinSide(null);
        
        if( isset($postArr['hardware']) )
            $this->set_hardware($postArr['hardware']);
        else
            $this->set_hardware(null);
	                
	}  
	
	function toJson(){
		return "{" . 
			"shield: " . $this->get_shield() . ", " .
			"pin: " . $this->get_pin() . ", " .
			"displayPin: " . $this->get_displayPin() . ", " .
			"name: '" . encode($this->get_name()) . "', " .
			"notes: '" . encode($this->get_notes()) . "', " .
			"hardware: '" . $this->get_hardware() . "', " .
			"col: " . $this->get_col() . ", " .
			"row: '" . encode($this->get_row()) . "', " .
			"rgb: '" . encode($this->get_rgb()) . "', " .
			"pinSide: '" . encode($this->get_pinSide()) . "', " .
		"}";
	}
	
	static function cmpShieldRow($a, $b){
	    $cmp = strcmp($a->get_shield(), $b->get_shield());
	    if($cmp == 0){
	        $cmp =  intval($a->get_row()) - intval($b->get_row());
	    }
	    if($cmp == 0){
	        $cmp =  intval($a->get_col()) - intval($b->get_col());
	    }
	    return $cmp;
	}
}
