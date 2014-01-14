<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
header("location:index.php");
}

$file = 'img/background.jpg';
$newfile = '../img/background.jpg';

if (!copy($file, $newfile)) {
    echo "failed to copy $file...\n";
}
else {
echo "<script>location.href='personalize.php';</script>";
 } 
?>
