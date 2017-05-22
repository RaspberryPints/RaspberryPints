<?php
class Brewery
{
	private $_id;
	private $_name;
	private $_imageUrl;

	public function __construct(){}

	public function get_id(){ return $this->_id; }
	public function set_id($_id){ $this->_id = $_id; }

	public function get_name(){ return $this->_name; }
	public function set_name($_name){ $this->_name = $_name; }

	public function get_imageUrl(){ return $this->_imageUrl; }
	public function set_imageUrl($_imageUrl){ $this->_imageUrl = $_imageUrl; }

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

		if( isset($postArr['imageUrl']) )
			$this->set_imageUrl($postArr['imageUrl']);
		else
			$this->set_ImageUrl(null);
	}

	function toJson(){
		return "{" .
			"id: " . $this->get_id() . ", " .
			"name: '" . $this->get_name() . "', " .
			"imageUrl: '" . $this->get_imageUrl() . "', " .
		"}";
	}
}
