<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
header("location:index.php");
}
require 'includes/conn.php';


// Get values from form 
$name=$_POST['name'];
$style=$_POST['style'];
$notes=$_POST['notes'];
$og=$_POST['og'];
$fg=$_POST['fg'];
$srm=$_POST['srm'];
$ibu=$_POST['ibu'];
$active=$_POST['active'];
$tapnumber=$_POST['tapnumber'];
$beerid=$_POST['beerid'];



// update data in mysql database
$sql="UPDATE beers SET name='$name', style='$style', notes='$notes', og='$og', fg='$fg', srm='$srm', 
ibu='$ibu', active='$active', tapnumber='$tapnumber' WHERE beerid='$beerid'";
$result=mysqli_query($sql);

// if successfully updated.
if($result){
echo "Successful";
echo "<BR>";
echo "<a href='beer_main.php'>Back To Beers</a>";
}

else {
echo "ERROR";
}

?> 
