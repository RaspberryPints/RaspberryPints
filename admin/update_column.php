<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
header("location:index.php");
}
require dirname(__FILE__) . '/../includes/config.php';
require dirname(__FILE__) . '/../includes/config_names.php';

foreach($_POST as $k => $v){
	// update data in mysql database
        $data = array(
            'configValue' => $v
        );
        
        $db->where('id', $k)->update('config', $data);
}


echo "<script>location.href='personalize.php';</script>";





?> 
