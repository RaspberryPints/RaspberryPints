<?
require("../../data/config/conn.php");

// value sent from form
$email_to=$_POST['email_tou'];


$sql="SELECT username FROM $tbl_name WHERE email='$email_to'";
$result=mysql_query($sql);

// if found this e-mail address, row must be 1 row
// keep value in variable name "$count"
$count=mysql_num_rows($result);

// compare if $count =1 row
if($count==1){

$rows=mysql_fetch_array($result);

$your_username=$rows['username'];

// ---------------- SEND MAIL FORM ----------------

// send e-mail to ...
$to=$email_to;

// Your subject
$subject="Your username";

// From
$header="from: Support <shawn@besmartdesigns.com>";

// Your message
$messages.="This is your username to your login ( $your_username ) \r\n";

// send email
$sentmail = mail($to,$subject,$messages,$header);

}

// else if $count not equal 1
else {
echo "Error ";
}

// if your email succesfully sent
{
echo "An email has been sent including the info you have requested.";?><a href="../index.php">Click Here<a/> to go back to the login.
<?php
}
?>
