<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
header("location:index.php");
}
require 'includes/conn.php';
require '../includes/config_names.php';
require_once 'includes/functions.php';

// Get values from form 
$header_text=encode($_POST['header_text']);




// update data in mysql database
$sql="UPDATE config SET configValue='$header_text' WHERE configName ='headerText'";
$result=mysql_query($sql);

// if successfully updated.
if($result){
echo "Successful";
echo "<BR>";
echo "<script>location.href='personalize.php';</script>";
}

else {
echo "ERROR";
}

?> 
