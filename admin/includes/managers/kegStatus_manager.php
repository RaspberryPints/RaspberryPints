<?php
require_once __DIR__.'/../models/kegStatus.php';
require_once __DIR__.'/../conn.php';

class KegStatusManager{

	function GetAll(){
        global $con;
		$sql="SELECT * FROM kegStatuses ORDER BY name";
		//$qry = mysql_query($sql);
        $qry = mysqli_query($con, $sql);
		
		$kegStatuses = array();
		//while($i = mysql_fetch_array($qry)){
        while($i = mysqli_fetch_assoc($qry)){
			$kegStatus = new KegStatus();
			$kegStatus->setFromArray($i);
			$kegStatuses[$kegStatus->get_code()] = $kegStatus;		
		}
		
		return $kegStatuses;
	}	
		
	function GetByCode($code){
        global $con;
		$sql="SELECT * FROM kegStatuses WHERE code = '$code'";
		//$qry = mysql_query($sql);
        $qry = mysqli_query($con, $sql);
		
		//if( $i = mysql_fetch_array($qry) ){
        if( $i = mysqli_fetch_assoc($qry) ){
			$kegStatus = new KegStatus();
			$kegStatus->setFromArray($i);
			return $kegStatus;
		}

		return null;
	}
	
}
