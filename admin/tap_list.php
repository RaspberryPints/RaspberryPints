<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
	header("location:index.php");
}

require_once __DIR__.'/includes/conn.php';
require_once __DIR__.'/includes/functions.php';
require_once __DIR__.'/includes/html_helper.php';

require_once __DIR__.'/includes/models/tap.php';
require_once __DIR__.'/includes/models/beer.php';
require_once __DIR__.'/includes/models/keg.php';

require_once __DIR__.'/includes/managers/beer_manager.php';
require_once __DIR__.'/includes/managers/keg_manager.php';
require_once __DIR__.'/includes/managers/tap_manager.php';


$htmlHelper = new HtmlHelper();
$tapManager = new TapManager();
$beerManager = new BeerManager();
$kegManager = new KegManager();

if( isset($_POST['updateNumberOfTaps'])) {
	$tapManager->updateTapNumber($_POST['numberOfTaps']);	
}else if( isset($_POST['newTap'])){
	$tapNumber=$_POST['tapNumber'];
	redirect("tap_form.php?tapNumber=$tapNumber");
	
}else if( isset($_POST['editTap'])){
	$tapNumber=$_POST['tapNumber'];
	$id=$_POST['id'];
	redirect("tap_form.php?tapNumber=$tapNumber&id=$id");

}else if( isset($_POST['closeTap'])){
	$tapManager->closeTap($_POST['id']);	
}

$numberOfTaps = $tapManager->getTapNumber();
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
<?php
include 'header.php';
?>
	<!-- End Header -->
		
	<!-- Top Breadcrumb Start -->
	<div id="breadcrumb">
		<ul>	
			<li><img src="img/icons/icon_breadcrumb.png" alt="Location" /></li>
			<li><strong>Location:</strong></li>
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
	
	<?php 
		$tapsErrorMsg = "";
		$beers = $beerManager->GetAll();
		$kegs = $kegManager->GetAll();
		
		if( count($beers) == 0 ){
			$tapsErrorMsg .= "At least 1 beer needs to be created, before you can assign a tap. <a href='beer_form.php'>Click here to create a beer</a><br/>";
		}
		
		if( count($kegs) == 0 ){
			$tapsErrorMsg .= "At least 1 keg needs to be created, before you can assign a tap. <a href='keg_form.php'>Click here to create a keg</a><br/>";
		}					
		
		if( strlen($tapsErrorMsg) > 0 ){ 
			echo $htmlHelper->CreateMessage('warning', $tapsErrorMsg);	
			
		}else{
	?>	
	
			<form method="POST">
				<input type="hidden" name="numberOfTaps" value="<?php echo $numberOfTaps ?>" />
				
				<table width="800" border="0" cellspacing="0" cellpadding="0">
					<thead>
						<tr>
							<th>Tap #</th>
							<th>Beer Name</th>
							<th>SRM</th>
							<th>IBU</th>
							<th>OG</th>
							<th>FG</th>
							<th>Keg</th>
							<th>PIN</th>
							<!-- <th>Start Amount</th> -->
							<!-- <th>Current Amount</th> -->
							<th colspan="3"></th>
						</tr>
					</thead>
					<tbody>
						<?php for($c = 1; $c <= $numberOfTaps; $c++ ){ ?>
							<form method="POST">
								<?php if( array_key_exists($c, $activeTaps) ){
										$tap = $activeTaps[$c];							
										$beer = $beerManager->GetById($tap->get_beerId());
										$keg = $kegManager->GetById($tap->get_kegId());
								?>
										<input type="hidden" name="id" value="<?php echo $tap->get_id()?>" />
										<input type="hidden" name="tapNumber" value="<?php echo $c?>" />
										<tr>
											<td>
												<?php echo $c ?>
											</td>
											
											<td>							
												<?php echo $beer->get_name() ?>
											</td>
											
											<td>
												<?php echo $tap->get_srm() ?>
											</td>
											
											<td>							
												<?php echo $tap->get_ibu() ?>
											</td>
											
											<td>							
												<?php echo $tap->get_og() ?>
											</td>
											
											<td>
												<?php echo $tap->get_fg() ?>
											</td>
																		
											<td>
												<?php echo $keg->get_label() ?>
											</td>
											
											<td>
												<?php echo $tap->get_pinId() ?>
											</td>
											<!--
											<td>
												<?php echo $tap->get_startAmount() ?>
											</td>
											-->
											
											<!--
											<td>
												<?php echo $tap->get_currentAmount() ?>
											</td>
											-->
											
											<td>
												<input name="editTap" type="submit" class="btn" value="Update Tap Info" />
												
											</td>
											
											<td>
												<input name="newTap" type="submit" class="btn" value="New Keg" />
											</td>
											
											<td>
												<input name="closeTap" type="submit" class="btn" value="Kick Keg" />
											</td>
											
										</tr>
								<?php } else { ?>
										<input type="hidden" name="tapNumber" value="<?php echo $c?>" />
										<tr>
											<td>
												<?php echo $c ?>
											</td>
											
											<td colspan="99">
												<input name="newTap" type="submit" class="btn" value="Tap a Keg" />
											</td>
										</tr>								
								<?php } ?>	
							</form>						
						<?php } ?>
					</tbody>
				</table>
				<br />
				<div align="right">			
					&nbsp &nbsp 
				</div>
			
			</form>
		<?php } ?>
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
	<!-- End Js -->
	<!--[if IE 6]>
	<script type='text/javascript' src='scripts/png_fix.js'></script>
	<script type='text/javascript'>
	DD_belatedPNG.fix('img, .notifycount, .selected');
	</script>
	<![endif]--> 
</body>
</html>