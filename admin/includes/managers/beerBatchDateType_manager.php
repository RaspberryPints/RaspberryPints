<?php
require_once __DIR__.'/../managers/manager.php';
require_once __DIR__.'/../models/beerBatchDateType.php';
require_once __DIR__.'/../conn.php';

class BeerBatchDateTypeManager extends Manager{
    protected function getPrimaryKeys(){
        return ["type"];
    }
    protected function getColumns(){
        return ["displayName"];
    }
    protected function getTableName(){
        return "beerBatchDates";
    }
    protected function getDBObject(){
        return new BeerBatchDateType();
    }    
}