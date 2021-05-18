<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/tempLog.php';

class TempLogManager extends Manager{
	
	protected function getPrimaryKeys(){
		return ["id"];
	}
	protected function getColumns(){
		return ["probe", "temp", "tempUnit", "humidity", "takenDate", "statePinState"];
	}
	protected function getTableName(){
		return "tempLog";
	}
	protected function getViewName(){
	    return "vwTempLog";
	}
	protected function getDBObject(){
		return new TempLog();
	}
	protected function hasModifiedColumn(){return false;}
	protected function hasCreatedColumn(){return false;}
	
	function hasHumidityBeenLogged(){
	   $sql = "SELECT COUNT(humidity) FROM ".$this->getViewName()." WHERE humidity IS NOT NULL";
	   $results = $this->executeNonObjectQueryWithSingleResults($sql);
	   if(count($results) > 0) return $results[0] != "0";
	   return false;
	}
	
	function getLastTempsFiltered($page, $limit, &$totalRows, $startTime, $endTime, $probe){
	    $sql="SELECT * FROM ".$this->getViewName()." ";
	    $where = "";
	    if($startTime && $startTime != "" && $startTime != " ") $where = $where.($where != ""?"AND ":"")."takenDate >= '$startTime' ";
	    if($endTime && $endTime != "" && $endTime != " ") $where = $where.($where != ""?"AND ":"")."takenDate < '$endTime' ";
	    if($probe)  $where = $where.($where != ""?"AND ":"")."probe = '$probe' ";
	    if($where != "") $sql = $sql."WHERE $where ";
	    $sql = $sql."ORDER BY takenDate ASC ";
	    $totalRows = 0;
	    if($results = $this->executeNonObjectQueryWithArrayResults("SELECT COUNT(*) as totalRows FROM ".$this->getViewName())){
	        if(count($results) > 0) $totalRows = $results[0]['totalRows'];
	    }
	    $limitClause = $this->getLimitClause($limit, $page);
	    if($limitClause == "") return $results;
	    $sql = $sql.$limitClause;
	    return $this->executeQueryWithResults($sql);
	}
}
