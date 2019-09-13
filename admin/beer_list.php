<?php
require_once __DIR__.'/header.php';
$htmlHelper = new HtmlHelper();
$beerManager = new BeerManager();
$beerStyleManager = new BeerStyleManager();
$breweryManager = new BreweryManager();
$config = getAllConfigs();
if (isset($_POST['inactivateBeer'])) {
	$beerManager->Inactivate($_POST['id']);		
}

$beers = $beerManager->GetAllActive();
$breweryList = $breweryManager->GetAll()
?>
	<!-- Start Header  -->
<body>
<script >
function toggleBeerInfo(callingElement, beerId) {
    var imageTh = document.getElementById("beerImg"+beerId);
	toggleElementDisplay(imageTh, "beerInfo"+beerId );
	toggleElementDisplay(imageTh, "beerNotes"+beerId );
}
function toggleElementDisplay(callingElement, elementToToggle) {
	var div = document.getElementById(elementToToggle);
	if(div != null){
		if(div.style.display == ""){
			div.style.display = "none";
			if(callingElement != null)callingElement.style.backgroundImage = "url(img/bg_expander_plus.png)"
		}else{
			div.style.display = "";
			if(callingElement != null)callingElement.style.backgroundImage = "url(img/bg_expander_minus.png)"
		}
	}
}

function filterBeer(searchTextElement){
	$("p:not(:contains('"+searchTextElement.value+"'))").parent().map(function() {
	    if(!$(this).is("th")) return 
	    $(this).siblings("th[id^=beerImg]").css('background-image', 'url(img/bg_expander_plus.png)')
	    $(this).parent().hide();
	    $(this).parent().next("tr").hide();
	    $(this).parent().next("tr").next("tr").hide();
	  });
	$("p:contains('"+searchTextElement.value+"')").parent().map(function() {
	    if(!$(this).is("th")) return 
	    $(this).parent().show();
	  });
}
</script>
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
			<?php if($config[ConfigNames::ClientID] && $config[ConfigNames::ClientSecret]){?>
				<input type="submit" class="btn" value="Add with Untappd Id" onClick="window.location='beer_form_untappd.php'" />
			<?php }?>
			<br/><br/>
			<?php if( count($beers) != 0 ){	?>
        		Search:<input type="text" id="search" class="largebox" name="search" value="" onkeyup="filterBeer(this);" />
        	<?php } ?>
			<table style="width:770px; padding:0px" class="outerborder" id="beersTable">
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
								<tr class="intborder collapsed heading" onClick="toggleBeerInfo(this, '<?php echo $beer->get_id()?>')" >
									<th style="width:35%; vertical-align:middle;">
										<p style="font-size:24px; font-weight:bold; width:400px; overflow:hidden"><?php echo $beer->get_name() ?></p>
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
									<th style="width:10%; text-align: center; vertical-align: middle; margin: 0; padding: 0;">
										<input name="editBeer" type="button" class="btn" value="Edit" style="text-align: center; margin: 0;" onClick="window.location='beer_form.php?id=<?php echo $beer->get_id()?>'" />
									</th>
									<th style="width:10%; text-align: center; vertical-align: middle; margin: 0; padding: 0">
										<form method="POST">
											<input type='hidden' name='id' value='<?php echo $beer->get_id()?> '/>
											<input class="inactivateBeer btn" style="text-align: center; margin: 0;" name="inactivateBeer" type="submit" value="Delete" />
										</form>
									</th>
									<th id="beerImg<?php echo $beer->get_id()?>" style="width:10%; text-align: center; vertical-align: middle; margin: 0; padding: 0;
									      background: url(img/bg_expander_plus.png) no-repeat center; background-size: 100%; background-color: #e0e0e0; background-position: 0 -10px; background-position-y: center; " >
									</th>
								</tr>
								<tr class="intborder thick" id="beerInfo<?php echo $beer->get_id() ?>" style="display:none">
									<td>
										<p><b style="text-decoration: underline;">Vitals</b></p>
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
											    echo convert_gravity($beer->get_og(), $beer->get_ogUnit(), $config[ConfigNames::DisplayUnitGravity]) ;
											else
												echo "N/A";
										?>
                                        <br>
                                        <b>FG:</b>
										<?php
											if ( $beer->get_fg() != 1 && $beer->get_fg() != 0 )
											    echo  convert_gravity($beer->get_fg(), $beer->get_fgUnit(), $config[ConfigNames::DisplayUnitGravity]);
											else
												echo "N/A";
										?>
                                        </p>
										
									</td>
									<td colspan="3">
										<p style="padding-bottom: 1px"><b  style="text-decoration: underline;">Fermentables:</b></p><p>
						                    <?php
						                      $fermentables = $beerManager->GetFermentables($beer->get_id());
						                      foreach($fermentables as $fermentable){
						                      	 echo $fermentable->get_name(). "<br>";
						                      }
						                    ?>
										</p>
										
										<p style="padding-bottom: 1px"><b style="text-decoration: underline;">Hops:</b></p><p>
						                    <?php
						                      $hops = $beerManager->GetHops($beer->get_id());
						                      foreach($hops as $hop){
						                          echo $hop->get_name() . "<br>";
						                      }
						                    ?>
										</p>
										<p style="padding-bottom: 1px"><b style="text-decoration: underline;">Yeast:</b></p><p>
						                    <?php 
						                      $yeasts = $beerManager->GetYeasts($beer->get_id());
						                      foreach($yeasts as $yeast){
						                          echo $yeast->get_name() . "<br>";
						                      }
						                    ?>
										</p>
									</td>
									<td style="width:5%"></td>
								</tr>
								<tr class="intborder" id="beerNotes<?php echo $beer->get_id() ?>" style="display:none">
									<td colspan="2">
										<?php
										if(strlen($beer->get_notes()) < 200){
										  echo $beer->get_notes() ;
										}else{
										    echo substr($beer->get_notes(), 0, 200) .' ...';										      
										}
										?>
									</td>
									<td style="width:5%; text-align: center;">
										<input name="editBeer" type="button" class="btn" value="Edit" onClick="window.location='beer_form.php?id=<?php echo $beer->get_id()?>'" />
									</td>
									<td  style="width:5%; text-align: center;">
										<form method="POST">
											<input type='hidden' name='id' value='<?php echo $beer->get_id()?>'/>
											<input class="inactivateBeer btn" name="inactivateBeer" type="submit" value="Delete" />
										</form>
									</td>
									<td style="width:5%"></td>
								</tr>
					<?php 
							}
						}
					?>
				</tbody>
			</table><br>
			<input type="submit" class="btn" value="Add a Beer" onClick="window.location='beer_form.php'" />
			<input type="submit" class="btn" value="Add a Beer with XML" onClick="window.location='beer_form_xml.php'" />
			<?php if($config[ConfigNames::ClientID] && $config[ConfigNames::ClientSecret]){?>
				<input type="submit" class="btn" value="Add with Untappd Id" onClick="window.location='beer_form_untappd.php'" />
			<?php }?>
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
