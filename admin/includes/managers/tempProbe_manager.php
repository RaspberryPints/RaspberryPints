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
	    $ret = array();
	    $probes = $this->GetAllActive();
	    foreach( $probes as $probe)
	    {
	       $sql="SELECT temp, tempUnit, probe, takenDate FROM tempLog WHERE probe = '".$probe->get_name()."' ORDER BY takenDate DESC LIMIT 1";
	       $tlog = $this->executeNonObjectQueryWithArrayResults($sql);
           if( count($tlog) > 0)
           {
               if($probe->get_notes() !== '') $tlog[0]["probe"] = $probe->get_notes();
               array_push($ret, $tlog[0]);
           }
	    }
        return $ret;
	}
}
