<?php
require_once __DIR__.'/../models/kegType.php';

class BottleTypeManager{

	function GetAll(){
		$sql="SELECT * FROM bottleTypes ORDER BY displayName";
		$qry = mysql_query($sql);
		
		$bottleTypes = array();
		while($i = mysql_fetch_array($qry)){
			$bottleType = new BottleType();
			$bottleType->setFromArray($i);
			$bottleTypes[$bottleType->get_id()] = $bottleType;		
		}
		
		return $bottleTypes;
	}
	
	
		
	function GetById($id){
		$sql="SELECT * FROM bottleTypes WHERE id = $id";
		$qry = mysql_query($sql);
		
		if( $i = mysql_fetch_array($qry) ){		
			$bottleType = new KegType();
			$bottleType->setFromArray($i);
			return $bottleType;
		}

		return null;
	}
}