<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
	header("location:index.php");
}

require_once __DIR__.'/includes/conn.php';
require_once __DIR__.'/../includes/config_names.php';
require_once __DIR__.'/includes/html_helper.php';
require_once __DIR__.'/includes/functions.php';

require_once __DIR__.'/includes/models/brewery.php';

require_once __DIR__.'/includes/managers/brewery_manager.php';

$htmlHelper = new HtmlHelper();
$breweryManager = new BreweryManager();


$breweries = $breweryManager->GetAll();
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
			<li class="current">Breweries</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End -->

	<!-- Right Side/Main Content Start -->
<div id="rightside">
	<div class="contentcontainer lg left">
		<div class="headings alt">
			<h2>Breweries </h2>
		</div>
		<div class="contentbox">

			<!-- Start On Tap Section -->

			<?php $htmlHelper->ShowMessage(); ?>

			<input type="submit" class="btn" value="Add Brewery" onclick="window.location='brewery_form.php'" />
			<br/><br/>

			<table width="770px" cellspacing="0" cellpadding="0" class="outerborder">

				<tbody>
					<?php
						if( count($breweries) == 0 ){
					?>
							<tr><td class="no-results" colspan="99">No Breweries :( Add some?</td></tr>
					<?php
						}else{
							foreach ($breweries as $brewery){
					?>
								<tr class="intborder">
									<th width="35%" style="vertical-align: middle;">
										<h3><?php echo $brewery->get_name() ?></h3>
									</th>
									<th width="35%" style="vertical-align: middle;">
										<h3><?php echo $brewery->get_imageUrl() ?></h3>
									</th>
									<th align="center" width="5%" style="text-align: center; vertical-align: middle; margin: 0; padding: 0;">
										<input name="editBrewery" type="button" class="btn" value="Edit" style="text-align: center; margin: 0;" onclick="window.location='brewery_form.php?id=<?php echo $brewery->get_id()?>'" />
									</th>
									<th align="center" width="5%" style="text-align: center; vertical-align: middle; margin: 0; padding: 0">
										<form method="POST">
											<input type='hidden' name='id' value='<?php echo $brewery->get_id()?> '/>
											<input class="inactivateBeer btn" style="text-align: center; margin: 0;" name="inactivateBrewery" type="submit" value="Delete" />
										</form>
									</th>
								</tr>
					<?php
							}
						}
					?>
				</tbody>
			</table><br>
			<input type="submit" class="btn" value="Add Brewery" onclick="window.location='brewery_form.php'" />
		</div>
	</div>
	<!-- Start Footer -->
	<?php
	include 'footer.php';
	?>
	<!-- End Footer -->
</div>
</div>
	<!-- End On Tap Section -->
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
	$(function(){
		$('.inactivateBrewery').on('click', function(){
			if(!confirm('Are you sure you want to delete this brewery?')){
				return false;
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
