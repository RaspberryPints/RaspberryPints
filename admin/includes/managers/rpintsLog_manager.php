<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/rpintsLog.php';

class RPintsLogManager extends Manager{
	
	protected function getPrimaryKeys(){
		return ["id"];
	}
	protected function getColumns(){
		return ["process", "category", "text", "occurances"];
	}
	protected function getTableName(){
		return "log";
	}
	protected function getDBObject(){
		return new RPintsLog();
	}
	
	function getAllProcesses(){
	    $sql="SELECT DISTINCT process FROM ".$this->getViewName()." ";
	    return $this->executeNonObjectQueryWithSingleResults($sql);
	}
	function getAllCategories(){
	    $sql="SELECT DISTINCT category FROM ".$this->getViewName()." ";
	    return $this->executeNonObjectQueryWithSingleResults($sql);
	}
	function getLastLogMessagesFiltered($page, $limit, &$totalRows, $startTime, $endTime, $process, $category, $lastId = NULL){
	    $sql="SELECT * FROM ".$this->getViewName()." ";
	    $where = "";
	    if($startTime && $startTime != "" && $startTime != " ") $where = $where.($where != ""?"AND ":"")."modifiedDate >= '$startTime' ";
	    if($endTime && $endTime != "" && $endTime != " ") $where = $where.($where != ""?"AND ":"")."modifiedDate < '$endTime' ";
	    if($process)  $where = $where.($where != ""?"AND ":"")."process = '$process' ";
	    if($category)  $where = $where.($where != ""?"AND ":"")."category = '$category' ";
	    if($lastId)  $where = $where.($where != ""?"AND ":"")."id > '$lastId' ";
	    if($where != "") $sql = $sql."WHERE $where ";
	    $sql = $sql."ORDER BY modifiedDate DESC, id DESC ";
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
