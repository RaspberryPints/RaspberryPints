<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
	header("location:index.php");
}
require_once __DIR__.'/includes/conn.php';
require_once __DIR__.'/../includes/config_names.php';
require_once __DIR__.'/includes/html_helper.php';
require_once __DIR__.'/includes/functions.php';
require_once __DIR__.'/includes/models/beer.php';
require_once __DIR__.'/includes/managers/beer_manager.php';
require_once __DIR__.'/includes/managers/beerStyle_manager.php';
require_once __DIR__.'/includes/config_manager.php';
require_once 'includes/models/keg.php';
require_once 'includes/models/kegType.php';
require_once 'includes/models/kegStatus.php';
require_once 'includes/managers/keg_manager.php';
require_once 'includes/managers/kegStatus_manager.php';
require_once 'includes/managers/kegType_manager.php';
require_once __DIR__.'/includes/managers/tap_manager.php';

$sql="SELECT configValue FROM config WHERE configName ='".ConfigNames::AdminThemeColor."'";
            $result=mysql_query($sql);
            $stylesheet=mysql_fetch_array($result);

require_once __DIR__.'/includes/configp.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>RaspberryPints</title>
<link href="styles/layout.css" rel="stylesheet" type="text/css" />
<link href="styles/wysiwyg.css" rel="stylesheet" type="text/css" />
    <!-- Theme Start -->
<link href="<?php echo $stylesheet['configValue']?>" rel="stylesheet" type="text/css" />
    <!-- Theme End -->
<link href='http://fonts.googleapis.com/css?family=Fredoka+One' rel='stylesheet' type='text/css'>
</head>
