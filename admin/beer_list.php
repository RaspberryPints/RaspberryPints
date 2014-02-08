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
			
			<input type="submit" class="btn" value="Add Beer" onclick="window.location='beer_form.php'" />
			<br/><br/>
			
			<table width="770px" border="0" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<th width="38%">Name</th>
						<th width="22%">Yeast/Water/etc</th>
						<th width="40%" colspan="3">Ingredients</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						if( count($beers) == 0 ){  
					?>
							<tr><td class="no-results" colspan="99">No beers :( Add some?</td></tr>
					<?php 
						}else{  
							foreach ($beers as $beer){
					?>
								<tr>
									<td>
										<h3><?php echo $beer->get_name() ?></h3><br>
										<b><?php 
											$beerStyle = $beerStyleManager->GetById($beer->get_beerStyleId());
											echo $beerStyle->get_name();
										?></b><br>
										(BJCP 1A - Light Lager)</b><br><br>
										<?php
											if ( $beer->get_srm() != 0 )
												echo "<b>SRM:</b> " , $beer->get_srm() , "<br>" ;
											else
												echo ""
										?>
										<?php
											if ( $beer->get_ibu() != 0 )
												echo "<b>IBU:</b> " , $beer->get_ibu() , "<br>" ;
											else
												echo ""
										?>
										<?php
											if ( $beer->get_og() != 1 && $beer->get_og() != 0 )
												echo "<b>OG:</b> " , $beer->get_og() , "<br>" ;
											else
												echo ""
										?>
										<?php
											if ( $beer->get_fg() != 1 && $beer->get_fg() != 0 )
												echo "<b>FG:</b> " , $beer->get_fg() , "<br>" ;
											else
												echo ""
										?>
									</td>
									
									<td>
										<b>Yeast</b>: Fermentis S-04<br>
										<b>Water:</b> Sacramento, CA<br>
										<b>More:</b> Info Here...<br>
										<b>More:</b> Info Here...<br>
									</td>
									
									<td colspan="3">
										1.42 oz Northern Brewer (6.8%) @ 60 min<br>
										2.14 oz Nelson Sauvin (9.1%) @ 30 min<br>
										2.41 oz Columbus/Tomahawk (8.6%) @ 15 min<br>
										1.24 oz East Kent Goldings (2.1%) @ 0 min<br>
									</td>
								</tr>
								<tr class="intborder">
									<td colspan="2">
										<?php if ($beer->get_notes()) echo '"' ?><?php echo $beer->get_notes() ?><?php if ($beer->get_notes()) echo '"' ?>
									</td>
									<td align="center" width="50px">
										<input name="editBeer" type="button" class="btn" value="Edit" onclick="window.location='beer_form.php?id=<?php echo $beer->get_id()?>'" />
									</td>
									<td align="center" width="50px">
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
