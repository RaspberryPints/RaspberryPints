<?php
require_once __DIR__.'/../models/kegType.php';

class KegTypeManager{

	function GetAll(){
		$sql="SELECT * FROM kegTypes ORDER BY displayName";
		$qry = mysql_query($sql);
		
		$kegTypes = array();
		while($i = mysql_fetch_array($qry)){
			$kegType = new KegType();
			$kegType->setFromArray($i);
			$kegTypes[$kegType->get_id()] = $kegType;		
		}
		
		return $kegTypes;
	}
	
	
		
	function GetById($id){
		$sql="SELECT * FROM kegTypes WHERE id = $id";
		$qry = mysql_query($sql);
		
		if( $i = mysql_fetch_array($qry) ){		
			$kegType = new KegType();
			$kegType->setFromArray($i);
			return $kegType;
		}

		return null;
	}
}