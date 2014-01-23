<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
	header("location:index.php");
}

require_once 'includes/models/tap.php';

require_once 'includes/conn.php';
require_once '../includes/config_names.php';
require_once 'includes/html_helper.php';
require_once 'includes/managers/beer_manager.php';
require_once 'includes/managers/kegType_manager.php';
require_once 'includes/managers/tap_manager.php';

$htmlHelper = new HtmlHelper();
$tapManager = new TapManager();
$beerManager = new BeerManager();
$kegTypeManager = new KegTypeManager();

if( isset($_POST['updateNumberOfTaps'])) {
	$tapManager->updateTapNumber($_POST['numberOfTaps']);	
}

$numberOfTaps = $tapManager->getTapNumber();
$beers = $beerManager->getAllBeers();
$kegTypes = $kegTypeManager->getAllKegTypes();
$activeTaps = $tapManager->getActiveTaps();
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
<?
include 'header.php';
?>
	<!-- End Header -->
        
    <!-- Top Breadcrumb Start -->
    <div id="breadcrumb">
    	<ul>	
        	<li><img src="img/icons/icon_breadcrumb.png" alt="Location" /></li>
        	<li><strong>Location:</strong></li>
            <li><a href="#" title="">Sub Section</a></li>
            <li>/</li>
            <li class="current">Tap List</li>
        </ul>
    </div>
    <!-- Top Breadcrumb End --> 
     
    <!-- Right Side/Main Content Start -->
    <div id="rightside">
		 <div class="contentcontainer med left">
	<p>
	<!-- Set Tap Number Form -->
		<form method="POST" name="taplimit">
			<b>Number Of Taps:</b> &nbsp <input type="text" name="numberOfTaps" class="smallbox" value="<?php echo $numberOfTaps ?>"> &nbsp <input type="submit" name="updateNumberOfTaps" class="btn" value="Update Number of Taps" />
		</form>
	</p>
	<!-- End Tap Number Form -->
<br />
	<!-- Start On Tap Section -->
		<form>
		<table width="950" border="0" cellspacing="0" cellpadding="0">
			<thead>
			<tr>
				<th>
					<b>Tap #</b>
				</th>
				<th>
					<b>Beer Name</b>
				</th>
				<th colspan="8">
					<b>Vitals This Batch</b>
				</th>
				<th colspan="3">
					<b>Keg Info</b>
				</th>
			</tr>
			</thead>
		<tbody>
		
			<?php 
				for($c = 1; $c <= $numberOfTaps; $c++ ){ 
					if( array_key_exists($c, $activeTaps) )
						$tap = $activeTaps[$c];
					else
						$tap = new Tap();
			?>
					<tr>
						<td>
							<?php echo $c ?>
						</td>
						
						<td>
							<?php echo $htmlHelper->ToSelectList($c."_beerId", $beers, "name", "id", $tap->get_beerId(), "~Inactive~") ?>
						</td>
						
						<td>
							<label for="<?php echo $c?>_srm">srm:</label>
						</td>						
						<td>
							<input type="text" id="<?php echo $c?>_srm" name="<?php echo $c?>_srm" class="smallbox" value="<?php echo $tap->get_srm() ?>">
						</td>						
						<td>							
							<label for="<?php echo $c?>_ibu">ibu:</label>
						</td>
						
						<td>
							<input type="text" id="<?php echo $c?>_ibu" name="<?php echo $c?>_ibu" class="smallbox" value="<?php echo $tap->get_ibu() ?>">
						</td>						
						<td>							
							<label for="<?php echo $c?>_og">og:</label>
						</td>
						
						<td>
							<input type="text" id="<?php echo $c?>_og" name="<?php echo $c?>_og" class="smallbox" value="<?php echo $tap->get_og() ?>">
						</td>						
						<td>
							<label for="<?php echo $c?>_fg">fg:</label>
						</td>
						
						<td>
							<input type="text" id="<?php echo $c?>_fg" name="<?php echo $c?>_fg" class="smallbox" value="<?php echo $tap->get_fg() ?>">
							
						</td>
					</tr>
			<?php 
				} 
			?>
		

		</tbody>
		</table>
<br />
		<div align="right">
			<input type="submit" class="btn" value="Save" /> &nbsp &nbsp <input type="submit" class="btn" value="Reset" />
		</div>
		
        </div>
	<!-- End On Tap Section -->

    <!-- Start Footer -->   
<? 
include 'footer.php';
?>

	<!-- End Footer -->
          
    </div>
    <!-- Right Side/Main Content End -->
	<!-- Start Left Bar Menu -->   
<? 
include 'left_bar.php';
?>
	<!-- End Left Bar Menu -->  
	<!-- Start Js  -->
<?
include 'scripts.php';
?>
	<!-- End Js -->
    <!--[if IE 6]>
    <script type='text/javascript' src='scripts/png_fix.js'></script>
    <script type='text/javascript'>
      DD_belatedPNG.fix('img, .notifycount, .selected');
    </script>
    <![endif]--> 
</body>
</html>