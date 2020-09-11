<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/containerType.php';

class ContainerTypeManager extends Manager{
	protected function getPrimaryKeys(){
		return ["id"];
	}
	protected function getColumns(){
		return ["displayName", "volume", "total", "used"];
	}
	protected function getTableName(){
		return "containerTypes";
	}
	protected function getDBObject(){
		return new ContainerType();
	}	
	protected function getOrderByClause(){
		return "displayName";
	}
}
