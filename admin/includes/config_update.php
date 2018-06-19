<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
	header("location:index.php");
}
require_once __DIR__.'/managers/config_manager.php';

$result=saveConfigValue($_POST['configName'], $_POST['configValue']);

// if successfully updated.
if($result){
	echo "Successful";
	echo "<BR>";
	$jumpto="";
	if(isset($_POST['jumpto']))$jumpto = (!strpos($_POST['jumpto'],"#")?"":"#").$_POST['jumpto'];
	echo "<script>location.href='../personalize.php".$jumpto."';</script>";
}
else 
{
	echo "ERROR";
}

?> 
