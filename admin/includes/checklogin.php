<?php
session_start();
/** @var mixed $session */
$session=session_id();
$time=time();
/** @var mixed $time_check */
$time_check=$time-1800; //SET TIME 10 Minute

require_once __DIR__.'/managers/user_manager.php';

// username and password sent from form
$myusername=$_POST['myusername'];
$mypassword=md5($_POST['mypassword']);

$userManager = new UserManager();
$user = $userManager->checklogin($myusername, $mypassword);

// If result matched $myusername and $mypassword, 
if($user){
	$_SESSION['myuserid']  =$user->get_id();
	$_SESSION['myusername'] =$myusername;
	$_SESSION['mypassword'] =$mypassword;
	$_SESSION['showadmin'] =false;
	
	if($user->get_isAdmin()){
		$_SESSION['showadmin'] =true;
	}
	if( !isset($_POST["jumpto"]) || empty($_POST["jumpto"]) )
	{
		echo "<script>location.href='../admin.php';</script>";
	}
	else
	{
		echo "<script>location.href='".$_POST["jumpto"]."';</script>";
	}
}
else {
    echo "<script>location.href='".("../index.php?wrong".(( isset($_POST["jumpto"]) && !empty($_POST["jumpto"]) )?"&ret=".$_POST["jumpto"]:""))."';</script>";
}
?>
