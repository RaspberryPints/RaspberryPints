<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
header("location:index.php");
}
require 'includes/config.php';
require '../includes/config_names.php';
require 'includes/congifp.php';



// Get values from form 
$name=$_POST['id'];
$config_value=$_POST['config_value'];

foreach($_POST as $k => $v){
	// update data in mysql database
	$stmt = $conn->prepare("UPDATE config SET config_value=:config_value WHERE id=:id");
	$stmt->bindParam(':config_value', $v, PDO::PARAM_STR);
	$stmt->bindParam(':id', $k, PDO::PARAM_STR);
	$result = $stmt->execute();
}


echo "<script>location.href='personalize.php';</script>";





?> 
