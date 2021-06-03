<?php
require_once __DIR__.'/../admin/includes/managers/config_manager.php';
/** @var mixed $editingTable **/
/** @var mixed $noTableHead **/
/** @var mixed $beers **/
/** @var mixed $numberOfBeers **/
/** @var mixed $numberOfPours **/
/** @var mixed $tapOrBottle **/
/** @var mixed $pours **/
	$numberOfBeers;
	$beers;
	$tapOrBottle;
	$pours;
	function printBeerList($beerList, $beerListSize, $containerType, $editing = FALSE)
	{
		global $numberOfBeers,$beers,$tapOrBottle;
		$beers = $beerList;
		$numberOfBeers = $beerListSize;
		$tapOrBottle = $containerType;
		$editingTable = $editing;
		$config = getAllConfigs();
		//if( $editing ) $config[ConfigNames::ShowVerticleTapList] = "1";
		if($config[ConfigNames::ShowVerticleTapList]){
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
	
	function beerListShouldDisplayRow($editting, $col, $configValue){
	    return ($col == ($editting?abs($configValue):$configValue));
	}
	
	function DisplayEditShowColumn($editting, $config, $col, $configName){
	    if( !$editting ) return;

	    //if display vertically then add table data, otherwise just add a new line
	    if($config[ConfigNames::ShowVerticleTapList] != '1')echo '<br/>';
	    if($config[ConfigNames::ShowVerticleTapList] == '1')echo '<td>';
	    echo '<input type="radio" value="1"  name="show'.$configName.'" id="show'.$configName.'" '.($config[$configName] > 0?"checked":"").'/>Visible';
	    echo '<input type="radio" value="-1" name="show'.$configName.'" id="show'.$configName.'" '.($config[$configName] < 0?"checked":"").'/>Hidden';
	    if($config[ConfigNames::ShowVerticleTapList] == '1')echo '</td>';
	}
?>