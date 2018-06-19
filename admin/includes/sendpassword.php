<?php
session_start();
require 'conn.php';

// Get values from form 
$password=md5($_POST['password']);
$email=($_POST['email']);
	
// update data in mysql database
$sql="UPDATE users SET password='$password' WHERE email='$email'";
$result=$mysqli->query($sql);

// if successfully updated.
if($result){
echo "Successful";
echo "<BR>";
echo "<script>location.href='../index.php';</script>";
}

else {
echo "ERROR";
}

?> 
