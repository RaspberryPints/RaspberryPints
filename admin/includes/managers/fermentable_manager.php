<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/fermentable.php';

class FermentableManager extends Manager{
	
	protected function getPrimaryKeys(){
		return ["id"];
	}
	protected function getColumns(){
		return ["name", "type", "srm", "notes"];
	}
	protected function getTableName(){
		return "fermentables";
	}
	protected function getDBObject(){
		return new Fermentable();
	}	
	
	function GetAllForBeer($id){
		$sql="SELECT * FROM ".$this->getTableName()." t left join beer".ucwords($this->getTableName())." tb on (t.id = tb.".$this->getTableName()."Id) WHERE tb.beerId = $id";
		return $this->executeQueryWithResults($sql);
	}
}