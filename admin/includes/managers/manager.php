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
	
	function Save($dbObject){
		$sql = "";
		if($dbObject->get_id()){
			$columns = "";
			foreach($this->getColumns() as $col){
				if(strlen($columns) > 0) $columns.= ', ';
				$value = $dbObject->{'get_'.$col}();
				if(is_string($value)){
					$columns.= "$col = NULLIF('$value','')";
				}else{
					$columns.= "$col = ".($value?$value:"null");				
				}
			}
			if($this->hasModifiedColumn())$columns.=(strlen($columns) > 0?',':'')." modifiedDate = NOW() ";
			$where = $this->getWhereClause($dbObject);
			$sql = 	"UPDATE ".$this->getTableName().
					" SET ".$columns.
					$where;
		}else{		
			$columns = "";
			foreach($this->getColumns() as $col){
				if(strlen($columns) > 0) $columns.= ', ';
				$columns.= $col;
			}
			if($this->hasModifiedColumn())$columns.=(strlen($columns) > 0?',':'')." modifiedDate";
			if($this->hasCreatedColumn())$columns.=(strlen($columns) > 0?',':'')." createdDate";
			$values = "";
			foreach($this->getColumns() as $col){
				if(strlen($values) > 0) $values.= ', ';
				$value = $dbObject->{'get_'.$col}();
				if($col == $this->getActiveColumnName()){
					$values.= "1";				
				}else if(is_string($value)){
					$values.= "NULLIF('$value','')";
				}else{
					$values.= ($value?$value:"null");				
				}
			}
			if($this->hasModifiedColumn())$values.=(strlen($values) > 0?',':'')." NOW()";
			if($this->hasCreatedColumn())$values.=(strlen($values) > 0?',':'')." NOW()";
			$sql = 	"INSERT INTO ".$this->getTableName()."($columns)".
					"VALUES($values)";
		}
		return $this->executeQueryNoResult($sql);
	}
	
	protected function getWhereClause($dbObject){
		$where = "";
		foreach($this->getPrimaryKeys() as $key){
			if(strlen($where) > 0) $where.= ' AND ';
			$where.= "$key = ".$dbObject->{'get_'.$key}();
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
	
	protected function executeQueryNoResult($sql){
		return $this->executeQuery($sql) != null;
	}
	
	protected function executeQueryWithResults($sql){
		$qry = $this->executeQuery($sql);
		$objArray = array();
		while($qry && $i = $qry->fetch_array()){
			 $dbObject = $this->getDBObject();
			 $dbObject->setFromArray($i);
			 $objArray[$dbObject->{'get_'.$this->getPrimaryKeys()[0]}()] = $dbObject;	
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
		$sql="SELECT ".$this->getPrimaryKeys()[0]." FROM ".$this->getViewName()." $where ".$this->getOrderByClause();
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