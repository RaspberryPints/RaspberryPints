<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/tempLog.php';

class TempLogManager extends Manager{
	
	protected function getPrimaryKeys(){
		return ["id"];
	}
	protected function getColumns(){
		return ["probe", "temp", "humidity", "takenDate"];
	}
	protected function getTableName(){
		return "tempLog";
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
	
	function getLastTempsFiltered($count, $startTime, $endTime, $probe){
	    $sql="SELECT * FROM ".$this->getViewName()." ";
	    $where = "";
	    if($startTime && $startTime != "" && $startTime != " ") $where = $where.($where != ""?"AND ":"")."takenDate >= '$startTime' ";
	    if($endTime && $endTime != "" && $endTime != " ") $where = $where.($where != ""?"AND ":"")."takenDate < '$endTime' ";
	    if($probe)  $where = $where.($where != ""?"AND ":"")."probe = $probe ";
	    if($where != "") $sql = $sql."WHERE $where ";
	    $sql = $sql."ORDER BY takenDate DESC ";
	    if($count && $count > 0) $sql = $sql."LIMIT $count ";
	    return $this->executeQueryWithResults($sql);
	}
}
