<?php
require 'includes/config.php';


// Get values from form 
$name=$_POST['name'];
$tapnumber=$_POST['tapnumber'];
$beerid=$_POST['beerid'];



// update data in mysql database
$sql="UPDATE $tbl_name SET name='$name', tapnumber='$tapnumber' WHERE beerid='$beerid'";
$result=mysql_query($sql);

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