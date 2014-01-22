<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
	//header("location:index.php");
}
require 'conn.php';


$sql="INSERT INTO beers (name, style, notes, ogEst, fgEst, srmEst, ibuEst, createdDate, modifiedDate) VALUES ('$_POST[name]','$_POST[style]','$_POST[notes]','$_POST[og]','$_POST[fg]','$_POST[srm]','$_POST[ibu]', NOW(), NOW())";

if (!mysql_query($sql)) {
  die('Error: ' . mysql_error());
}

header("Location: ../beer_main.php");