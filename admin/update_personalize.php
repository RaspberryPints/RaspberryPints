<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
header("location:index.php");
}
require 'includes/config.php';
require '../includes/config_names.php';


// Get values from form 
$id=$_POST['id'];
$config_value=$_POST['config_value'];




// update data in mysql database
$sql="UPDATE config SET config_value='$config_value' WHERE id='$id'";
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
