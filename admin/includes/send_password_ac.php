<?
require("../includes/conn.php");


// value sent from form
$email_to=$_POST['email_to'];


$sql="SELECT password FROM $tbl_name WHERE email='$email_to'";
//$result=mysql_query($sql);
$result=mysqli_query($con, $sql);

// if found this e-mail address, row must be 1 row
// keep value in variable name "$count"
//$count=mysql_num_rows($result);
$count=mysqli_num_rows($result);

// compare if $count =1 row
if($count==1){

//$rows=mysql_fetch_array($result);
$rows=mysqli_fetch_assoc($result);

$your_password=$rows['password'];

// ---------------- SEND MAIL FORM ----------------

// send e-mail to ...
$to=$email_to;

// Your subject
$subject="Your password here";

// From
$header="from: Support";

// Your message
$messages.="This is your password to your login( $your_password ) \r\n";
$messages.="Please Purge this email and update the password within your admin panel after receiving this email. \r\n";

// send email
$sentmail = mail($to,$subject,$messages,$header);

}

// else if $count not equal 1
else {
echo "We Can not find your email in our Database, please go back and retry.";
}

// if your email succesfully sent
{
echo "An email has been sent including the info you have requested.";?><a href="../index.php">Click Here<a/> to go back to the login.
<?php
}
?>
