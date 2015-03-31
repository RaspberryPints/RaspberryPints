<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
	//header("location:index.php");
}
require_once dirname(__FILE__) . '/../../includes/config.php';
require_once dirname(__FILE__) . '/functions.php';


$data = array(
    'name' => $_POST['name'],
    'style' => $_POST['style'],
    'notes' => $_POST['notes'],
    'ogEst' => $_POST['ogEst'],
    'fgEst' => $_POST['fgEst'],
    'srmEst' => $_POST['srmEst'],
    'ibuEst' => $_POST['ibuEst'],
    'modifiedDate' => 'NOW()'
)

$db->insert('beers', $data);

if (!mysql_query($sql)) {
die('Error: ' . mysql_error());
}

	redirect('../beer_main.php');
