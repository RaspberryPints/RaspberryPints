<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/kegStatus.php';

class KegStatusManager extends Manager{
	
	protected function getPrimaryKeys(){
		return ["code"];
	}
	protected function getColumns(){
		return ["name"];
	}
	protected function getTableName(){
		return "kegStatuses";
	}
	protected function getDBObject(){
		return new KegStatus();
	}	
}