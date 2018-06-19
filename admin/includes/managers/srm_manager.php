<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/srm.php';

class SrmManager extends Manager{
	
	protected function getPrimaryKeys(){
		return ["id"];
	}
	protected function getColumns(){
		return ["srm", "rbg"];
	}
	protected function getTableName(){
		return "srmRgb";
	}
	protected function getDBObject(){
		return new Srm();
	}	
}