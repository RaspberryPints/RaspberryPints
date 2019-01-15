<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/ioPin.php';

class IoPinManager extends Manager{
	protected function getPrimaryKeys(){
		return ["shield", "pin"];
	}
	protected function getColumns(){
	    return ["shield", "pin", "displayPin", "name", "notes", "col", "row", "rgb", "pinSide", "hardware"];
	}
	protected function getInsertColumns(){
	    return ["shield", "pin", "row", "col"];
	}
	protected function getUpdateColumns(){
	    return ["shield", "pin", "displayPin", "name", "notes", "col", "row", "rgb", "pinSide"];
	}
	protected function getTableName(){
		return "ioPins";
	}
	protected function getViewName(){
	    return "vwIoPins";
	}
	protected function getDBObject(){
	    return new IoPin();
	}
	protected function getOrderByClause(){
	    return 'ORDER BY shield, row, col';
	}	
	protected function executeQueryWithResults($sql){
	    $objArray = parent::executeQueryWithResults($sql);
	    usort($objArray, array("ioPin", "cmpShieldRow"));
	    return $objArray;
	}
	function deleteShield($shield){
	    $sql="DELETE FROM ioPins WHERE shield = '$shield'";
	    return $this->executeQueryNoResult($sql);	    
	}
}
