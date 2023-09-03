<?php
require_once __DIR__.'/../managers/manager.php';
require_once __DIR__.'/../models/beerHop.php';
require_once __DIR__.'/../conn.php';

class BeerHopManager extends Manager{
    protected function getPrimaryKeys(){
        return ["id"];
    }
    protected function getColumns(){
        return ["beerId", "hopsId", "amount", "time"];
    }
    protected function getTableName(){
        return "beerHops";
    }
    protected function getDBObject(){
        return new BeerHop();
    }
    protected function hasModifiedColumn(){return false;}
    protected function hasCreatedColumn(){return false;}    
    
    function GetAllByBeerId($beerId){
        if(null === $beerId)return array();
        $sql="SELECT * FROM ".$this->getViewName()." WHERE beerId = ".$beerId;
        return $this->executeQueryWithResults($sql);
    }
    function DeleteAllByBeerId($beerId){
        if(null === $beerId)return array();
        $sql="DELETE FROM ".$this->getViewName()." WHERE beerId = ".$beerId;
        return $this->executeQueryNoResult($sql);
    }
}