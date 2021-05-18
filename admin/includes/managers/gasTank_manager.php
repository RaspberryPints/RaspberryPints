<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/gasTank.php';
require_once __DIR__.'/gasTankStatus_manager.php';
require_once __DIR__.'/gasTankType_manager.php';

class GasTankManager extends Manager{
	
	protected function getPrimaryKeys(){
		return ["id"];
	}
	protected function getColumns(){
	    return ["id", "label", "gasTankTypeId", "make", "model", "serial", "notes", "gasTankStatusCode", "weight", "weightUnit", "emptyWeight", "emptyWeightUnit", "maxWeight", "maxWeightUnit", "maxVolume", "maxVolumeUnit", "startAmount", "startAmountUnit", "currentAmount", "currentAmountUnit", "active","loadCellCmdPin", "loadCellRspPin", "loadCellScaleRatio", "loadCellTareOffset", "loadCellUnit", "loadCellTareDate"
	    ];
	}
	protected function getTableName(){
		return "gasTanks";
	}
	protected function getDBObject(){
	    return new GasTank();
	}
	protected function getActiveColumnName(){
	    return "active";
	}
	protected function getViewName(){
	    return "vwGasTanks";
	}
	function saveGasTankLoadCellInfo($id, $loadCellCmdPin, $loadCellRspPin, $loadCellScaleRatio, $loadCellTareOffset, $loadCellUnit) {
	    $ret = true;
	    $gasTank = $this->GetByID($id);
	    $updateSql = "";
	    if( $gasTank ){
	        if($gasTank->get_loadCellCmdPin() != $loadCellCmdPin) $updateSql .= ($updateSql!=""?",":"")."loadCellCmdPin = NULLIF('" . $loadCellCmdPin . "', '')";
	        if($gasTank->get_loadCellRspPin() != $loadCellRspPin) $updateSql .= ($updateSql!=""?",":"")."loadCellRspPin = NULLIF('" . $loadCellRspPin . "', '')";
	        if($gasTank->get_loadCellScaleRatio() != $loadCellScaleRatio) $updateSql .= ($updateSql!=""?",":"")."loadCellScaleRatio = NULLIF('" . $loadCellScaleRatio . "', '')";
	        if($gasTank->get_loadCellTareOffset() != $loadCellTareOffset) $updateSql .= ($updateSql!=""?",":"")."loadCellTareOffset = NULLIF('" . $loadCellTareOffset . "', '')";
	        if($gasTank->get_loadCellUnit() != $loadCellUnit) $updateSql .= ($updateSql!=""?",":"")."loadCellUnit = NULLIF('" . $loadCellUnit . "', '')";
	        if($updateSql != "")$sql = "UPDATE gasTanks SET ".$updateSql." WHERE id = " . $id;
	    } else {
	        $sql = "INSERT INTO gasTanks (id, loadCellCmdPin, loadCellRspPin, loadCellScaleRatio, loadCellTareOffset, loadCellUnit) VALUES(" .
	   	        $id.", ".$loadCellCmdPin.", ".$loadCellRspPin.", ".$loadCellScaleRatio.", ".$loadCellTareOffset.", '".$loadCellUnit."')";
	    }
	    if(isset($sql) && $sql != "")$ret = $ret && $this->executeQueryNoResult($sql);
	    return $ret;
	}
	function set_GasTankTareRequested($id, $tare) {
	    $ret = true;
	    $gasTank = $this->GetByID($id);
	    $updateSql = "";
	    if($tare){
	        $tare = 1;
	    }else{
	        $tare = 0;
	    }
	    if( $gasTank ){
	        $updateSql .= ($updateSql!=""?",":"")."loadCellTareReq = NULLIF('" . $tare . "', '0')";
	        if($updateSql != "")$sql = "UPDATE gasTanks SET ".$updateSql." WHERE id = " . $id;
	    }
	    if(isset($sql) && $sql != "")$ret = $ret && $this->executeQueryNoResult($sql);
	    return $ret;
	}
}
