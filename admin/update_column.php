<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
header("location:index.php");
}
require 'includes/conn.php';
require '../includes/config_names.php';
require 'includes/configp.php';



// Get values from form 
$name=$_POST['id'];
$config_Value=$_POST['configValue'];

foreach($_POST as $k => $v){
	// update data in mysql database
	$stmt = $conn->prepare("UPDATE config SET configValue=:configValue WHERE id=:id");
	$stmt->bindParam(':configValue', $v, PDO::PARAM_STR);
	$stmt->bindParam(':id', $k, PDO::PARAM_STR);
	$result = $stmt->execute();
}


echo "<script>location.href='personalize.php';</script>";





?> 
