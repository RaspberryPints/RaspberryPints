<?php
require_once __DIR__.'/../functions.php';

class Beer
{
	private $_id;
	private $_name;
	private $_beerStyleId;
	private $_notes;
	private $_abv;
	private $_srm;
	private $_ibu;
	private $_active;
	private $_createdDate;
	private $_modifiedDate;

	public function __construct(){}

	public function get_id(){ return $this->_id; }
	public function set_id($_id){ $this->_id = $_id; }

	public function get_name(){ return $this->_name; }
	public function set_name($_name){ $this->_name = $_name; }

	public function get_beerStyleId(){ return $this->_beerStyleId; }
	public function set_beerStyleId($_beerStyleId){ $this->_beerStyleId = $_beerStyleId; }

	public function get_notes(){ return $this->_notes; }
	public function set_notes($_notes){ $this->_notes = $_notes; }

	public function get_abv(){ return $this->_abv; }
	public function set_abv($_abv){ $this->_abv = $_abv; }

	public function get_srm(){ return $this->_srm; }
	public function set_srm($_srm){ $this->_srm = $_srm; }

	public function get_ibu(){ return $this->_ibu; }
	public function set_ibu($_ibu){ $this->_ibu = $_ibu; }

	public function get_active(){ return $this->_active; }
	public function set_active($_active){ $this->_active = $_active; }

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
		else
			$this->set_name(null);

		if( isset($postArr['beerStyleId']) ){
			$this->set_beerStyleId($postArr['beerStyleId']);
		}else{
			$this->set_beerStyleId(null);
		}

		if( isset($postArr['notes']) )
			$this->set_notes($postArr['notes']);
		else
			$this->set_notes(null);

		if( isset($postArr['abv']) )
			$this->set_abv($postArr['abv']);
		else
			$this->set_abv(null);

		if( isset($postArr['srmAct']) )
			$this->set_srm($postArr['srmAct']);
		else if( isset($postArr['srmEst']) )
			$this->set_srm($postArr['srmEst']);
		else if( isset($postArr['srm']) )
			$this->set_srm($postArr['srm']);
		else
			$this->set_srm(null);

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
			"name: '" . encode($this->get_name()) . "', " .
			"beerStyleId: " . $this->get_beerStyleId() . ", " .
			"notes: '" . encode($this->get_notes()) . "', " .
			"srm: '" . $this->get_srm() . "', " .
			"abv: '" . $this->get_abv() . "'," .
			"ibu: '" . $this->get_ibu() . "', " .
			"active: '" . $this->get_active() . "', " .
			"createdDate: new Date('" . $this->get_createdDate() . "'), " .
			"modifiedDate: new Date('" . $this->get_modifiedDate() . "') " .
		"}";
	}
}
