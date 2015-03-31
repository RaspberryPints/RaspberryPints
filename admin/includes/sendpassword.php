<?php
session_start();
require_once dirname(__FILE__) . '/../../includes/config.php';

// Get values from form 
$password=md5($_POST['password']);
$email=($_POST['email']);
	
// update data in mysql database
$result=$db->where('email', $email)->update('users', array('password'=>$password);

// if successfully updated.
if($result){
    echo "Successful";
    echo "<BR>";
    echo "<script>location.href='../index.php';</script>";
} else {
    echo "ERROR";
}
?> 
