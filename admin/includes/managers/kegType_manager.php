<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/kegType.php';

class KegTypeManager extends Manager{
	
	protected function getPrimaryKeys(){
		return ["id"];
	}
	protected function getColumns(){
		return ["displayName", "maxAmount", "maxAmountUnit", "emptyWeight", "emptyWeightUnit"];
	}
	protected function getTableName(){
		return "kegTypes";
	}
	protected function getDBObject(){
		return new KegType();
	}	
}