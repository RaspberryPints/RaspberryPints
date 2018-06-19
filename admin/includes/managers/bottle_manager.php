<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/bottle.php';

class BottleManager extends Manager{
	
	protected function getPrimaryKeys(){
		return ["id"];
	}
	protected function getColumns(){
		return ["bottleTypeId", "beerId", "capRgba", "capNumber", "startAmount", "currentAmount"];
	}
	protected function getTableName(){
		return "bottles";
	}
	protected function getDBObject(){
		return new Bottle();
	}	
	protected function getActiveColumnName(){
		return "active";
	}
	
	function getCapColors(){
		$colors = array(
					Srm::fromColors("gold","255,150,50"),
					Srm::fromColors("yellow","255,255,0"),
					Srm::fromColors("light blue","0,255,255"),
					Srm::fromColors("purple","255,0,255"),
					Srm::fromColors("blue", "0, 0, 255"),
				    Srm::fromColors("red","255,0,0"),
				    Srm::fromColors("green","0,255,0")
				   );
		return $colors;
	
	}
}
