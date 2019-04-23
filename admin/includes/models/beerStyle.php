<?php
class BeerStyle
{  
	private $_id;  
	private $_name;
	private $_catNum;
	private $_category;
	private $_beerStyleList;
	private $_ogMin;
	private $_ogMax;
	private $_fgMin;
	private $_fgMax;
	private $_abvMin;
	private $_abvMax;
	private $_ibuMin;
	private $_ibuMax;
	private $_srmMin;
	private $_srmMax;
	
	private $_createdDate; 
	private $_modifiedDate; 

	public function __construct(){}

	public function get_id(){ return $this->_id; }
	public function set_id($_id){ $this->_id = $_id; }

	public function get_name(){ return $this->_name; }
	public function set_name($_name){ $this->_name = $_name; }

	public function get_catNum(){ return $this->_catNum; }
	public function set_catNum($_catNum){ $this->_catNum = $_catNum; }

	public function get_category(){ return $this->_category; }
	public function set_category($_category){ $this->_category = $_category; }

	public function get_beerStyleList(){ return $this->_beerStyleList; }
	public function set_beerStyleList($_beerStyleList){ $this->_beerStyleList = $_beerStyleList; }
	
	public function get_ogMin(){ return $this->_ogMin; }
    public function set_ogMin($_ogMin){ $this->_ogMin = $_ogMin; }
    
    public function get_ogMax(){ return $this->_ogMax; }
    public function set_ogMax($_ogMax){ $this->_ogMax = $_ogMax; }
    
    public function get_fgMin(){ return $this->_fgMin; }
    public function set_fgMin($_fgMin){ $this->_fgMin = $_fgMin; }
    
    public function get_fgMax(){ return $this->_fgMax; }
    public function set_fgMax($_fgMax){ $this->_fgMax = $_fgMax; }
    
    public function get_abvMin(){ return $this->_abvMin; }
    public function set_abvMin($_abvMin){ $this->_abvMin = $_abvMin; }
    
    public function get_abvMax(){ return $this->_abvMax; }
    public function set_abvMax($_abvMax){ $this->_abvMax = $_abvMax; }
    
    public function get_ibuMin(){ return $this->_ibuMin; }
    public function set_ibuMin($_ibuMin){ $this->_ibuMin = $_ibuMin; }
    
    public function get_ibuMax(){ return $this->_ibuMax; }
    public function set_ibuMax($_ibuMax){ $this->_ibuMax = $_ibuMax; }
    
    public function get_srmMin(){ return $this->_srmMin; }
    public function set_srmMin($_srmMin){ $this->_srmMin = $_srmMin; }
    
    public function get_srmMax(){ return $this->_srmMax; }
    public function set_srmMax($_srmMax){ $this->_srmMax = $_srmMax; }
    
	public function get_createdDate(){ return $this->_createdDate; }
	public function set_createdDate($_createdDate){ $this->_createdDate = $_createdDate; }

	public function get_modifiedDate(){ return $this->_modifiedDate; }
	public function set_modifiedDate($_modifiedDate){ $this->_modifiedDate = $_modifiedDate; }

	public function setFromArray($postArr)  
	{
		if( isset($postArr['id']) )
			$this->set_id($postArr['id']);
		else
			$this->set_id(null);
			
		if( isset($postArr['name']) )
			$this->set_name($postArr['name']);
		else if( isset($postArr['displayName']) )
			$this->set_name($postArr['displayName']);
		else
			$this->set_name(null);
			
		if( isset($postArr['catNum']) )
			$this->set_catNum($postArr['catNum']);
		else
			$this->set_catNum(null);
			
		if( isset($postArr['category']) )
			$this->set_category($postArr['category']);
		else
			$this->set_category(null);
			
		if( isset($postArr['beerStyleList']) )
			$this->set_beerStyleList($postArr['beerStyleList']);
		else
			$this->set_beerStyleList(null);
			
		if (isset($postArr['ogMin']))
            $this->set_ogMin($postArr['ogMin']);
        else
            $this->set_ogMin(null);
        
        if (isset($postArr['ogMax']))
            $this->set_ogMax($postArr['ogMax']);
        else
            $this->set_ogMax(null);
        
        if (isset($postArr['fgMin']))
            $this->set_fgMin($postArr['fgMin']);
        else
            $this->set_fgMin(null);
        
        if (isset($postArr['fgMax']))
            $this->set_fgMax($postArr['fgMax']);
        else
            $this->set_fgMax(null);
        
        if (isset($postArr['abvMin']))
            $this->set_abvMin($postArr['abvMin']);
        else
            $this->set_abvMin(null);
        
        if (isset($postArr['abvMax']))
            $this->set_abvMax($postArr['abvMax']);
        else
            $this->set_abvMax(null);
        
        if (isset($postArr['ibuMin']))
            $this->set_ibuMin($postArr['ibuMin']);
        else
            $this->set_ibuMin(null);
        
        if (isset($postArr['ibuMax']))
            $this->set_ibuMax($postArr['ibuMax']);
        else
            $this->set_ibuMax(null);
        
        if (isset($postArr['srmMin']))
            $this->set_srmMin($postArr['srmMin']);
        else
            $this->set_srmMin(null);
        
        if (isset($postArr['srmMax']))
            $this->set_srmMax($postArr['srmMax']);
        else
            $this->set_srmMax(null);
			                                                                                
		if( isset($postArr['createdDate']) )
			$this->set_createdDate($postArr['createdDate']);
		else
			$this->set_createdDate(null);
			
		if( isset($postArr['modifiedDate']) )
			$this->set_modifiedDate($postArr['modifiedDate']);
		else
			$this->set_modifiedDate(null);
	}
	
	function toJson(){
		return "{" . 
			"id: " . $this->get_id() . ", " .
			"name: '" . $this->get_name() . "', " .
			"catNum: '" . $this->get_catNum() . "', " .
			"category: '" . $this->get_category() . "', " .
			"beerStyleList: '" . $this->get_beerStyleList() . "', " .
			"ogMin: '" . $this->get_ogMin() . "', ".
			"ogMax: '" . $this->get_ogMax() . "', ".
			"fgMin: '" . $this->get_fgMin() . "', ".
			"fgMax: '" . $this->get_fgMax() . "', ".
			"abvMin: '" . $this->get_abvMin() . "', ".
			"abvMax: '" . $this->get_abvMax() . "', ".
			"ibuMin: '" . $this->get_ibuMin() . "', ".
			"ibuMax: '" . $this->get_ibuMax() . "', ".
			"srmMin: '" . $this->get_srmMin() . "', ".
			"srmMax: '" . $this->get_srmMax() . "', ".
			"createdDate: new Date('" . $this->get_createdDate() . "'), " .
			"modifiedDate: new Date('" . $this->get_modifiedDate() . "') " .  
		"}";
	}
}