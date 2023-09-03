<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/gasTankStatus.php';

class GasTankStatusManager extends Manager{
	
	protected function getPrimaryKeys(){
		return ["code"];
	}
	protected function getColumns(){
	    return ["code", "name"];
	}
	protected function getTableName(){
		return "gasTankStatuses";
	}
	protected function getDBObject(){
	    return new GasTankStatus();
	}
}
