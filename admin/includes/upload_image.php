<?php 
$target = $_POST['target'];
$ok=1; 

//This is our size condition 
if (filesize($target) > 1000000) 
{ 
    echo "Your file is too large.<br>"; 
    $ok=0; 
} 

$path_parts = pathinfo($target);
$uploaded_type = $path_parts['extension'];
//This is our limit file type condition 
if ($uploaded_type =="php") 
{ 
    echo "No PHP files<br>"; 
    $ok=0; 
} 

//Here we check that $ok was not set to 0 by an error 
if ($ok==0) 
{ 
  echo "Sorry your file was not uploaded"; 
} 
//If everything is ok we try to upload it 
else 
{ 
    if(move_uploaded_file($_FILES['uploaded']['tmp_name'], $target)) 
    { 
		$jumpto="";
		if(isset($_POST['jumpto']))$jumpto = (!strpos($_POST['jumpto'],"#")?"":"#").$_POST['jumpto'];
		echo "<script>location.href='../personalize.php".$jumpto."';</script>";
    } 
    else 
    { 
        echo "Sorry, there was a problem uploading your file."; 
    } 
} 
?> 
