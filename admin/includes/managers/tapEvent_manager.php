<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/tapEvent.php';

const TAP_EVENT_TYPE_TAP = 1;
const TAP_EVENT_TYPE_UNTAP = 2;

class TapEventManager extends Manager{
	
	protected function getPrimaryKeys(){
		return ["id"];
	}
	protected function getColumns(){
		return ["type", "tapId", "kegId", "beerId", "amount", "amountUnit", "userId"];
	}
	protected function getTableName(){
		return "tapEvents";
	}
	protected function getViewName(){
	    return "vwTapEvents";
	}
	protected function getDBObject(){
		return new TapEvent();
	}	
	
	
	function getTapEvents($page, $limit, &$totalRows, $groupBy){
	    return $this->getTapEventsFiltered($page, $limit, $totalRows, $groupBy, null, null, null, null, null, null);
	}
	function getTapEventsFiltered($page, $limit, &$totalRows, $groupBy, $startTime, $endTime, $tapId, $beerId, $userId, $kegId){
	    $sql="SELECT * ";
	    $sql = $sql."FROM ".$this->getViewName()." ";
	    $where = "";
	    if($startTime && $startTime != "") $where = $where.($where != ""?"AND ":"")."createdDate >= '$startTime' ";
	    if($endTime && $endTime != "") $where = $where.($where != ""?"AND ":"")."createdDate < '$endTime' ";
	    if($tapId)  $where = $where.($where != ""?"AND ":"")."tapId = $tapId ";
	    if($beerId) $where = $where.($where != ""?"AND ":"")."beerId = $beerId ";
	    if($userId) $where = $where.($where != ""?"AND ":"")."userId = $userId ";
	    if($kegId)  $where = $where.($where != ""?"AND ":"")."kegId = '$kegId' ";
	    if($where != "") $sql = $sql."WHERE $where ";
	    $totalRows = 0;
	    if($results = $this->executeQueryWithResults($sql)){
            $totalRows = count($results);
	    }
	    $limitClause = $this->getLimitClause($limit, $page);
	    if($limitClause == "") return $results;
	    $sql = $sql.$limitClause;
	    return $this->executeQueryWithResults($sql);
	}
	
	function getTapEventSummary(){
	    $sql = "SELECT tapId, MAX(tapNumber) AS tapNumber,
        	    COUNT(*) AS numEvents,
        	    COUNT(distinct kegId) AS numKegsDistinct,
        	    COUNT(distinct beerId) AS numBeersDistinct,
        	    SUM(CASE WHEN type = 1 THEN 1 else 0 END) as numTapped,
        	    SUM(CASE WHEN type = 2 THEN 1 else 0 END) as numRemoved,
        	    SUM(newAmount - amount) AS poured
        	    FROM raspberrypints.vwtapevents
        	    GROUP BY tapId
                orderBy tapId";
	    return $this->executeNonObjectQueryWithArrayResults($sql);
	}
	
	function getDisplayAmount($value, $currentUnit, $useLargeUnits = FALSE){
	    $ret = convert_volume($value, $currentUnit, getConfigValue(ConfigNames::DisplayUnitVolume), $useLargeUnits);
	    return number_format($ret, 2);
	}
}