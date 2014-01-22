<?php


function updateTapNumber($newTapNumber){
	$sql="UPDATE config SET configValue = $newTapNumber WHERE configName = '".ConfigNames::NumberOfTaps."'";
	mysql_query($sql);
	
	$sql="UPDATE taps SET active = 0, modifiedDate = NOW() WHERE active = 1 AND tapNumber > $newTapNumber";
	mysql_query($sql);
}

function getTapNumber(){
	$sql="SELECT configValue FROM config WHERE configName = '".ConfigNames::NumberOfTaps."'";

	$qry = mysql_query($sql);
	$config = mysql_fetch_array($qry);
	
	if( $config != false ){
		return $config['configValue'];
	}
}

function getAllBeers(){
	$sql="SELECT * FROM beers";
	$qry = mysql_query($sql);
	
	$beers = array();
	while($b = mysql_fetch_array($qry)){
		$beer = array(
			"id" => $b['id'],
			"name" => $b['name'],
			"og" => $b['ogEst'],
			"fg" => $b['fgEst'],
			"srm" => $b['srmEst'],
			"ibu" => $b['ibuEst']
		);
		$beers[$b['id']] = $beer;
	}
	
	return $beers;
}

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

function getActiveTaps(){
	$sql="SELECT * FROM taps WHERE active = 1";
	$qry = mysql_query($sql);
	
	$taps = array();
	while($t = mysql_fetch_array($qry)){
		$tap = array(
			"id" => $t['id'],
			"beerId" => $t['beerId'],
			"kegTypeId" => $t['kegTypeId'],
			"tapNumber" => $t['tapNumber'],
			"og" => $t['ogAct'],
			"fg" => $t['fgAct'],
			"srm" => $t['srmAct'],
			"ibu" => $t['ibuAct'],
			"startAmount" => $t['startAmount']
		);
		$taps[$t['tapNumber']] = $tap;
	}
	
	return $taps;
}