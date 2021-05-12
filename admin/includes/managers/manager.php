<?php
require_once __DIR__.'/../conn.php';

abstract class Manager {

	abstract protected function getPrimaryKeys();
	abstract protected function getColumns();
	abstract protected function getTableName();
	abstract protected function getDBObject();
	
	protected function getActiveColumnName(){return null;}
	protected function hasModifiedColumn(){return true;}
	protected function hasCreatedColumn(){return true;}
	protected function getViewName(){return $this->getTableName();}
	protected function getUpdateColumns(){return $this->getColumns();}
	protected function getInsertColumns(){return $this->getColumns();}
	
	function Save(&$dbObject, $new=false){
	    global $mysqli;
		$sql = "";
		if($dbObject->get_id() && !$new){
			$columns = "";
			foreach($this->getUpdateColumns() as $col){
				if(strlen($columns) > 0) $columns.= ', ';
				$value = $dbObject->{'get_'.$col}();
				$value = $mysqli->escape_string($value);
				if($value && (is_string($value) || preg_match("/[^0-9]/", $value) || $value == '')){
					$columns.= "`$col` = NULLIF('$value','')";
				}else{
					$columns.= "`$col` = ".(!is_null($value) && $value != ''?$value:"null");				
				}
			}
			if($this->hasModifiedColumn())$columns.=(strlen($columns) > 0?',':'')." modifiedDate = NOW() ";
			$where = $this->getWhereClause($dbObject);
			$sql = 	"UPDATE ".$this->getTableName().
					" SET ".$columns.
					$where;
		}else{		
		    $new = true;
			$columns = "";
			foreach($this->getInsertColumns() as $col){
				if(strlen($columns) > 0) $columns.= ', ';
				$columns.= "`$col`";
			}
			if($this->hasModifiedColumn())$columns.=(strlen($columns) > 0?',':'')." modifiedDate";
			if($this->hasCreatedColumn())$columns.=(strlen($columns) > 0?',':'')." createdDate";
			$values = "";
			foreach($this->getInsertColumns() as $col){
				if(strlen($values) > 0) $values.= ', ';
				$value = $dbObject->{'get_'.$col}();
				$value = $mysqli->escape_string($value);
				if($col == $this->getActiveColumnName()){
					$values.= "1";				
				}else if($value && (is_string($value) || preg_match("/[^0-9]/", $value) || $value == '')){
					$values.= "NULLIF('$value','')";
				}else{
				    $values.= (!is_null($value) && $value != ''?$value:"null");				
				}
			}
			if($this->hasModifiedColumn())$values.=(strlen($values) > 0?',':'')." NOW()";
			if($this->hasCreatedColumn())$values.=(strlen($values) > 0?',':'')." NOW()";
			$sql = 	"INSERT INTO ".$this->getTableName()."($columns)".
					"VALUES($values)";
		}
		$success = $this->executeQueryNoResult($sql);
		if($new){
		    $dbObject->set_id($mysqli->insert_id);
		}
		return $success;
	}
	
	protected function getWhereClause($dbObject){
		$where = "";
		foreach($this->getPrimaryKeys() as $key){
			if(strlen($where) > 0) $where.= ' AND ';
			$where.= "$key = '".$dbObject->{'get_'.$key}()."'";
		}
		if(strlen($where) > 0) $where = 'WHERE '.$where;
		return $where;
	}
	
	protected function getOrderByClause(){
		$order = "";
		foreach($this->getPrimaryKeys() as $key){
			if(strlen($order) > 0) $order.= ', ';
			$order.= "$key ";
		}
		if(strlen($order) > 0) $order = 'ORDER BY '.$order;
		return $order;
	}
	
	protected function getLimitClause($limit=0, $page=1){
	    $sql = "";
	    if(!$page)$page = 1;
	    if($limit && $limit > 0){
	        $limitLow = (($page-1)*$limit);
	        $limitHigh = $limit; //DB syntax is Limit <startRow>, <numRowsToReturn>
	        $sql = " LIMIT $limitLow, $limitHigh ";
	    }
	    return $sql;
	}
	
	protected function executeQueryNoResult($sql){
		return $this->executeQuery($sql) != null;
	}
	
