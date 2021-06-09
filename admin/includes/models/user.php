<?php
require_once __DIR__.'/../functions.php';

class User  
{  
	private $_id;  
	private $_username;
	private $_password;
	private $_active;
	private $_namefirst;
	private $_namelast;
	private $_mugid;
	private $_email;
	private $_unTapAccessToken;
	private $_admin;
	private $_createdDate; 
	private $_modifiedDate; 

	public function __construct(){}

	public function get_id(){ return $this->_id; }
	public function set_id($_id){ $this->_id = $_id; }

	public function get_username(){ return $this->_username; }
	public function set_username($_username){ $this->_username = $_username; }

	public function get_password(){ return $this->_password; }
	public function set_password($_password){ $this->_password = $_password; }

	public function get_active(){ return $this->_active; }
	public function set_active($_active){ $this->_active = $_active; }

	public function get_namefirst(){ return $this->_namefirst; }
	public function set_namefirst($_namefirst){ $this->_namefirst = $_namefirst; }

	public function get_namelast(){ return $this->_namelast; }
	public function set_namelast($_namelast){ $this->_namelast = $_namelast; }

	public function get_mugid(){ return $this->_mugid; }
	public function set_mugid($_mugid){ $this->_mugid = $_mugid; }

	public function get_email(){ return $this->_email; }
	public function set_email($_email){ $this->_email = $_email; }
	
	public function get_unTapAccessToken(){ return $this->_unTapAccessToken; }
	public function set_unTapAccessToken($_unTapAccessToken){ $this->_unTapAccessToken = $_unTapAccessToken; }

	public function get_isAdmin(){ return $this->_admin; }
	public function set_isAdmin($_admin){ $this->_admin = $_admin; }
	
    public function get_createdDate(){ return $this->_createdDate; }
	public function get_createdDateFormatted(){ return Manager::format_time($this->_createdDate); }
	public function set_createdDate($_createdDate){ $this->_createdDate = $_createdDate; }
	
	public function get_modifiedDate(){ return $this->_modifiedDate; }
	public function get_modifiedDateFormatted(){ return Manager::format_time($this->_modifiedDate); }
	public function set_modifiedDate($_modifiedDate){ $this->_modifiedDate = $_modifiedDate; }
	

	public function setFromArray($postArr)  
	{  
		if( isset($postArr['id']) )
			$this->set_id($postArr['id']);
		else
			$this->set_id(null);
			
		if( isset($postArr['username']) )
			$this->set_username($postArr['username']);
		else
			$this->set_username(null);
			   
		if( isset($postArr['password']) )
			$this->set_password($postArr['password']);
		else
			$this->set_password(null);
			 
		if( isset($postArr['active']) )
			$this->set_active($postArr['active']);
		else
			$this->set_active(0);
			
		if( isset($postArr['nameFirst']) )
			$this->set_namefirst($postArr['nameFirst']);
		else
			$this->set_namefirst(null);
			
		if( isset($postArr['nameLast']) )
			$this->set_namelast($postArr['nameLast']);
		else
			$this->set_namelast(null);
				 
		if( isset($postArr['mugId']) )
			$this->set_mugid($postArr['mugId']);
		else
			$this->set_mugid(null);
			
		if( isset($postArr['email']) )
			$this->set_email($postArr['email']);
		else
			$this->set_email(null);
			
		if( isset($postArr['unTapAccessToken']) )
			$this->set_unTapAccessToken($postArr['unTapAccessToken']);
		else
			$this->set_unTapAccessToken(null);
			
		if( isset($postArr['isAdmin']) )
			$this->set_isAdmin($postArr['isAdmin']);
		else
			$this->set_isAdmin(0);

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
			"username: '" . encode($this->get_username()) . "', " .
			"password: '" . encode($this->get_password()) . "', " .
			"namefirst: '" . encode($this->get_namefirst()) . "', " .
			"namelast: '" . encode($this->get_namelast()) . "', " .
			"active: " . $this->get_active() . ", " .
			"mugid: " . $this->get_mugid() . ", " .
			"email: '" . encode($this->get_email()) . "', " .
			"unTapAccessToken: '" . encode($this->get_unTapAccessToken()) . "', " .
			"isadmin: " . $this->get_isAdmin() . ", " .
			"createdDate: new Date('" . $this->get_createdDate() . "'), " .
			"modifiedDate: new Date('" . $this->get_modifiedDate() . "') " . 

		"}";
	}
}
