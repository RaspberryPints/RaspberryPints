<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/beerBatch.php';
require_once __DIR__.'/beerBatchYeast_manager.php';

class BeerBatchManager extends Manager{
	
	protected function getPrimaryKeys(){
		return ["id"];
	}
	protected function getColumns(){
	    return ["id", "beerId", "batchNumber", "name", "notes", "startAmount", "startAmountUnit", "currentAmount", "currentAmountUnit", "fermentationTempMin", "fermentationTempMinUnit", "fermentationTempSet", "fermentationTempSetUnit", "fermentationTempMax", "fermentationTempMaxUnit", "abv", "og", "ogUnit", "fg", "fgUnit", "srm", "ibu", "rating"];
	}
	protected function getTableName(){
		return "beerBatches";
	}
	protected function getViewName(){
	    return "vwbeerBatches";
	}
	protected function getDBObject(){
		return new BeerBatch();
	}
	function GetYeasts($id){
	    $manager = new BeerBatchYeastManager();
	    return $manager->GetDistinctForBeerBatch($id);
	}
	
	function GetAllActiveWithRemaining(){
	    if($this->getActiveColumnName()){
	        $sql="SELECT * FROM ".$this->getViewName()." WHERE ".$this->getActiveColumnName()." = 1 AND currentAmount > 0".$this->getOrderByClause();
	        return $this->executeQueryWithResults($sql);
	    }
	    return $this->GetAll();
	}
	function GetAllActiveByBeerId($beerId){
	    if($beerId){
	        $sql="SELECT * FROM ".$this->getViewName()." WHERE beerId = ".$beerId." ".$this->getOrderByClause();
	        return $this->executeQueryWithResults($sql);
	    }
	    return $this->GetAll();
	}
}
