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
		 <div class="contentcontainer med left">		
			<!-- Start On Tap Section -->
			
			<?php $htmlHelper->ShowMessage(); ?>
			
			<input type="submit" class="btn" value="Add Beer" onclick="window.location='beer_form.php'" />
			<br/><br/>
			
			<table width="800" border="0" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<th>Name</th>
						<th>Style</th>						
						<th>SRM</th>
						<th>IBU</th>
						<th>O.G.</th>
						<th>F.G.</th>
						<th colspan="3">Tasting Notes</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						if( count($beers) == 0 ){  
					?>
							<tr><td class="no-results" colspan="99">No beers</td></tr>
					<?php 
						}else{  
							foreach ($beers as $beer){
					?>
								<tr>
									<td>
										<?php echo $beer->get_name() ?>
									</td>
									
									<td>							
										<?php 
											$beerStyle = $beerStyleManager->GetById($beer->get_beerStyleId());
											echo $beerStyle->get_name();
										?>
									</td>
									
									<td>
										<?php echo $beer->get_srm() ?>
									</td>
									
									<td>
										<?php echo $beer->get_ibu() ?>
									</td>
									
									<td>
										<?php echo $beer->get_og() ?>
									</td>
									
									<td>							
										<?php echo $beer->get_fg() ?>
									</td>
									
									<td>
										<?php echo $beer->get_notes() ?>
									</td>
																		
									<td>
										<input name="editBeer" type="button" class="btn" value="Edit" onclick="window.location='beer_form.php?id=<?php echo $beer->get_id()?>'" />
									</td>
									
									<td>
										<form method="POST">
											<input type='hidden' name='id' value='<?php echo $beer->get_id()?>'/>
											<input class="inactivateBeer btn" name="inactivateBeer" type="submit" value="Delete" />
										</form>
									</td>
									
								</tr>
					<?php 
							} 
						}
					?>
				</tbody>
			</table>
		</div>
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
