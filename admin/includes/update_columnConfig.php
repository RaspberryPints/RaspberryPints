<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
	header("location:index.php");
}
require __DIR__.'/managers/config_manager.php';

foreach($_POST as $k => $v){
	// update data in mysql database
	saveConfigValue($k, $v);
}


echo "<script>location.href='../personalize.php';</script>";
?> 
