<?php
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/tempProbe.php';

class TempProbeManager extends Manager{
	
	protected function getPrimaryKeys(){
		return ["id"];
	}
	protected function getColumns(){
		return ["name", "type", "pin", "manualAdj", "notes"];
	}
	protected function getTableName(){
		return "tempProbes";
	}
	protected function getDBObject(){
		return new TempProbe();
	}
	protected function getActiveColumnName(){
	    return "active";
	}	
	
	function get_lastAvgTemp(){
        $sql="SELECT AVG(temp) AS AVGTemp, MAX(takenDate) AS takenDate FROM tempLog WHERE takenDate = (SELECT MAX(takenDate) FROM tempLog)";
        return $this->executeNonObjectQueryWithArrayResults($sql)[0];
	}
	function get_lastTemp(){
        $sql="SELECT temp, tempUnit, COALESCE(NULLIF(p.notes,''), tl.probe) AS probe, takenDate AS takenDate FROM tempProbes p LEFT JOIN tempLog tl ON (tl.probe = p.name AND tl.takenDate = (SELECT MAX(takenDate) FROM tempLog tl2 WHERE tl2.probe = tl.probe))WHERE p.active = 1 ORDER BY tl.probe ASC";
        return $this->executeNonObjectQueryWithArrayResults($sql);
	}
}
