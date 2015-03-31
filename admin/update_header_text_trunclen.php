<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
header("location:index.php");
}
require dirname(__FILE__) . '/../includes/config.php';
require dirname(__FILE__) . '/../includes/config_names.php';

// Get values from form 
$header_text_trunclen=$_POST['header_text_trunclen'];

// update data in mysql database
// if successfully updated.
if($db->where('configName', 'headerTextTruncLen')->update('config', array('configValue' => $header_text_trunclen))){
echo "Successful";
echo "<BR>";
echo "<script>location.href='personalize.php';</script>";
}

else {
echo "ERROR";
}

?> 
