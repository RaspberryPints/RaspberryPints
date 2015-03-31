<?php
session_start();
$session=session_id();
$time=time();
$time_check=$time-1800; //SET TIME 10 Minute

require_once dirname(__FILE__) . '/../../includes/config.php';

// username and password sent from form
$myusername=$_POST['myusername'];
$mypassword=md5($_POST['mypassword']);

$user = $db->where('username', $myusername)->where('password', $mypassword)->getOne('users');

// If result matched $myusername and $mypassword, table row must be 1 row
if($db->count > 0){
    // Register $myusername, $mypassword and redirect to file "admin.php"
    $_SESSION['myusername'] =$myusername;
    $_SESSION['mypassword'] =$mypassword;

    echo "<script>location.href='../admin.php';</script>";
} else {
    echo "<script>location.href='../index2.php';</script>";
}
?>
