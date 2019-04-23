<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/hop.php';

class HopManager extends Manager{
	
	protected function getPrimaryKeys(){
		return ["id"];
	}
	protected function getColumns(){
		return ["name", "alpha", "beta", "notes"];
	}
	protected function getTableName(){
		return "hops";
	}
	protected function getDBObject(){
		return new Hop();
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