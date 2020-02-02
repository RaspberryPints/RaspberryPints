<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
	header("location:index.php");
}
require_once __DIR__.'/includes/conn.php';
require_once __DIR__.'/includes/html_helper.php';
require_once __DIR__.'/includes/functions.php';
require_once __DIR__.'/includes/models/beer.php';
require_once __DIR__.'/includes/models/bottle.php';
require_once __DIR__.'/includes/models/brewery.php';
require_once __DIR__.'/includes/managers/srm_manager.php';
require_once __DIR__.'/includes/managers/beer_manager.php';
require_once __DIR__.'/includes/managers/bottle_manager.php';
require_once __DIR__.'/includes/managers/beerStyle_manager.php';
require_once __DIR__.'/includes/managers/bottleType_manager.php';
require_once __DIR__.'/includes/managers/rfidReader_manager.php';
require_once __DIR__.'/includes/managers/motionDetector_manager.php';
require_once __DIR__.'/includes/managers/tempProbe_manager.php';
require_once __DIR__.'/includes/managers/config_manager.php';
require_once 'includes/models/keg.php';
require_once 'includes/models/kegType.php';
require_once 'includes/models/kegStatus.php';
require_once 'includes/managers/keg_manager.php';
require_once 'includes/managers/kegStatus_manager.php';
require_once 'includes/managers/kegType_manager.php';
require_once __DIR__.'/includes/managers/brewery_manager.php';
require_once __DIR__.'/includes/managers/tap_manager.php';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>RaspberryPints</title>
<link href="styles/layout.css" rel="stylesheet" type="text/css" />
<link href="styles/wysiwyg.css" rel="stylesheet" type="text/css" />
    <!-- Theme Start -->
<link href="<?php echo $stylesheet?>" rel="stylesheet" type="text/css" />
    <!-- Theme End -->
<link href='http://fonts.googleapis.com/css?family=Fredoka+One' rel='stylesheet' type='text/css'>
<?php require __DIR__.'/scripts.php'; ?>
<?php if(!isset($noHeadEnd) || !$noHeadEnd){?>
</head>
<?php }?>
