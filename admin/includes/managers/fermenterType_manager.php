<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/fermenterType.php';

class fermenterTypeManager extends Manager{
	
	protected function getPrimaryKeys(){
		return ["id"];
	}
	protected function getColumns(){
	    return ["id", "displayName", "maxAmount", "maxAmountUnit", "emptyWeight", "emptyWeightUnit"];
	}
	protected function getTableName(){
		return "fermenterTypes";
	}
	protected function getDBObject(){
	    return new FermenterType();
	}
}