	protected function executeQueryWithResults($sql){
		$qry = $this->executeQuery($sql);
		$objArray = array();
		while($qry && $i = $qry->fetch_array()){
			 $dbObject = $this->getDBObject();
			 $dbObject->setFromArray($i);
			 $keyIndex = '';
			 foreach($this->getPrimaryKeys() as $key){
			     $keyIndex .= $dbObject->{'get_'.$key}();
			 }
			 $objArray[$keyIndex] = $dbObject;	
		}

		return $objArray;
	}
	
	protected function executeQueryWithSingleResult($sql){
		$qry = $this->executeQuery($sql);
		$dbObject = null;
		if($qry && $i = $qry->fetch_array()){
			 $dbObject = $this->getDBObject();
			 $dbObject->setFromArray($i);
		}
		return $dbObject;
	}
	
	protected function executeNonObjectQueryWithArrayResults($sql){
		$qry = $this->executeQuery($sql);
		$objArray = array();
		while($qry && $i = $qry->fetch_array()){
			 $objArray[] = $i;	
		}

		return $objArray;
	}
	
	protected function executeNonObjectQueryWithSingleResults($sql){
		$qry = $this->executeQuery($sql);
		$objArray = array();
		while($qry && $i = $qry->fetch_array()){
			 $objArray[] = array_values($i)[0];	
		}

		return $objArray;
	}
	
	protected function executeQuery($sql){
		global $showSqlState;
		global $mysqli;
		//echo $sql; //exit();
		$qry = $mysqli->query($sql);
		if($mysqli->error != ""){
			$_SESSION['errorMessage'] = "Cannot Execute Query" . ($showSqlState?"[ $sql ]":"");			
			return null;
		}
		return $qry;
	}
	
	function GetByID($id){
		$id = (int) preg_replace('/\D/', '', $id);	
		$obj = $this->getDBObject();
		$obj->{'set_'.$this->getPrimaryKeys()[0]}($id);
		return $this->GetByPk($obj);
	}
	
	function GetByPk($dbObject){
		$sql="SELECT * FROM ".$this->getViewName()." ".$this->getWhereClause($dbObject)." ".$this->getOrderByClause();
		$results = $this->executeQueryWithResults($sql);
		if( $results && count($results) > 0 ) return array_values($results)[0];
		return null;
	}
	
	function GetAll(){
		$sql="SELECT * FROM ".$this->getViewName()." ".$this->getOrderByClause();
		return $this->executeQueryWithResults($sql);
	}
	
	function GetAllActive(){
		if($this->getActiveColumnName()){
			$sql="SELECT * FROM ".$this->getViewName()." WHERE ".$this->getActiveColumnName()." = 1 ".$this->getOrderByClause();
			return $this->executeQueryWithResults($sql);
		}
		return $this->GetAll();
	}
	
	function GetAllActiveIDs(){
		$where = "";
		if($this->getActiveColumnName()) $where = "WHERE ".$this->getActiveColumnName()." = 1 ";
		$sql = "SELECT ";
		for($i = 0; $i < count($this->getPrimaryKeys()); $i++) {
		    if($i > 0) $sql .= ", ";
		    $sql .= $this->getPrimaryKeys()[$i];
		}
		$sql .= " FROM ".$this->getViewName()." $where ".$this->getOrderByClause();
		return $this->executeNonObjectQueryWithSingleResults($sql);
	}
	
	function GetCount(){
		$where = "";
		if($this->getActiveColumnName()) $where = "WHERE ".$this->getActiveColumnName()." = 1 ";
		$sql="SELECT COUNT(*) FROM ".$this->getViewName()." ".$where;
		$count = $this->executeNonObjectQueryWithSingleResults($sql);			
   		return $count[0];
	}
	
	
	function Inactivate($id){
		$id = (int) preg_replace('/\D/', '', $id);	
		$dbObject = $this->getDBObject();
		$dbObject->{'set_'.$this->getPrimaryKeys()[0]}($id);
		if( $this->getActiveColumnName() ){
			$where = $this->getWhereClause($dbObject);
			if(strlen($where) == 0)return false;
			$sql="UPDATE ".$this->getTableName()." SET ".$this->getActiveColumnName()." = 0 $where";
		}else{
			$sql="DELETE from ".$this->getTableName()." ".$this->getWhereClause($dbObject);
		}
		return $this->executeQueryNoResult($sql);
	}
	
}