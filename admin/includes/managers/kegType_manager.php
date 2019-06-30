<?php
require_once __DIR__.'/../models/kegType.php';

class KegTypeManager{

	function GetAll(){
	global $con;
		$sql="SELECT * FROM kegTypes ORDER BY displayName";
		//$qry = mysql_query($sql);
		$qry = mysqli_query($con, $sql);
		
		$kegTypes = array();
		//while($i = mysql_fetch_array($qry)){
		while($i = mysqli_fetch_assoc($qry)){
			$kegType = new KegType();
			$kegType->setFromArray($i);
			$kegTypes[$kegType->get_id()] = $kegType;		
		}
		
		return $kegTypes;
	}
	
	
		
	function GetById($id){
	global $con;
		$sql="SELECT * FROM kegTypes WHERE id = $id";
		//$qry = mysql_query($sql);
		$qry = mysqli_query($con, $sql);
		
		//if( $i = mysql_fetch_array($qry) ){
		if( $i = mysqli_fetch_assoc($qry) ){
			$kegType = new KegType();
			$kegType->setFromArray($i);
			return $kegType;
		}

		return null;
	}
}
