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
			<li class="current">My Beers</li>            
		</ul>
	</div>
	<!-- Top Breadcrumb End --> 
	
	<!-- Right Side/Main Content Start -->
<div id="rightside">
	<div class="contentcontainer lg left">
		<div class="headings alt">
			<h2>My Beers </h2>
		</div>
		<div class="contentbox">
		
			<!-- Start On Tap Section -->
			
			<?php $htmlHelper->ShowMessage(); ?>
			
			<input type="submit" class="btn" value="Add a Beer" onclick="window.location='beer_form.php'" />
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
											if (strpos($beerStyle->get_name(),'Non-beer') !== false)
												echo str_replace("_Non-beer: ","",$beerStyle->get_name());
											else
												echo "Style: " , $beerStyle->get_name();
										?></b>
										<?php
											if (strpos($beerStyle->get_catNum(),'N/A') !== false)
												echo "&nbsp;";
											else
												echo "<br>BJCP Category: " , $beerStyle->get_catNum() , " - " , $beerStyle->get_category();
										?>
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
											if ( $beer->get_og() != 1 && $beer->get_og() != 0 )
												echo "<b>OG:</b> " , $beer->get_og() , "<br>" ;
											else
												echo "<b>OG:</b> N/A<br>"
										?>
										<?php
											if ( $beer->get_fg() != 1 && $beer->get_fg() != 0 )
												echo "<b>FG:</b> " , $beer->get_fg() , "<br>" ;
											else
												echo "<b>FG:</b> N/A"
										?>
                                       <?php
                                       if ( $beer->get_modifiedDate() != 0 )
												echo "<b>Changed On:</b> " , $beer->get_ModifiedDate() , "<br>" ;
                            ?>
                            			
						<p>
                                           <?php if( $beer->get_recipe() > "" ) { ?>
         
    <input name="recipeView" type="button" class="btn" value="Recipe" style="text-align: center; margin: 0;" onclick="window.open('recipe.php?id=<?php echo $beer->get_id()?>', 'Recipe for <?php echo $beer->get_name() ?>', 'width=800,height=800', 'status=0', 'titlebar=0', 'menubar=0', 'top=500', 'left=500') " />
                            <?php } ?>
                            </p>
                    </td>
									<td colspan="3">
	
										
									</td>
								</tr>
					<?php 
							}
						}
					?>
				</tbody>
			</table><br>
			<input type="submit" class="btn" value="Add a Beer" onclick="window.location='beer_form.php'" />
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
