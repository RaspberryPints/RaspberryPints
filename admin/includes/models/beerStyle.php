<?php
class BeerStyle
{  
	private $_id;  
	private $_name;
	private $_catNum;
	private $_category;
	private $_beerStyleList;
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
			"createdDate: new Date('" . $this->get_createdDate() . "'), " .
			"modifiedDate: new Date('" . $this->get_modifiedDate() . "') " .  
		"}";
	}
}