<?php
require_once __DIR__.'/../managers/manager.php';
require_once __DIR__.'/../models/beerBatchYeast.php';
require_once __DIR__.'/../conn.php';

class BeerBatchDateManager extends Manager{
    protected function getPrimaryKeys(){
        return ["id"];
    }
    protected function getColumns(){
        return ["beerBatchId", "type"];
    }
    protected function getTableName(){
        return "beerBatchDatess";
    }
    protected function getDBObject(){
        return new BeerBatchDate();
    }
    protected function hasModifiedColumn(){return false;}
    
    function GetAllByBeerBatchId($beerBatchId){
        if(null === $beerBatchId)return array();
        $sql="SELECT * FROM ".$this->getViewName()." WHERE beerId = ".$beerBatchId;
        return $this->executeQueryWithResults($sql);
    }
    function DeleteAllByBeerBatchId($beerBatchId){
        if(null === $beerBatchId)return array();
        $sql="DELETE FROM ".$this->getViewName()." WHERE beerId = ".$beerBatchId;
        return $this->executeQueryNoResult($sql);
    }
}