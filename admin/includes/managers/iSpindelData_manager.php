<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/iSpindelData.php';

class iSpindelDataManager extends Manager{
    
    protected function getPrimaryKeys(){
        return ["id"];
    }
    protected function getColumns(){
        return ["id", "createdDate", "name", "iSpindelId", "angle", "temperature", "temperatureUnit", "battery", "resetFlag", "gravity", "gravityUnit", "userToken", "interval", "RSSI", "beerId"];
    }
    protected function getTableName(){
        return "iSpindel_Data";
    }
    protected function getDBObject(){
        return new iSpindelData();
    }
    protected function hasModifiedColumn(){return false;}
    
    
    function getLastDataFiltered($page, $limit, &$totalRows, $startTime, $endTime, $device, $hasBeerOnly){
        $sql="SELECT dat.*, d.name FROM ".$this->getViewName()." dat LEFT JOIN iSpindel_Device d ON dat.iSpindelId = d.iSpindelId ";
        $where = "";
        if($startTime && $startTime != "" && $startTime != " ") $where = $where.($where != ""?"AND ":"")."dat.createdDate >= '$startTime' ";
        if($endTime && $endTime != "" && $endTime != " ") $where = $where.($where != ""?"AND ":"")."dat.createdDate < '$endTime' ";
        if($device)  $where = $where.($where != ""?"AND ":"")."d.name = '$device' ";
        if($hasBeerOnly)  $where = $where.($where != ""?"AND ":"")."dat.beerId IS NOT NULL ";
        if($where != "") $sql = $sql."WHERE $where ";
        $sql = $sql."ORDER BY dat.createdDate ASC ";
        $totalRows = 0;
        if($results = $this->executeNonObjectQueryWithArrayResults("SELECT COUNT(*) as totalRows FROM ".$this->getViewName()." dat LEFT JOIN iSpindel_Device d ON dat.iSpindelId = d.iSpindelId ".(($where != "")?" WHERE $where ":""))){
            if(count($results) > 0) $totalRows = $results[0]['totalRows'];
        }
        $limitClause = $this->getLimitClause($limit, $page);
        if($limitClause == "") return $results;
        $sql = $sql.$limitClause;
        return $this->executeQueryWithResults($sql);
    }
    
}
