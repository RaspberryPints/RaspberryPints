<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/fermenterStatus.php';

class fermenterStatusManager extends Manager{
	
	protected function getPrimaryKeys(){
		return ["code"];
	}
	protected function getColumns(){
	    return ["code", "name"];
	}
	protected function getTableName(){
		return "fermenterStatuses";
	}
	protected function getDBObject(){
	    return new FermenterStatus();
	}
}
