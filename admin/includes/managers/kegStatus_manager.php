<?php
require_once __DIR__.'/../models/kegStatus.php';

class KegStatusManager{

	function GetAll(mysqli $con){
		$sql="SELECT * FROM kegStatuses ORDER BY name";
		$qry = mysqli_query($con,$sql);
		
		$kegStatuses = array();
		while($i = mysqli_fetch_array($qry)){
			$kegStatus = new KegStatus();
			$kegStatus->setFromArray($i);
			$kegStatuses[$kegStatus->get_code()] = $kegStatus;		
		}
		
		return $kegStatuses;
	}	
		
	function GetByCode(mysqli $con, $code){
		$sql="SELECT * FROM kegStatuses WHERE code = '" . $code . "'";
		$qry = mysqli_query($con,$sql);
		
		if( $i = mysqli_fetch_array($qry) ){		
			$kegStatus = new KegStatus();
			$kegStatus->setFromArray($i);
			return $kegStatus;
		}

		return null;
	}
	
}
