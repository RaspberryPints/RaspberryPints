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
require_once __DIR__.'/includes/models/beerStyle.php';

require_once __DIR__.'/includes/managers/beer_manager.php';
require_once __DIR__.'/includes/managers/beerStyle_manager.php';


$htmlHelper = new HtmlHelper();
$beerManager = new BeerManager();
$beerStyleManager = new BeerStyleManager();

if (isset($_POST['inactivateBeer'])) {
	$beerManager->Inactivate($_POST['id']);
}

$beers = $beerManager->GetAllActive();
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
			<li class="current">Beers</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End -->

	<!-- Right Side/Main Content Start -->
<div id="rightside">
	<div class="contentcontainer lg left">
		<div class="headings alt">
			<h2>Beers </h2>
		</div>
		<div class="contentbox">

			<!-- Start On Tap Section -->

			<?php $htmlHelper->ShowMessage(); ?>

			<input type="submit" class="btn" value="Add Beer" onclick="window.location='beer_form.php'" />
			<br/><br/>

			<table width="770px" cellspacing="0" cellpadding="0" class="outerborder">

				<tbody>
					<?php
						if( count($beers) == 0 ){
					?>
							<tr><td class="no-results" colspan="99">No beers :( Add some?</td></tr>
					<?php
						}else{
							foreach ($beers as $beer){
					?>
								<tr class="intborder">
									<th width="35%" style="vertical-align: middle;">
										<h3><?php echo $beer->get_name() ?></h3>
									</th>
									<th width="35%" style="vertical-align: middle;">
										<b><?php
											$beerStyle = $beerStyleManager->GetById($beer->get_beerStyleId());
											echo $beerStyle->get_name();
										?></b><br>
										<?php
											/* Can't seem to get this to work! >:\
											$beerStyle = $beerStyleManager->GetByStyle($beer->get_beerStyle());
											echo $beerStyle->get_style();
											*/
										?>
										BJCP <?php echo $beerStyle->get_catNum() ?> - <?php echo $beerStyle->get_category() ?>
									</th>
									<th align="center" width="5%" style="text-align: center; vertical-align: middle; margin: 0; padding: 0;">
										<input name="editBeer" type="button" class="btn" value="Edit" style="text-align: center; margin: 0;" onclick="window.location='beer_form.php?id=<?php echo $beer->get_id()?>'" />
									</th>
									<th align="center" width="5%" style="text-align: center; vertical-align: middle; margin: 0; padding: 0">
										<form method="POST">
											<input type='hidden' name='id' value='<?php echo $beer->get_id()?> '/>
											<input class="inactivateBeer btn" style="text-align: center; margin: 0;" name="inactivateBeer" type="submit" value="Delete" />
										</form>
									</th>
								</tr>
								<tr class="intborder">
									<td colspan="4">
											<?php if ($beer->get_notes()) { ?>
												<blockquote>
											<?php } ?>
											<?php if ($beer->get_notes()) echo $beer->get_notes() ?>
											<?php if ($beer->get_notes()) { ?>
												</blockquote>
											<?php } ?>
										</blockquote>
									</td>
								</tr>
								<tr class="intborder thick">
									<td>
										<p><b><u>Vitals</u></b></p>
										<p><?php
											if ( $beer->get_srm() != 0 )
												echo "<b>SRM:</b> " , $beer->get_srm() , "<br>" ;
											else
												echo "<b>SRM:</b> N/A<br>"
										?>
										<?php
											if ( $beer->get_ibu() != 0 )
												echo "<b>IBU:</b> " , $beer->get_ibu() , "<br>" ;
											else
												echo "<b>IBU:</b> N/A<br>"
										?>
										<?php
											if ( $beer->get_abv() != 1 && $beer->get_abv() != 0 )
												echo "<b>ABV:</b> " , $beer->get_abv() , "<br>" ;
											else
												echo "<b>ABV:</b> N/A<br>"
										?></p>

										<p><b>Water:</b> <!-- Sacramento, CA --> <br>
										<b>Salts:</b> <!-- Camden, pH 5.2 Stabilizer --> <br>
										<b>Finings:</b> <!-- Whirfloc --> <br>
										<b>Yeast</b>: <!-- Fermentis S-04 --><br></p>
									</td>
									<td colspan="3">
										<p><b><u>Fermentables:</u></b></p><p>
										<!--
										60.5% Pilsner (2 Row) Ger (2.0 SRM)<br>
										32.4% Pale Ale Malt, Northwestern (Great Western) (3.0 SRM)<br>
										7.1% Crystal 15, 2-Row, (Great Western) (15.0 SRM)<br>
										-->
										</p>

										<p><b><u>Mash Profile:</u></b></p><p>
										<!--
										Step 1: Dough-in @ 70&deg;F (2 min)<br>
										Step 2: Conversion @ 154&deg;F (60 min)<br>
										Step 3: Batch Sparge @ 168&deg;F (5 min)<br>
										Step 4: Batch Sparge @ 168&deg;F (5 min)</p>
										-->
										</p>

										<p><b><u>Hop Schedule:</u></b></p><p>
										<!--
										0.90 oz Simcoe (13.00% AA) @ 90 min<br>
										0.90 oz Simcoe (13.00% AA) @ 30 min<br>
										1.80 oz Simcoe (13.00% AA) @ 0 min<br>
										2.00 oz Simcoe (13.00% AA) @ Dry Hop 10.0 Days</p>
										-->
										</p>
									</td>
								</tr>
					<?php
							}
						}
					?>
				</tbody>
			</table><br>
			<input type="submit" class="btn" value="Add Beer" onclick="window.location='beer_form.php'" />
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
		$('.inactivateBeer').on('click', function(){
			if(!confirm('Are you sure you want to delete this beer?')){
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
