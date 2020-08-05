<?php
require_once __DIR__.'/../managers/manager.php';
require_once __DIR__.'/../models/beerAccolade.php';
require_once __DIR__.'/../conn.php';

class BeerAccoladeManager extends Manager{
    protected function getPrimaryKeys(){
        return ["id"];
    }
    protected function getColumns(){
        return ["beerId", "accoladeId", "amount"];
    }
    protected function getTableName(){
        return "beerAccolades";
    }
    protected function getDBObject(){
        return new BeerAccolade();
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