<?php
	//Only to be called from /includes/common.php printBeerList
	require_once __DIR__.'/functions.php';
	require_once __DIR__.'/../admin/includes/managers/config_manager.php';	
	require_once __DIR__.'/../admin/includes/html_helper.php';	
	$config = getAllConfigs();
	$htmlHelper = new HtmlHelper();
	$beerColSpan = 1;
?>

<table>
	<thead>
		<tr>
			<?php if($config[ConfigNames::ShowTapNumCol]){ ?>
				<th class="tap-num">
					<!--TAP<br>#-->
				</th>
			<?php } ?>
			
			<?php if($config[ConfigNames::ShowSrmCol]){ ?>
				<th class="srm">
					COLOR
				</th>
			<?php } ?>
			
			<?php if($config[ConfigNames::ShowIbuCol]){ ?>
				<th class="ibu">
					<?php if($config[ConfigNames::ShowBuGuValue]){ ?>
						BALANCE<hr>
					<?php } ?>
					BITTERNESS
				</th>
			<?php } ?>
		

			<?php if($config[ConfigNames::ShowBeerName]){ ?>
				<?php 
                    if($config[ConfigNames::ShowBreweryImages]){ $beerColSpan++; }
                    if($config[ConfigNames::ShowBeerImages]){ $beerColSpan++; }
                ?> 
				<th <?php if($beerColSpan > 1){ echo 'colspan="'.$beerColSpan.'"';}?> class="beername">
					<?php if($config[ConfigNames::ShowBeerName]){ ?>
						BEER NAME 
						<?php if($config[ConfigNames::ShowBeerStyle]){ ?>&nbsp; &nbsp; STYLE<hr><?php } ?>
						<?php if($config[ConfigNames::ShowBeerNotes]){ ?>&nbsp; &nbsp; TASTING NOTES<?php } ?>
						<?php if($config[ConfigNames::ShowBeerRating]){?>&nbsp; &nbsp; RATING<hr><?php } ?>
					<?php } ?>
				</th>
			<?php } ?>
			
			<?php if($config[ConfigNames::ShowAbvCol]){ ?>
				<th class="abv">
					ABV
					<?php if($config[ConfigNames::ShowCalories]){ ?>
					  	<hr>CALORIES
					<?php } ?>
					<?php if($config[ConfigNames::ShowGravity]){ ?>
						<hr>GRAVITY
					<?php } ?>
				</th>
			<?php } ?>
			
			<?php if($config[ConfigNames::ShowKegCol]){ ?>
				<th class="keg">
					DRINKS<hr>REMAINING
				</th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
		<?php for($i = 1; $i <= $numberOfBeers; $i++) {
			$beer = null;
			if( isset($beers[$i]) ) $beer = $beers[$i];
			if($tapOrBottle != ConfigNames::CONTAINER_TYPE_KEG  && !isset($beer) ) continue;
		?>
			<tr class="<?php if($i%2 > 0){ echo 'altrow'; }?>" id="<?php echo $beer['id']; ?>">
				<?php if($config[ConfigNames::ShowTapNumCol]){ ?>
					<td class="tap-num">
					<?php if($tapOrBottle == ConfigNames::CONTAINER_TYPE_KEG){ 
					    if($config[ConfigNames::AllowSamplePour]){
					?>
						<a href ="./includes/pours.php/?tapId=<?php echo $beer['id']; ?>" style="height:100%">
					<?php 
				        }
							$style = "";							
							if(isset($beer) && isset($beer['tapRgba']) && $beer['tapRgba']) $style = "background-color: ".$htmlHelper->CreateRGB($beer['tapRgba']);
							$imgs = glob ( 'img/tap/tap'.$beer['id'].'.*' );
							if(count($imgs) > 0) $style .= ($style != ""?";":"").'background:url('.$imgs[0].') no-repeat bottom left; background-size:cover; -webkit-border-radius:0px; -mox-border-radius:0px; height:100%; width:50px';
							?>
							<span class="tapcircle" style="<?php echo $style; ?>">
		                    	<?php if(isset($beer['tapNumber']) && $beer['tapNumber'] != 0){echo $beer['tapNumber'];}elseif(count($imgs) == 0){echo $i;}else{echo '&nbsp;';} ?>
                            </span>
						<?php if($config[ConfigNames::AllowSamplePour]){ ?>
						</a>
						<?php }?>
					<?php } else { ?>
	                    <a href ="./includes/pours.php/?bottleId= <?php echo $beer['id']; ?>">
		                    <span class="bottlecircle" style="background-color: <?php echo $htmlHelper->CreateRGB($beer['capRgba']); ?>">
		                    	<?php if($beer['capNumber'] != 0){echo $beer['capNumber'];}else{echo '&nbsp;';} ?>
                            </span>
	                    </a>
					<?php } ?>
					</td>
				<?php } ?>
			
				<?php if($config[ConfigNames::ShowSrmCol]){ ?>
					<td class="srm">
					<?php if(isset($beer) && $beer['beername'] && $beer['srm'] > 0){ ?>						
						<div class="srm-container">
							<?php echo '<div class="srm-indicator" style="background-color:'.$htmlHelper->CreateRGB($beer['srmRgb']).'"></div>'?>
							<div class="srm-stroke"></div> 
						</div>
						
						<h2><?php echo $beer['srm']; ?> SRM</h2>
					<?php }elseif(isset($beer) && $beer['beername']){ echo "<h2>N/A</h2>"; } ?>
					</td>
				<?php } ?>
			
				<?php if($config[ConfigNames::ShowIbuCol]){ ?>
					<td class="ibu">
					<?php if(isset($beer) && $beer['beername']){ ?>
						<?php if($config[ConfigNames::ShowBuGuValue] && $beer['ibu'] != '' && $beer['og']){ ?>
						<h3>
							<?php 
    							$sgOg = convert_gravity($beer['og'], $beer['ogUnit'], UnitsOfMeasure::GravitySG);
    							if( $sgOg > 1 ){
    							    echo number_format((($beer['ibu'])/(($sgOg-1)*1000)), 2, '.', '');
								}else{
									echo '0.00';
								}
							?> 
							BU:GU
						</h3>
						<?php } ?>
						
						<?php if($beer['ibu'] != ''){ ?>
    						<div class="ibu-container">
    							<div class="ibu-indicator"><div class="ibu-full" style="height:<?php echo $beer['ibu'] > 100 ? 100 : $beer['ibu']; ?>%"></div></div>
    						</div>
    						<h2><?php echo $beer['ibu']; ?> IBU</h2>
						<?php }else{ echo "<h2>N/A</h2>"; } ?>
					<?php } ?>
					</td>
				<?php } ?>
			
				<?php if($config[ConfigNames::ShowBreweryImages]){ ?>
					<td style="<?php if($beerColSpan > 1){ echo 'border-left: none;'; } ?>" class="breweryimg" >
					<?php if(isset($beer) && $beer['beername']){ ?>
						<img style="border:0;width:100%" src="<?php echo $beer['breweryImage']; ?>" />
					<?php } ?>
					</td>
				<?php } ?>
				
				<?php if($config[ConfigNames::ShowBeerImages]){ ?>
					<td style="<?php if($beerColSpan > 1){ echo 'border-left: none;'; } ?>" class="beerimg">
					<?php if(isset($beer) && $beer['beername']){ ?>
						<?php 
							beerImg($config, $beer['untID']);
						?>
					<?php } ?>
					</td>
				<?php } ?>
                
				<td class="name" <?php if($beerColSpan > 1){ echo 'style="border-left: none;"'; } ?>>	
					<?php if(isset($beer) && $beer['beername']){ ?>		
                    					
						<?php if($config[ConfigNames::ShowBeerName]){ ?>
                            <h1><?php echo $beer['beername']; ?></h1>
                        <?php } ?>
                        
                        <?php if($config[ConfigNames::ShowBeerStyle]){ ?>
                            <h2 class="subhead"><?php echo str_replace("_","",$beer['style']); ?></h2>
                        <?php } ?>
                        
                        <?php if($config[ConfigNames::ShowBeerNotes]){ ?>
                            <p><?php echo $beer['notes']; ?></p>
                        <?php } ?>
                        
                        <?php 
                            if($config[ConfigNames::ShowBeerRating]){ 
                            	beerRATING($config, $beer['untID']);
                            } 
                        ?>
					
					<?php } ?>
				</td>
    			<?php 
        			$sgOg = $beer['og']?convert_gravity($beer['og'], $beer['ogUnit'], UnitsOfMeasure::GravitySG):NULL;
        			$sgFg = $beer['fg']?convert_gravity($beer['fg'], $beer['fgUnit'], UnitsOfMeasure::GravitySG):NULL;
    			?>
				<?php if(($config[ConfigNames::ShowAbvCol])){ ?>
					<td class="abv">
        			<?php if(isset($beer) && $beer['beername']){?>
    					<?php 
    					$abv = $beer['abv'];
    					if(!isset($abv) && $sgOg && $sgFg) $abv = ($sgOg - $sgFg) * 131; 
    					?>	
    					<?php if(($config[ConfigNames::ShowAbvImg])) { ?>
    						<div class="abv-container">
    							<?php
    							if($abv > 0){
    								$numCups = 0;
    								$remaining = $abv * 20;
    								do{
    									if( $remaining < 100 ){
    											$level = $remaining;
    									}else{
    											$level = 100;
    									}
    									?>
    									<div class="abv-indicator"><div class="abv-full" style="height:<?php echo $level; ?>%"></div></div>
    									<?php
    									
    									$remaining = $remaining - $level;
    									$numCups++;
    								}while($remaining > 0 && $numCups < 2);
    								
    								if( $remaining > 0 ){
    								?>
    								<div class="abv-offthechart"></div>
    								<?php
    								}
            					}else{
                                    echo "N/A";
            					}
    							?>
    						</div>
    					<?php } else { ?>
    						<h2><?php echo number_format($abv, 1, '.', ',')."%"; ?> ABV</h2>
    					<?php } ?>
    					<?php if(isset($beer)){ ?>
    						<?php if($config[ConfigNames::ShowCalories]){ ?>
    						<h3><?php
    						if( $sgOg > 0 && $sgFg > 0){
    							$calfromalc = (1881.22 * ($sgFg * $sgOg - $sgFg))/(1.775 - $sgOg);
    							$calfromcarbs = 3550.0 * $sgFg * ((0.1808 * $sgOg) + (0.8192 * $sgFg) - 1.0004);
    							if ( ($sgOg == 1) && ($sgFg == 1 ) ) {
    								$calfromalc = 0;
    								$calfromcarbs = 0;
    							}
    							echo number_format($calfromalc + $calfromcarbs), " kCal";
    						}else{
    						    echo "N/A";
    						}
    							?>
    						</h3>
    						<?php } ?>
    					<?php if($config[ConfigNames::ShowGravity] && $beer['og'] > 0){ ?>
    						<h3>OG:<?php echo convert_gravity($beer['og'], $beer['ogUnit'], $config[ConfigNames::DisplayUnitGravity]); echo $config[ConfigNames::DisplayUnitGravity] != UnitsOfMeasure::GravitySG?$config[ConfigNames::DisplayUnitGravity]:''; ?></h3>
    					<?php } ?>
    				<?php } ?>
				<?php } ?>
				</td>								
			<?php } ?>
				
			<?php if($config[ConfigNames::ShowKegCol]){ ?>
				<td class="keg" colspan="2">
				<?php if(isset($beer) && $beer['beername']){ ?>
				<?php 
				//Convert to the correct units (use gal and l)
				    $beer['startAmount']  = convert_volume($beer['startAmount'], $beer['startAmountUnit'], $config[ConfigNames::DisplayUnitVolume], TRUE);
					$beer['startAmountUnit'] = $config[ConfigNames::DisplayUnitVolume];
				    $beer['remainAmount'] = convert_volume($beer['remainAmount'], $beer['remainAmountUnit'], $config[ConfigNames::DisplayUnitVolume], TRUE);
					$beer['remainAmountUnit'] = $config[ConfigNames::DisplayUnitVolume]; 
				?>
					<?php if($tapOrBottle == ConfigNames::CONTAINER_TYPE_KEG){ ?>
						<h3><?php echo number_format($beer['startAmount'] - $beer['remainAmount'], 1); echo (is_unit_imperial($config[ConfigNames::DisplayUnitVolume])?"Gal":"L"); ?> poured</h3>
					<?php } else { ?>
						<h3><?php echo $beer['remainAmount'].' x '.number_format(convert_volume($beer['volume'], $beer['volumeUnit'], $config[ConfigNames::DisplayUnitVolume]), 1); echo $config[ConfigNames::DisplayUnitVolume];?></h3> 
					<?php } ?>
					<?php 
    					if($config[ConfigNames::ShowKegImg]){
    						$kegImgClass = "";
    						$percentRemaining = 0.0;
    						if($beer['startAmount'] && $beer['startAmount'] > 0)$percentRemaining = ($beer['remainAmount'] / $beer['startAmount']) * 100;
    						if( $beer['remainAmount'] <= 0 ) {
    							$kegImgClass = $tapOrBottle."-empty";
    							$percentRemaining = 100; 
    						} else if( $percentRemaining < 15 ) {
    							$kegImgClass = "-red";
    						} else if( $percentRemaining < 25 ) {
    							$kegImgClass = "-orange";
    						} else if( $percentRemaining < 45 ) {
    							$kegImgClass = "-yellow";
    						} else if ( $percentRemaining < 100 ) {
    							$kegImgClass = "-green";
    						} else if( $percentRemaining >= 100 ) {
    							$kegImgClass = "-full";
    						}
    						$kegImgClass = strtolower($tapOrBottle).$kegImgClass;
    						$kegOn = "";
    						if($config[ConfigNames::UseTapValves]){
    						    if ( $tapOrBottle == ConfigNames::CONTAINER_TYPE_KEG &&
    						        $beer['valvePinState'] == $config[ConfigNames::RelayTrigger] ) 
    								$kegOn = "keg-enabled";
    							else
    								$kegOn = "keg-disabled";
    						}
					?>
    					<div class="keg-container">
    						<?php if($tapOrBottle == ConfigNames::CONTAINER_TYPE_KEG){ ?>
    							<div class="keg-indicator">
    								<div class="keg-full <?php echo $kegImgClass ?>" style="height:<?php echo $percentRemaining; ?>%; width: 100%" >
    								       <div class="<?php echo $kegOn ?>"></div>
    								</div>
    							</div>
    						<?php } else { ?>
    							<div class="bottle-indicator">
    								<div class="bottle-full <?php echo $kegImgClass ?>" style="height:<?php echo $percentRemaining; ?>%">
    								</div>
    							</div>
    						<?php } ?>
    					</div>
    					<?php }?>
						<?php if($tapOrBottle == ConfigNames::CONTAINER_TYPE_KEG){ ?>
							<h3><?php echo number_format($beer['remainAmount'], 1); echo (is_unit_imperial($config[ConfigNames::DisplayUnitVolume])?"Gal":"L"); ?> left</h3>
						<?php } ?>
				<?php } ?>
				</td>
			<?php } ?>
			</tr>
		<?php } ?>
	</tbody>
</table>