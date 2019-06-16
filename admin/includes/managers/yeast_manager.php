<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/yeast.php';

class YeastManager extends Manager{
	
	protected function getPrimaryKeys(){
		return ["id"];
	}
	protected function getColumns(){
	    return ["name", "strand", "format", "minTemp", "minTempUnit", "maxTemp", "maxTempUnit", "minAttenuation", "maxAttenuation", "flocculation", "notes"];
	}
	protected function getTableName(){
		return "yeasts";
	}
	protected function getDBObject(){
		return new Yeast();
	}	
	
	function GetByName($name){
	    $sql="SELECT * FROM ".$this->getTableName()." WHERE name = '$name'";
	    return $this->executeQueryWithSingleResult($sql);
	}
	function GetAllForBeer($id){
		$sql="SELECT * FROM ".$this->getTableName()." t left join beer".ucwords($this->getTableName())." tb on (t.id = tb.".$this->getTableName()."Id) WHERE tb.beerId = $id";
		return $this->executeQueryWithResults($sql);
	}
	
	function GetDistinctForBeer($id){
		$sql="SELECT DISTINCT t.* FROM ".$this->getTableName()." t left join beer".ucwords($this->getTableName())." tb on (t.id = tb.".$this->getTableName()."Id) WHERE tb.beerId = $id";
		return $this->executeQueryWithResults($sql);
	}
}