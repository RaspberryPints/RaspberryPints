<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
	//header("location:index.php");
}
require 'conn.php';
require_once '../includes/functions.php';


$sql="INSERT INTO beers (name, style, notes, ogEst, fgEst, srmEst, ibuEst, recipe, modifiedDate) VALUES ('$_POST[name]','$_POST[style]','$_POST[notes]','$_POST[ogEst]','$_POST[fgEst]','$_POST[srmEst]','$_POST[ibuEst]', '$_POST[recipe]', NOW())";

if (!mysql_query($sql)) {
die('Error: ' . mysql_error());
}

	redirect('../beer_main.php');
