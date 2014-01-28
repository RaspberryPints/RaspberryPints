<?php
require_once __DIR__.'/../models/kegStatus.php';

class KegStatusManager{

	function GetAll(){
		$sql="SELECT * FROM kegStatuses";
		$qry = mysql_query($sql);
		
		$kegStatuses = array();
		while($i = mysql_fetch_array($qry)){
			$kegStatus = new KegStatus();
			$kegStatus->setFromArray($i);
			$kegStatuses[$kegStatus->get_code()] = $kegStatus;		
		}
		
		return $kegStatuses;
	}	
		
	function GetByCode($code){
		$sql="SELECT * FROM kegStatuses WHERE code = '$code'";
		$qry = mysql_query($sql);
		
		if( $i = mysql_fetch_array($qry) ){		
			$kegStatus = new KegStatus();
			$kegStatus->setFromArray($i);
			return $kegStatus;
		}

		return null;
	}
	
}