<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
header("location:index.php");
}
require_once 'includes/conn.php';


// Get values from form 
$name=$_POST['name'];
$style=$_POST['style'];
$brewery=$_POST['brewery'];
$notes=$_POST['notes'];
$abv=$_POST['abv'];
$og=$_POST['og'];
$fg=$_POST['fg'];
$srm=$_POST['srm'];
$ibu=$_POST['ibu'];
$active=$_POST['active'];
$tapnumber=$_POST['tapnumber'];
$beerid=$_POST['beerid'];
$rating=$_POST['rating'];



// update data in mysql database
$sql="UPDATE beers SET name='$name', style='$style', notes='$notes', abv='$abv', og='$og', fg='$fg', srm='$srm', 
ibu='$ibu', breweryId='$brewery', active='$active', tapnumber='$tapnumber', rating=$rating WHERE beerid='$beerid'";
$result=$mysqli->query($sql);

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
