<?php
require_once __DIR__.'/../managers/manager.php';
require_once __DIR__.'/../models/beerYeast.php';
require_once __DIR__.'/../conn.php';

class BeerYeastManager extends Manager{
    protected function getPrimaryKeys(){
        return ["id"];
    }
    protected function getColumns(){
        return ["beerId", "yeastsId", "amount"];
    }
    protected function getTableName(){
        return "beerYeasts";
    }
    protected function getDBObject(){
        return new BeerYeast();
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