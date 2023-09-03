<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/gasTankType.php';

class GasTankTypeManager extends Manager{
	
	protected function getPrimaryKeys(){
		return ["id"];
	}
	protected function getColumns(){
	    return ["id", "displayName", "maxAmount", "maxAmountUnit", "emptyWeight", "emptyWeightUnit"];
	}
	protected function getTableName(){
		return "gasTankTypes";
	}
	protected function getDBObject(){
	    return new GasTankType();
	}
}
