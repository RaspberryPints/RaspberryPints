<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
	header("location:index.php");
}

require_once __DIR__.'/includes/conn.php';
require_once __DIR__.'/includes/functions.php';
require_once __DIR__.'/includes/html_helper.php';

require_once __DIR__.'/includes/models/shelf.php';
require_once __DIR__.'/includes/models/beer.php';
require_once __DIR__.'/includes/models/bottle.php';

require_once __DIR__.'/includes/managers/beer_manager.php';
require_once __DIR__.'/includes/managers/bottle_manager.php';
require_once __DIR__.'/includes/managers/shelf_manager.php';


$htmlHelper = new HtmlHelper();
$shelfManager = new ShelfManager();
$beerManager = new BeerManager();
$bottleManager = new BottleManager();

if( isset($_POST['updateNumberOfShelves'])) {
	$shelfManager->updateShelfNumber($_POST['numberOfShelves']);	
}else if( isset($_POST['newShelf'])){
	$shelfNumber=$_POST['shelfNumber'];
	redirect("shelf_form.php?shelfNumber=$shelfNumber");
	
}else if( isset($_POST['editTap'])){
	$shelfNumber=$_POST['shelfNumber'];
	$id=$_POST['id'];
	redirect("shelf_form.php?shelfNumber=$shefNumber&id=$id");

}else if( isset($_POST['closeShelf'])){
	$shelfManager->closeShelf($_POST['id']);	
}

$numberOfShelves = $shelfManager->getShelfNumber();
$activeShelves = $shelfManager->getActiveShelves();
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
			<li class="current">Shelf List</li>            
		</ul>
	</div>
	<!-- Top Breadcrumb End --> 
	
	<!-- Right Side/Main Content Start -->
	<div id="rightside">
		<div class="contentcontainer med left">
	<p>
	<!-- Set Tap Number Form -->
		<form method="POST" name="taplimit">
			<b>Number Of Taps:</b> &nbsp <input type="text" name="numberOfShelves" class="smallbox" value="<?php echo $numberOfShelves ?>"> &nbsp <input type="submit" name="updateNumberOfShelves" class="btn" value="Update Number of Shelves" />
		</form>
	</p>
	<!-- End Tap Number Form -->
<br />
	<!-- Start On Tap Section -->
	
	<?php 
		$tapsErrorMsg = "";
		$beers = $beerManager->GetAll();
		$bottles = $bottleManager->GetAll();
		
		if( count($beers) == 0 ){
			$tapsErrorMsg .= "At least 1 beer needs to be created, before you can assign a tap. <a href='beer_form.php'>Click here to create a beer</a><br/>";
		}
		
		if( count($bottles) == 0 ){
			$tapsErrorMsg .= "At least 1 keg needs to be created, before you can assign a tap. <a href='keg_form.php'>Click here to create a keg</a><br/>";
		}					
		
		if( strlen($tapsErrorMsg) > 0 ){ 
			echo $htmlHelper->CreateMessage('warning', $tapsErrorMsg);	
			
		}else{
	?>	
	
			<form method="POST">
				<input type="hidden" name="numberOfShelf" value="<?php echo $numberOfShelves ?>" />
				
				<table width="800" border="0" cellspacing="0" cellpadding="0">
					<thead>
						<tr>
							<th>Tap #</th>
							<th>Beer Name</th>
							<th>SRM</th>
							<th>IBU</th>
							<th>OG</th>
							<th>FG</th>
							<th>Bottle</th>
							<!-- <th>Start Amount</th> -->
							<!-- <th>Current Amount</th> -->
							<th colspan="3"></th>
						</tr>
					</thead>
					<tbody>
						<?php for($c = 1; $c <= $numberOfShelves; $c++ ){ ?>
							<form method="POST">
								<?php if( array_key_exists($c, $activeShelves) ){
										$shelf = $activeShelves[$c];							
										$beer = $beerManager->GetById($shelf->get_beerId());
										$bottle = $bottleManager->GetById($shelf->get_bottleId());
								?>
										<input type="hidden" name="id" value="<?php echo $shelf->get_id()?>" />
										<input type="hidden" name="tapNumber" value="<?php echo $c?>" />
										<tr>
											<td>
												<?php echo $c ?>
											</td>
											
											<td>							
												<?php echo $beer->get_name() ?>
											</td>
											
											<td>
												<?php echo $shelf->get_srm() ?>
											</td>
											
											<td>							
												<?php echo $shelf->get_ibu() ?>
											</td>
											
											<td>							
												<?php echo $shelf->get_og() ?>
											</td>
											
											<td>
												<?php echo $shelf->get_fg() ?>
											</td>
																		
											<td>
												<?php echo $bottle->get_label() ?>
											</td>
											
											<!--
											<td>
												<?php echo $shelf->get_startAmount() ?>
											</td>
											-->
											
											<!--
											<td>
												<?php echo $shelf->get_currentAmount() ?>
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
										<input type="hidden" name="shelfNumber" value="<?php echo $c?>" />
										<tr>
											<td>
												<?php echo $c ?>
											</td>
											
											<td colspan="99">
												<input name="newShelf" type="submit" class="btn" value="Put Bottle on a Shelf" />
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