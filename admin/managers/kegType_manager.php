<?php
class KegTypeManager{

	function getAllKegTypes(){
		$sql="SELECT * FROM kegTypes";
		$qry = mysql_query($sql);
		
		$types = array();
		while($t = mysql_fetch_array($qry)){
			$type = array(
				"id" => $t['id'],
				"name" => $t['displayName'],
				"maxAmount" => $t['maxAmount']
			);
			$types[$t['id']] = $type;
		}
		
		return $types;
	}
}