<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/fermenterType_manager.php';
require_once __DIR__.'/fermenterStatus_manager.php';
require_once __DIR__.'/../models/fermenter.php';

class FermenterManager extends Manager{
	
	protected function getPrimaryKeys(){
		return ["id"];
	}
	protected function getColumns(){
	    return ["id", "label", "fermenterTypeId", "make", "model", "serial", "notes", "fermenterStatusCode", "weight", "weightUnit", "emptyWeight", "emptyWeightUnit", "maxVolume", "maxVolumeUnit", "startAmount", "startAmountUnit", "currentAmount", "currentAmountUnit", "fermentationPSI", "fermentationPSIUnit", "beerId", "beerBatchId", "active"];
	}
	protected function getTableName(){
		return "fermenters";
	}
	protected function getDBObject(){
	    return new Fermenter();
	}
	protected function getActiveColumnName(){
	    return "active";
	}
	protected function getViewName(){
	    return "vwFermenters";
	}
}
