<?php
session_start();
$session=session_id();
$time=time();
$time_check=$time-1800; //SET TIME 10 Minute

$host="localhost";
$username="TapList45"; 
$password=""; 
$db_name="TapList45"; 
$tbl_name="Users"; 

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die("cannot connect");
mysql_select_db("$db_name")or die("cannot select DB");

// username and password sent from form
$myusername=$_POST['myusername'];
$mypassword=md5($_POST['mypassword']);

// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);

$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);


$sql="SELECT * FROM $tbl_name WHERE username='$myusername' and password='$mypassword'";
$result=mysql_query($sql);

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);
// If result matched $myusername and $mypassword, table row must be 1 row
if($count==1){
// Register $myusername, $mypassword and redirect to file "admin.php"
$_SESSION['myusername'] =$myusername;
$_SESSION['mypassword'] =$mypassword;
//session_register("myusername");
//session_register("mypassword");

header("location:../admin.php");
}
else {

header("Location: ../index2.php"); 
}
?>
