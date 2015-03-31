<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
header("location:index.php");
}
require dirname(__FILE__) . '/../includes/config.php';
require dirname(__FILE__) . '/../includes/config_names.php';
require_once dirname(__FILE__) . '/includes/functions.php';

// Get values from form 
$header_text=encode($_POST['header_text']);


// update data in mysql database
// if successfully updated.
if($db->where('configName', 'headerText')->update('config', array('configValue' => $header_text))){
echo "Successful";
echo "<BR>";
echo "<script>location.href='personalize.php';</script>";
}

else {
echo "ERROR";
}

?> 
