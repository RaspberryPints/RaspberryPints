<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/user.php';

const USER_ID_SYSTEM = 0;
    
class UserManager extends Manager{
	
	protected function getPrimaryKeys(){
		return ["id"];
	}
	protected function getColumns(){
		return ["username", "active", "nameFirst", "nameLast", "mugId", "email", "isAdmin", "unTapAccessToken"];
	}
	protected function getTableName(){
		return "users";
	}
	protected function getDBObject(){
		return new User();
	}	
	protected function getActiveColumnName(){
		return "active";
	}
	function getUnknownUserId(){
		return -1;
	}
	function Save(&$user, $new=false){		
		if(!$user->get_id() && ($existingUser = $this->GetByUserName($user->get_username())) != null){
			if($existingUser->get_active() == 0) {
				$user->set_id($existingUser->get_id());	
			} else {
				$_SESSION['errorMessage'] = "User Name Already In Use";
				return false;				
			}
		}
		$ret = parent::Save($user, $new);
		if(!$user->get_id()){
		    $password = $user->get_password();
			$user = $this->GetByUserName($user->get_username());
			$ret = $ret && $this->ChangePassword($user->get_id(), $password);
		}
		return $ret;
	}
	
	function ChangePassword($id, $password){
		if($password)$password = md5($password);
		$sql = 		"UPDATE users " .
					"SET " .
						"password =  NULLIF(MD5('$password'), ''), " .
						"modifiedDate = NOW() ".
					"WHERE id = $id";	
		return $this->executeQueryNoResult($sql);
	}
	
	function GetByUserName($userName){
		$sql="SELECT * FROM users WHERE userName = '$userName'";
		return $this->executeQueryWithSingleResult($sql);
	}
	
	function Inactivate($id){
		$ret = parent::Inactivate($id);
		
		$ret = $ret && $this->deleteUserRFID($id);
		
		if( $this->GetCount() == 1 ){
			$sql="UPDATE users SET isAdmin = 1 WHERE active <> 0";
			$ret = $ret && $this->executeQueryNoResult($sql);
		}
		$_SESSION['successMessage'] = "user successfully deactivated.";
		return $ret;
	}

	function checklogin($username, $password){
		global $mysqli;
		
		$username = $mysqli->real_escape_string($username);
		$password = $mysqli->real_escape_string($password);		
		
		$sql="SELECT * FROM users WHERE username='$username' AND password='$password' AND active = 1";
		return $this->executeQueryWithSingleResult($sql);
	}
	
	function addRFID($userId, $rfid, $desc){
		$sql = 	"INSERT INTO userRfids(userId, RFID, description ) " .
					"VALUES(" . 
					"'" . $userId . "', " .
					"'" . $rfid . "', " .
					"'" . $desc . "' " .
					")";
				
		return $this->executeQueryNoResult($sql);
	}

	function deleteRFID($userId, $rfid){
		$sql = 	"DELETE FROM userRfids WHERE " .
					"userId = '" . $userId . "' AND " .
					"RFID = '" . $rfid . "'";
				
		return $this->executeQueryNoResult($sql);
	}

	function deleteUserRFID($userId){		
		$sql = 	"DELETE FROM userRfids WHERE " .
					"userId = '" . $userId . "' ".
					";";
		return $this->executeQueryNoResult($sql);
	}
	
	function saveRFID($userId, $rfid, $desc){
		$sql = 	"UPDATE userRfids SET userId = '" . $userId . "', description = '" . $desc . "' " .
					"WHERE " .
					"RFID = '" . $rfid . "'";
				
		return $this->executeQueryNoResult($sql);
	}
	
	function getByRFID($rfid){
		$rfid = preg_replace('/\D/', '', $rfid);
		$sql="SELECT u.* FROM users u left join userRfids rfid ON (u.id = rfid.userid) WHERE rfid = $rfid";
		return $this->executeQueryWithSingleResult($sql);
	}
	
	function getRFIDCount($id){
		$sql="SELECT COUNT(*) FROM userRfids WHERE userId = $id";
		$count =  $this->executeNonObjectQueryWithSingleResults($sql);
		return $count[0];
	}
	
	function getRFIDByUserId($id){
		$sql="SELECT * FROM userRfids WHERE userId = $id";
		return $this->executeNonObjectQueryWithArrayResults($sql);
	}
}
?>
