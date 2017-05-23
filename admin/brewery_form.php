<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
	header("location:index.php");
}
require_once __DIR__.'/../data/config/conn.php';
require_once __DIR__.'/../includes/config_names.php';
require_once __DIR__.'/includes/html_helper.php';
require_once __DIR__.'/includes/functions.php';

require_once __DIR__.'/includes/models/brewery.php';

require_once __DIR__.'/includes/managers/brewery_manager.php';

$htmlHelper = new HtmlHelper();
$breweryManager = new BreweryManager();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$brewery = new Brewery();
	$brewery->setFromArray($_POST);
	$breweryManager->Save($brewery);
	redirect('brewery_list.php');
}

if( isset($_GET['id'])){
	$brewery = $breweryManager->GetById($_GET['id']);
}else{
	$brewery = new Brewery();
}

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
require __DIR__.'/header.php';
?>
	<!-- End Header -->

	<!-- Top Breadcrumb Start -->
	<div id="breadcrumb">
		<ul>
			<li><img src="img/icons/icon_breadcrumb.png" alt="Location" /></li>
			<li><strong>Location:</strong></li>
			<li><a href="brewery_list.php">My Beers</a></li>
			<li>/</li>
			<li class="current">Brewery Form</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End -->

	<!-- Right Side/Main Content Start -->
	<div id="rightside">
		<div class="contentcontainer med left">
	<p>
		Fields marked with <b><font color="red">*</font></b> are required.<br><br>

	<form id="brewery-form" method="POST">
		<input type="hidden" name="id" value="<?php echo $brewery->get_id() ?>" />

		<table width="800" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="100">
					<b>Name:<font color="red">*</font></b>
				</td>
				<td>
					<input type="text" id="name" class="largebox" name="name" value="<?php echo $brewery->get_name() ?>" />
				</td>
			</tr>

			<tr>
				<td>
					<b>SRM:<font color="red">*</font></b>
				</td>
				<td>
					<input type="text" id="imageUrl" class="largebox" name="imageUrl" value="<?php echo $brewery->get_imageUrl() ?>" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input name="save" type="submit" class="btn" value="Save" />
					<input type="button" class="btn" value="Cancel" onclick="window.location='brewery_list.php'" />
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
require __DIR__.'/footer.php';
?>

	<!-- End Footer -->

	</div>
	<!-- Right Side/Main Content End -->
	<!-- Start Left Bar Menu -->
<?php
require __DIR__.'/left_bar.php';
?>
	<!-- End Left Bar Menu -->
	<!-- Start Js  -->
<?php
require __DIR__.'/scripts.php';
?>

<script>
	$(function() {

		$('#brewery-form').validate({
		rules: {
			name: { required: true },
			imageUrl: { required: true }
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
