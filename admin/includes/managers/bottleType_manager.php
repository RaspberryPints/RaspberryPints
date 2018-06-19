<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/bottleType.php';

class BottleTypeManager extends Manager{
	protected function getPrimaryKeys(){
		return ["id"];
	}
	protected function getColumns(){
		return ["displayName", "volume", "total", "used"];
	}
	protected function getTableName(){
		return "bottleTypes";
	}
	protected function getDBObject(){
		return new BottleType();
	}	
	protected function getOrderByClause(){
		return "displayName";
	}
}
