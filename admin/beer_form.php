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
require_once __DIR__.'/includes/models/beerFermentable.php';
require_once __DIR__.'/includes/models/beerHop.php';

require_once __DIR__.'/includes/managers/beer_manager.php';
require_once __DIR__.'/includes/managers/beerFermentable_manager.php';
require_once __DIR__.'/includes/managers/beerHop_manager.php';
require_once __DIR__.'/includes/managers/beerStyle_manager.php';

$htmlHelper = new HtmlHelper();
$beerManager = new BeerManager();
$beerFermentableManager = new BeerFermentableManager();
$beerHopManager = new BeerHopManager();
$beerStyleManager = new BeerStyleManager();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$beer = new Beer();
	$beer->setFromArray($_POST);
	$beerManager->Save($beer);
	redirect('beer_list.php');
}

if( isset($_GET['id'])){
	$beer = $beerManager->GetById($_GET['id']);
	$beerFermentables = $beerFermentableManager->GetById($_GET['id']);
	$beerHops = $beerHopManager->GetById($_GET['id']);
}else{
	$beer = new Beer();
}

$beerStyleList = $beerStyleManager->GetAll();
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
            <li><a href="beer_list.php">My Beers</a></li>
            <li>/</li>
            <li class="current">Beer Form</li>
        </ul>
    </div>
    <!-- Top Breadcrumb End --> 
     
    <!-- Right Side/Main Content Start -->
    <div id="rightside">
		 <div class="contentcontainer med left">
	<p>
		Fields marked with <b><font color="red">*</font></b> are required.<br><br>

	<form id="beer-form" method="POST">
		<input type="hidden" name="id" value="<?php echo $beer->get_id() ?>" />
		<input type="hidden" name="active" value="<?php echo $beer->get_active() ?>" />

		<table width="800" border="1" cellspacing="0" cellpadding="0">
			<tr>
				<td colspan="4">
					<h3><center>General Recipe Information</center></h3>
				</td>
			</tr>
			<tr>
				<td width="50">
					<b>Name:<font color="red">*</font></b>
				</td>
				<td>
					<input type="text" id="name" class="largebox" name="name" value="<?php echo $beer->get_name() ?>" />
				</td>


				<td>
					<b>Style:<font color="red">*</font></b>
				</td>
				<td>
					<?php echo $htmlHelper->ToSelectList("beerStyleId", $beerStyleList, "name", "id", $beer->get_beerStyleId(), "Select One"); ?>
				</td>
			</tr>
			<tr>
				<td>
					<b>SRM:<font color="red">*</font></b>
				</td>
				<td>
					<input type="text" id="srm" class="xsmallbox" name="srm" value="<?php echo $beer->get_srm() ?>" />
				</td>


				<td>

				<b>OG:<font color="red">*</font></b>
				</td>
				<td>

					<input type="text" id="og" class="smallbox" name="og" value="<?php echo $beer->get_og() ?>" />
				</td>
			</tr>
			<tr>
				<td>

					<b>IBU:<font color="red">*</font></b>
				</td>
				<td>

					<input type="text" id="ibu" class="xsmallbox" name="ibu" value="<?php echo $beer->get_ibu() ?>" />
				</td>


				<td>
					<b>FG:<font color="red">*</font></b>
				</td>
				<td>
					<input type="text" id="fg" class="smallbox" name="fg" value="<?php echo $beer->get_fg() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<b>Rating:<font color="red">*</font></b>
				</td>
				<td>
					<input type="text" id="fg" class="smallbox" name="rating" value="<?php echo $beer->get_rating() ?>" />
				</td>
				<td>
					<b>Tasting<br>Notes:</b>
				</td>
				<td>
					<textarea type="text" id="notes" class="text-input textarea" style="width:320px;height:80px" name="notes"><?php echo $beer->get_notes() ?></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<h3><center>Fermentables</center></h3>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<table width = "100%">
						<tr width="100%">
							<td><strong>Name</strong></td>
							<td><strong>Type</strong></td>
							<td><strong>Amount</strong></td>
							<td><strong>SRM</strong></td>
						</tr>
					<?php 
						if( count($beerFermentables) == 0 ){  
					?>
							<tr><td class="no-results" colspan="99">No beers :( Add some?</td></tr>
					<?php 
						}else{
							foreach ($beerFermentables as $beerFermentable){
							?>
							<tr width="100%">
							<td><?php echo $beerFermentable->get_name() ?></td>
							<td><?php echo $beerFermentable->get_type() ?></td>
							<td><?php echo $beerFermentable->get_amount() ?></td>
							<td><?php echo $beerFermentable->get_srm() ?></td>
						</tr>
						<?php
							}
						}
					?>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<h3><center>Hops</center></h3>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<table width="100%">
						<tr width="100%">
							<td><strong>Name</strong></td>
							<td><strong>Alpha</strong></td>
							<td><strong>Amount</strong></td>
							<td><strong>Time</strong></td>
						</tr>
					<?php 
						if( count($beerHops) == 0 ){  
					?>
							<tr><td class="no-results" colspan="99">No beers :( Add some?</td></tr>
					<?php 
						}else{
							foreach ($beerHops as $beerHop){
							?>
							<tr width="100%">
							<td><?php echo $beerHop->get_name() ?></td>
							<td><?php echo $beerHop->get_alpha() ?></td>
							<td><?php echo $beerHop->get_amount() ?></td>
							<td><?php echo $beerHop->get_time() ?></td>
						</tr>
						<?php
							}
						}
					?>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<h3><center>Misc</center></h3>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<table>
						<tr width="100%">
							<td>Name</td>
							<td>Type</td>
							<td>Use</td>
							<td>Time</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<h3><center>Yeast</center></h3>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<table>
						<tr width="100%">
							<td>Name</td>
							<td>Type</td>
							<td>Form</td>
							<td>Code</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input name="save" type="submit" class="btn" value="Save" />
					<input type="button" class="btn" value="Cancel" onclick="window.location='beer_list.php'" />
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
		
		$('#beer-form').validate({
		  rules: {
			name: { required: true },
			style: { required: true },			
			srm: { required: true, number: true },
			ibu: { required: true, number: true },
			og: { required: true, number: true },
			fg: { required: true, number: true }
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
