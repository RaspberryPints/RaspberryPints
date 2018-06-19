<?php
session_start();
$session=session_id();
$time=time();
$time_check=$time-1800; //SET TIME 10 Minute

require_once __DIR__.'/managers/user_manager.php';

// username and password sent from form
$myusername=$_POST['myusername'];
$mypassword=md5($_POST['mypassword']);

$userManager = new UserManager();
$user = $userManager->checklogin($myusername, $mypassword);

// If result matched $myusername and $mypassword, 
if($user){
	$_SESSION['myusername'] =$myusername;
	$_SESSION['mypassword'] =$mypassword;
	$_SESSION['showadmin'] =false;
	
	if($user->get_isAdmin()){
		$_SESSION['showadmin'] =true;
	}
		echo "<script>location.href='../admin.php';</script>";
}
else {
	echo "<script>location.href='../index.php?wrong';</script>";
}
?>
