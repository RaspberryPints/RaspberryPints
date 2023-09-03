<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/iSpindelDevice.php';

class iSpindelDeviceManager extends Manager{
	
	protected function getPrimaryKeys(){
		return ["iSpindelId"];
	}
	protected function getColumns(){
	    return ["active", "name", "beerId", "const1", "const2", "const3", "interval", "token", "polynomial", "sent", "remoteConfigEnabled", "sqlEnabled", "csvEnabled", "csvOutpath", "csvDelimiter", "csvNewLine", "csvIncludeDateTime", "unidotsEnabled", "unidotsUseiSpindelToken", "unidotsToken", "forwardEnabled", "forwardAddress", "forwardPort", "fermentTrackEnabled", "fermentTrackAddress", "fermentTrackPort", "fermentTrackUseiSpindelToken", "fermentTrackToken", "brewPiLessEnabled", "brewPiLessAddress", "craftBeerPiEnabled", "craftBeerPiAddress", "craftBeerPiSendAngle", "brewSpyEnabled", "brewSpyAddress", "brewSpyPort", "brewSpyUseiSpindelToken", "brewSpyToken", "brewFatherEnabled", "brewFatherAddress", "brewFatherPort", "brewFatherUseiSpindelToken", "brewFatherToken", "brewFatherSuffix", "currentTemperature", "currentTemperatureUnit", "currentGravity", "currentGravityUnit", "gravityUnit"];
	}
	protected function getUpdateColumns(){return ["active", "name", "beerId", "beerBatchId", "const1", "const2", "const3", "interval", "token", "polynomial", "sent", "remoteConfigEnabled", "sqlEnabled", "csvEnabled", "csvOutpath", "csvDelimiter", "csvNewLine", "csvIncludeDateTime", "unidotsEnabled", "unidotsUseiSpindelToken", "unidotsToken", "forwardEnabled", "forwardAddress", "forwardPort", "fermentTrackEnabled", "fermentTrackAddress", "fermentTrackPort", "fermentTrackUseiSpindelToken", "fermentTrackToken", "brewPiLessEnabled", "brewPiLessAddress", "craftBeerPiEnabled", "craftBeerPiAddress", "craftBeerPiSendAngle", "brewSpyEnabled", "brewSpyAddress", "brewSpyPort", "brewSpyUseiSpindelToken", "brewSpyToken", "brewFatherEnabled", "brewFatherAddress", "brewFatherPort", "brewFatherUseiSpindelToken", "brewFatherToken", "brewFatherSuffix", "gravityUnit"];}
	protected function getInsertColumns(){return $this->getUpdateColumns();}
	protected function getTableName(){
		return "iSpindel_Device";
	}
	protected function getDBObject(){
	    return new iSpindelDevice();
	}	
	protected function getActiveColumnName(){
		return "active";
	}
	protected function getOrderByClause(){
		return "ORDER BY iSpindelId";
	}
	protected function getViewName(){
	    return "vwiSpindel_Device";
	}
	function GetTopWithBeer($id, $batchId=null){
	    if( !$batchId ){
	        $sql="SELECT * FROM ".$this->getViewName()." t WHERE beerBatchId = $batchId";	        
	    }
	    else {
	       $sql="SELECT * FROM ".$this->getViewName()." t WHERE beerId = $id";
	    }
	    return $this->executeQueryWithSingleResult($sql);
	}
}
