<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
	header("location:index.php");
}
require_once 'includes/conn.php';
require_once '../includes/config_names.php';
require_once 'includes/html_helper.php';
require_once 'includes/functions.php';

require_once 'includes/models/bottle.php';
require_once 'includes/models/bottleType.php';
require_once 'includes/models/kegStatus.php';

require_once 'includes/managers/bottle_manager.php';
require_once 'includes/managers/kegStatus_manager.php';
require_once 'includes/managers/bottleType_manager.php';

$htmlHelper = new HtmlHelper();
$bottleManager = new BottleManager();
$kegStatusManager = new KegStatusManager();
$bottleTypeManager = new BottleTypeManager();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$bottle = new Bottle();
	$bottle->setFromArray($_POST);
	$bottleManager->Save($bottle);
	redirect('bottle_list.php');
}

if( isset($_GET['id'])){
	$bottle = $bottleManager->GetById($_GET['id']);
}else{
	$bottle = new Bottle();
}

$kegStatusList = $kegStatusManager->GetAll();
$bottleTypeList = $bottleTypeManager->GetAll();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>RaspberryPints</title>
<link href="styles/layout.css" rel="stylesheet" type="text/css" />
<link href="styles/wysiwyg.css" rel="stylesheet" type="text/css" />
	<!-- Theme Start -->
<link href="styles.css" rel="stylesheet" type="text/css" />
	<!-- Theme End -->
<link href='http://fonts.googleapis.com/css?family=Fredoka+One' rel='stylesheet' type='text/css'>
</head>
	<!-- Start Header  -->
<?php
include 'header.php';
?>
	<!-- End Header -->
		
	<!-- Top Breadcrumb Start -->
	<div id="breadcrumb">
		<ul>	
			<li><img src="img/icons/icon_breadcrumb.png" alt="Location" /></li>
			<li><strong>Location:</strong></li>
			<li><a href="keg_list.php">Bottle List</a></li>
			<li>/</li>
			<li class="current">Bottle Form</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End --> 
	
	<!-- Right Side/Main Content Start -->
	<div id="rightside">
		<div class="contentcontainer med left">
	<p>
		fields marked with an * are required

	<form id="keg-form" method="POST">
		<input type="hidden" name="id" value="<?php echo $bottle->get_id() ?>" />

		<table width="950" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td>
					Label: <b><font color="red">*</color></b>
				</td>
				<td>
					<input type="text" id="label" class="mediumbox" name="label" value="<?php echo $bottle->get_label() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Type: <b><font color="red">*</color></b>
				</td>
				<td>
					<?php echo $htmlHelper->ToSelectList("bottleTypeId", $bottleTypeList, "name", "id", $bottle->get_bottleTypeId(), "Select One"); ?>
				</td>
			</tr>	
			<tr>
				<td>
					Stamped Owner:
				</td>
				<td>
					<input type="text" id="stampedOwner" class="mediumbox" name="stampedOwner" value="<?php echo $bottle->get_stampedOwner() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Stamped Location:
				</td>
				<td>
					<input type="text" id="stampedLoc" class="mediumbox" name="stampedLoc" value="<?php echo $bottle->get_stampedLoc() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Notes:
				</td>
				<td>
					<textarea id="notes" class="text-input textarea" name="notes" style="width:500px;height:100px"><?php echo $bottle->get_stampedOwner() ?></textarea>
				</td>
			</tr>
			<tr>
				<td>
					Status: <b><font color="red">*</color></b>
				</td>
				<td>
					<?php echo $htmlHelper->ToSelectList("kegStatusCode", $kegStatusList, "name", "code", $bottle->get_kegStatusCode(), "Select One"); ?>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input name="save" type="submit" class="btn" value="Save" />
					<input type="button" class="btn" value="Cancel" onclick="window.location='bottle_list.php'" />
				</td>
			</tr>								
		</table>
		<br />
		<div align="right">			
			&nbsp &nbsp 
		</div>

	</form>
	</div>
	<!-- End On Tap Section -->

	<!-- Start Footer -->   
<?php 
include 'footer.php';
?>

	<!-- End Footer -->
		
	</div>
	<!-- Right Side/Main Content End -->
	<!-- Start Left Bar Menu -->   
<?php 
include 'left_bar.php';
?>
	<!-- End Left Bar Menu -->  
	<!-- Start Js  -->
<?php
include 'scripts.php';
?>

<script>
	$(function() {		
		
		$('#keg-form').validate({
		rules: {
			label: { required: true, number: true },
			weight: {required:true, number:true),
			kegTypeId: { required: true },
			kegStatusCode: { required: true }
		}
		});
		
	});
</script>

	<!-- End Js -->
	<!--[if IE 6]>
	<script type='text/javascript' src='scripts/png_fix.js'></script>
	<script type='text/javascript'>
	DD_belatedPNG.fix('img, .notifycount, .selected');
	</script>
	<![endif]--> 
	
</body>
</html>
