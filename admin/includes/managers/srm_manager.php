<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/srm.php';

class SrmManager extends Manager{
	
	protected function getPrimaryKeys(){
		return ["id"];
	}
	protected function getColumns(){
		return ["srm", "rgb"];
	}
	protected function getTableName(){
		return "srmRgb";
	}
	protected function getDBObject(){
		return new Srm();
	}
	protected function getOrderByClause(){
		return "ORDER BY srm";
	}
	public function getBySRM($srm){
	    $sql="SELECT * FROM ".$this->getViewName()." WHERE srm = ".$srm;
	    $results = $this->executeQueryWithResults($sql);
	    if( $results && count($results) > 0 ) return array_values($results)[0];
	    return null;
	}
	public function getByRGB($rgb){
	    $sql="SELECT * FROM ".$this->getViewName()." WHERE rgb = ".$rgb;
	    $results = $this->executeQueryWithResults($sql);
	    if( $results && count($results) > 0 ) return array_values($results)[0];
	    return null;
	}
	public function getMaxSRM(){
	    $sql="SELECT MAX(srm) FROM ".$this->getViewName();
	    $results = $this->executeNonObjectQueryWithSingleResults($sql);
	    if( $results && count($results) > 0 ) return array_values($results)[0];
	    return null;
	}	
}