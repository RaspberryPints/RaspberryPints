<?php
require_once __DIR__.'/header.php';
$htmlHelper = new HtmlHelper();
$beerManager = new BeerManager();
$beerStyleManager = new BeerStyleManager();
$breweryManager = new BreweryManager();

if (isset($_POST['inactivateBeer'])) {
	$beerManager->Inactivate($_POST['id']);		
}

$beers = $beerManager->GetAllActive();
$breweryList = $breweryManager->GetAll()
?>
	<!-- Start Header  -->
<body>
<?php
include 'top_menu.php';
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
			<h2>Beers</h2>
		</div>
		<div class="contentbox">
		
			<!-- Start On Tap Section -->
			
			<?php $htmlHelper->ShowMessage(); ?>
			
			<input type="submit" class="btn" value="Add a Beer" onClick="window.location='beer_form.php'" />
			<input type="submit" class="btn" value="Add with BeerXML" onClick="window.location='beer_form_xml.php'" />
			<br/><br/>
			
			<table style="width:770px; padding:0px" class="outerborder">
<!--				<thead>
					<tr>
						<th style="width:28%">Name</th>
						<th style="width:10%">Vitals</th>
						<th style="width:22%">Yeast/Water/etc</th>
						<th style="width:40%" colspan="3">Hop Additions</th>
					</tr>
				</thead>-->
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
									<th style="width:35%; vertical-align:middle;">
										<p style="font-size:24px; font-weight:bold"><?php echo $beer->get_name() ?></p>
                                        <?php 
											if($beer->get_breweryId())
											{
												$brewery = $breweryManager->GetByID($beer->get_breweryId());
												if($brewery) echo "&nbsp;".$brewery->get_name();
											}
										?>
									</th>
									<th style="width:35%; vertical-align: middle;">
										<b>Style: <?php 
											$beerStyle = $beerStyleManager->GetById($beer->get_beerStyleId());
											if( $beerStyle )
											{
												if (strpos($beerStyle->get_name(),'Non-beer') !== false)
													echo str_replace("_Non-beer: ","",$beerStyle->get_name());
												else
													echo $beerStyle->get_name();
											}
										?>
                                        </b>
                                        <br>
										<?php
											$style = "";
											if (!$beerStyle || strpos($beerStyle->get_catNum(),'N/A') !== false)
												$style = "&nbsp;";
											else
											{
												$style = $beerStyle->get_beerStyleList().":".($beerStyle->get_catNum()? $beerStyle->get_catNum()." - ":"").$beerStyle->get_category();
											}
											echo $style;
										?>
									</th>
									<th style="width:5%; text-align: center; vertical-align: middle; margin: 0; padding: 0;">
										<input name="editBeer" type="button" class="btn" value="Edit" style="text-align: center; margin: 0;" onClick="window.location='beer_form.php?id=<?php echo $beer->get_id()?>'" />
									</th>
									<th style="width:5%; text-align: center; vertical-align: middle; margin: 0; padding: 0">
										<form method="POST">
											<input type='hidden' name='id' value='<?php echo $beer->get_id()?> '/>
											<input class="inactivateBeer btn" style="text-align: center; margin: 0;" name="inactivateBeer" type="submit" value="Delete" />
										</form>
									</th>
								</tr>
								<tr class="intborder thick">
									<td>
										<p><b><u>Vitals</u></b></p>
										<p>
                                        <b>Untappd:</b>
										<?php
											if ( $beer->get_untID() != 0 )
												echo $beer->get_untID() ;
											else
												echo "N/A" ;
										?>
                                        <br>
                                        <b>SRM:</b>
										<?php
											if ( $beer->get_srm() != 0 )
												echo  $beer->get_srm();
											else
												echo "N/A";
										?>
                                        <br>
                                        <b>IBU:</b>
										<?php
											if ( $beer->get_ibu() != 0 )
												echo $beer->get_ibu();
											else
												echo "N/A";
										?>
                                        <br>
                                        <b>ABV:</b>
										<?php
											if ( $beer->get_abv() != 1 && $beer->get_abv() != 0 )
												echo $beer->get_abv() ;
											else
												echo "N/A";
										?>
                                        </p>
                                        <p>
                                        <b>OG:</b>
										<?php
											if ( $beer->get_og() != 1 && $beer->get_og() != 0 )
												echo $beer->get_og() ;
											else
												echo "N/A";
										?>
                                        <br>
                                        <b>FG:</b>
										<?php
											if ( $beer->get_fg() != 1 && $beer->get_fg() != 0 )
												echo  $beer->get_fg();
											else
												echo "N/A";
										?>
                                        </p>
										
									</td>
									<td colspan="3">
										<p><b><u>Fermentables:</u></b></p><p>
						                    <?php
						                      $fermentables = $beerManager->GetFermentables($beer->get_id());
						                      foreach($fermentables as $fermentable){
						                      	 echo $fermentable . "<br>";
						                      }
						                    ?>
										</p>
										
										<p><b><u>Hops:</u></b></p><p>
						                    <?php
						                      $hops = $beerManager->GetHops($beer->get_id());
						                      foreach($hops as $hop){
						                      	 echo $hop . "<br>";
						                      }
						                    ?>
										</p>
										<p><b><u>Yeast:</u></b></p><p>
						                    <?php 
						                      $yeasts = $beerManager->GetYeasts($beer->get_id());
						                      foreach($yeasts as $yeast){
						                      	 echo $yeast . "<br>";
						                      }
						                    ?>
										</p>
									</td>
								</tr>
								<tr class="intborder">
									<td colspan="2">
										<?php echo $beer->get_notes() ?>
									</td>
									<td style="width:50px; text-align: center;">
										<input name="editBeer" type="button" class="btn" value="Edit" onClick="window.location='beer_form.php?id=<?php echo $beer->get_id()?>'" />
									</td>
									<td  style="width:50px; text-align: center;">
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
			</table><br>
			<input type="submit" class="btn" value="Add a Beer" onClick="window.location='beer_form.php'" />
			<input type="submit" class="btn" value="Add a Beer with XML" onClick="window.location='beer_form_xml.php'" />
		</div>
	</div>
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
