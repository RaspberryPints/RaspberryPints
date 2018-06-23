<?php
	require_once __DIR__.'/../admin/includes/managers/config_manager.php';
	$numberOfBeers;
	$beers;
	$tapOrBottle;
	$pours;
	function printBeerList($beerList, $beerListSize, $containerType)
	{
		global $numberOfBeers,$beers,$tapOrBottle;
		$beers = $beerList;
		$numberOfBeers = $beerListSize;
		$tapOrBottle = $containerType;
		$config = getAllConfigs();
		if($config[ConfigNames::ShowVerticalTapList]){
		  include "beerListTableVerticle.php";
		} else {
		    include "beerListTable.php";		
		}
	}
	
	$pours;
	function printPoursList($pourList)
	{
		global $pours;
		$pours = $pourList;
		$numberOfPours = count($pours);
		include "pourListTable.php";
	}

?>