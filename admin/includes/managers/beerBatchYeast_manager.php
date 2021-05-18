<?php
require_once __DIR__.'/../managers/manager.php';
require_once __DIR__.'/../models/beerBatchYeast.php';

class BeerBatchYeastManager extends Manager{
    protected function getPrimaryKeys(){
        return ["id"];
    }
    protected function getColumns(){
        return ["beerBatchId", "yeastsId", "amount"];
    }
    protected function getTableName(){
        return "beerBatchYeasts";
    }
    protected function getDBObject(){
        return new BeerBatchYeast();
    }
    protected function hasModifiedColumn(){return false;}
    protected function hasCreatedColumn(){return false;}    
    
    function GetAllByBeerBatchId($beerBatchId){
        if(null === $beerBatchId)return array();
        $sql="SELECT * FROM ".$this->getViewName()." WHERE beerBatchId = ".$beerBatchId;
        return $this->executeQueryWithResults($sql);
    }
    function DeleteAllByBeerBatchId($beerBatchId){
        if(null === $beerBatchId)return array();
        $sql="DELETE FROM ".$this->getViewName()." WHERE beerBatchId = ".$beerBatchId;
        return $this->executeQueryNoResult($sql);
    }
    function GetDistinctForBeerBatch($beerBatchId){
        if(null === $beerBatchId)return array();
        $sql="SELECT DISTINCT * FROM ".$this->getViewName()." WHERE beerBatchId = ".$beerBatchId;
        return $this->executeQueryWithResults($sql);
    }
}