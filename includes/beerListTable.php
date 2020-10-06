<?php
//Only to be called from /includes/common.php printBeerList
require_once __DIR__.'/functions.php';
require_once __DIR__.'/../admin/includes/managers/config_manager.php';
require_once __DIR__.'/../admin/includes/html_helper.php';
$config = getAllConfigs();
$htmlHelper = new HtmlHelper();
$beerColSpan = 1;
$MAX_COLUMNS = 7;
$editting = (isset($editingTable) && $editingTable);

$maxTapCol = isset($config[ConfigNames::HozTapListCol])?$config[ConfigNames::HozTapListCol]+1:1;
if($editting) $maxTapCol = 1;
?>

<table>
	<?php if($editting || $config[ConfigNames::ShowBeerTableHead]){?>
	<?php echo !$editting?'<thead>':'<tbody>' ?>
		<tr>
		<?php for($tapCol = 0; $tapCol< $maxTapCol && $numberOfBeers > $tapCol; $tapCol++){ ?>
			<?php $beerColSpan = 1; ?>
			<?php for($col = 1; $col <= $MAX_COLUMNS; $col++){ ?>
    			<?php if(($editting || $config[ConfigNames::ShowTapNumCol]) &&
				         beerListShouldDisplayRow($editting, $col, $config[ConfigNames::TapNumColNum])){ ?>
    				<th class="tap-num">
    					<!--TAP<br>#-->
						<?php DisplayEditShowColumn($editting, $config, $col, ConfigNames::TapNumColNum)?>
    					<input type="hidden" name="<?php echo ConfigNames::TapNumColNum;?>" id="<?php echo ConfigNames::TapNumColNum;?>" value="<?php echo abs($config[ConfigNames::TapNumColNum]);?>"/>
					</th>
    			<?php } ?>
    			
    			<?php if(($editting || $config[ConfigNames::ShowSrmCol]) &&
				         beerListShouldDisplayRow($editting, $col, $config[ConfigNames::SrmColNum])){ ?>
    				<th class="srm">
    					COLOR
						<?php DisplayEditShowColumn($editting, $config, $col, ConfigNames::SrmColNum)?>
    					<input type="hidden" name="<?php echo ConfigNames::SrmColNum;?>" id="<?php echo ConfigNames::SrmColNum;?>" value="<?php echo abs($config[ConfigNames::SrmColNum]);?>"/>
					</th>
    			<?php } ?>
    			
    			<?php if(($editting || $config[ConfigNames::ShowIbuCol]) &&
				         beerListShouldDisplayRow($editting, $col, $config[ConfigNames::IbuColNum])){ ?>
    				<th class="ibu">
    					<?php if($config[ConfigNames::ShowBuGuValue]){ ?>
    						BALANCE<hr>
    					<?php } ?>
    					BITTERNESS
						<?php DisplayEditShowColumn($editting, $config, $col, ConfigNames::IbuColNum)?>
    					<input type="hidden" name="<?php echo ConfigNames::IbuColNum;?>" id="<?php echo ConfigNames::IbuColNum;?>" value="<?php echo abs($config[ConfigNames::IbuColNum]);?>"/>
					</th>
    			<?php } ?>
    		
    			<?php if( beerListShouldDisplayRow($editting, $col, $config[ConfigNames::BeerInfoColNum])){?>
        			<?php if($config[ConfigNames::ShowBeerName]){ ?>
        				<?php 
                            if($config[ConfigNames::ShowBreweryImages]){ $beerColSpan++; }
                            if($config[ConfigNames::ShowBeerImages]){ $beerColSpan++; }
                        ?> 
        				<th <?php if($beerColSpan > 1){ echo 'colspan="'.$beerColSpan.'"';}?> class="beername"  <?php if($maxTapCol!=1) echo 'style="width:'.(100/$maxTapCol).'%";'?>>
        					<?php if($config[ConfigNames::ShowBeerName]){ ?>
        						BEER NAME 
        						<?php if($config[ConfigNames::ShowBeerStyle]){ ?>&nbsp; &nbsp; STYLE<hr><?php } ?>
        						<?php if($config[ConfigNames::ShowBeerNotes]){ ?>&nbsp; &nbsp; TASTING NOTES<?php } ?>
        						<?php if($config[ConfigNames::ShowBeerRating]){?>&nbsp; &nbsp; RATING<hr><?php } ?>
        					<?php } ?>
							<?php DisplayEditShowColumn($editting, $config, $col, ConfigNames::BeerInfoColNum)?>
    					<input type="hidden" name="<?php echo ConfigNames::BeerInfoColNum;?>" id="<?php echo ConfigNames::BeerInfoColNum;?>" value="<?php echo abs($config[ConfigNames::BeerInfoColNum]);?>"/>
        				</th>
        			<?php } ?>
    			<?php }?>
    			<?php if(($editting || $config[ConfigNames::ShowAbvCol]) &&
				         beerListShouldDisplayRow($editting, $col, $config[ConfigNames::AbvColNum])){ ?>
    				<th class="abv">
    					ABV
    					<?php if($config[ConfigNames::ShowCalories]){ ?>
    					  	<hr>CALORIES
    					<?php } ?>
    					<?php if($config[ConfigNames::ShowGravity]){ ?>
    						<hr>GRAVITY
    					<?php } ?>
						<?php DisplayEditShowColumn($editting, $config, $col, ConfigNames::AbvColNum)?>
    					<input type="hidden" name="<?php echo ConfigNames::AbvColNum;?>" id="<?php echo ConfigNames::AbvColNum;?>" value="<?php echo abs($config[ConfigNames::AbvColNum]);?>"/>
    				</th>
    			<?php } ?>
    			
    			<?php if(($editting || $config[ConfigNames::ShowKegCol]) &&
				         beerListShouldDisplayRow($editting, $col, $config[ConfigNames::KegColNum])){ ?>
    				<th class="keg">
    					DRINKS<hr>REMAINING
						<?php DisplayEditShowColumn($editting, $config, $col, ConfigNames::KegColNum)?>
    					<input type="hidden" name="<?php echo ConfigNames::KegColNum;?>" id="<?php echo ConfigNames::KegColNum;?>" value="<?php echo abs($config[ConfigNames::KegColNum]);?>"/>
    				</th>
    			<?php } ?>
    			
    			<?php if(($editting || $config[ConfigNames::ShowAccoladeCol]) &&
				         beerListShouldDisplayRow($editting, $col, $config[ConfigNames::AccoladeColNum])){ ?>
    				<th class="accolades">
    					Accolades
						<?php DisplayEditShowColumn($editting, $config, $col, ConfigNames::AccoladeColNum)?>
    					<input type="hidden" name="<?php echo ConfigNames::AccoladeColNum;?>" id="<?php echo ConfigNames::AccoladeColNum;?>" value="<?php echo abs($config[ConfigNames::AccoladeColNum]);?>"/>
    				</th>
    			<?php } ?>
			<?php } ?>
			<?php if($maxTapCol > 1 && $tapCol != $maxTapCol-1){ echo "<td style=width:70px;></td>"; } ?>
		<?php } ?>
		</tr>
	<?php echo !$editting?'</thead><tbody>':'' ?>
	<?php }?>
		<?php for($i = 1; $i <= ceil($numberOfBeers/$maxTapCol); $i++) {
			$beer = null;
			if( isset($beers[$i]) ) $beer = $beers[$i];
			if($tapOrBottle != ConfigNames::CONTAINER_TYPE_KEG  && !isset($beer) ) continue;
		?>
			<tr class="<?php if($i%2 > 0){ echo 'altrow'; }?>" id="<?php echo $beer['id']; ?>">
				<?php 
			    for($tapCol = 0; $tapCol< $maxTapCol && $numberOfBeers > $tapCol; $tapCol++){
        			$beer = null;
        			if( $i+($tapCol * (ceil($numberOfBeers/$maxTapCol))) > $numberOfBeers ) continue;//Skip numbers outside of the tap range
        			if( isset($beers[$i+($tapCol * (ceil($numberOfBeers/$maxTapCol)))]) ) $beer = $beers[$i+($tapCol * (ceil($numberOfBeers/$maxTapCol)))];
        			if($tapOrBottle != ConfigNames::CONTAINER_TYPE_KEG  && !isset($beer) ) continue;
        		?>
				<?php for($col = 1; $col <= $MAX_COLUMNS; $col++){ ?>
				<?php if(($editting || $config[ConfigNames::ShowTapNumCol]) &&
				         beerListShouldDisplayRow($editting, $col, $config[ConfigNames::TapNumColNum])){ ?>
					<td class="tap-num">
					<?php if($tapOrBottle == ConfigNames::CONTAINER_TYPE_KEG){ 
					    if($config[ConfigNames::AllowSamplePour]){
					?>
						<a <?php if(!$editting){?>href ="./includes/pours.php/?tapId=<?php echo $beer['id']; ?>"<?php }?> style="height:100%">
					<?php 
				        }
							$style = "";							
							if(isset($beer) && isset($beer['tapRgba']) && $beer['tapRgba']) $style = "background-color: ".$htmlHelper->CreateRGB($beer['tapRgba']);
							$imgs = glob ( 'img/tap/tap'.$beer['id'].'.*' );
							if(count($imgs) > 0) $style .= ($style != ""?";":"").'background:url('.$imgs[0].') no-repeat center; background-size:cover; -webkit-border-radius:0px; -mox-border-radius:0px; height:100px; width:50px';
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
			
				<?php if(($editting || $config[ConfigNames::ShowSrmCol]) &&
				         beerListShouldDisplayRow($editting, $col, $config[ConfigNames::SrmColNum])){ ?>
					<td class="srm">
					<?php if(isset($beer) && $beer['beername'] && $beer['srm'] >= 0){ ?>						
						<div class="srm-container">
							<?php if($config[ConfigNames::ShowSrmImg]){?>
								<?php echo '<img src="'.($editting?'../':'').'img/srm/'.($beer['srm']>40?40:floor($beer['srm'])).'-srm.png" />'?>
							<?php }else{?>
						   		<img width="100%" src="img/srm/containerSvg.php?container=<?php echo $beer['containerType']; ?>&rgb=<?php echo $beer['srmRgb']; ?>" />
							<?php }?>
						</div>
						
    					<?php if($config[ConfigNames::ShowSrmValue]){?>
    						<h2><?php echo $beer['srm']; ?> SRM</h2>
						<?php }?>
					<?php }elseif(isset($beer) && $beer['beername']){ echo "<h2>N/A</h2>"; } ?>
					</td>
				<?php } ?>
			
				<?php if(($editting || $config[ConfigNames::ShowIbuCol]) &&
				         beerListShouldDisplayRow($editting, $col, $config[ConfigNames::IbuColNum])){ ?>
					<td class="ibu">
					<?php if(isset($beer) && $beer['beername']){ ?>
						<?php if(($editting || $config[ConfigNames::ShowBuGuValue]) && $beer['ibu'] != '' && $beer['og']){ ?>
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
						
							<?php if($config[ConfigNames::ShowIbuImg]){ ?>
    						<div class="ibu-container">
    							<div class="ibu-indicator"><div class="ibu-full" style="height:<?php echo $beer['ibu'] > 100 ? 100 : $beer['ibu']; ?>%"></div></div>
    						</div>
    						<?php } ?>
							<?php if($config[ConfigNames::ShowIbuValue]){ ?>
    						<h2><?php echo $beer['ibu']; ?> IBU</h2>
    						<?php }?>
						<?php }else{ echo "<h2>N/A</h2>"; } ?>
					<?php } ?>
					</td>
				<?php } ?>
				<?php if( beerListShouldDisplayRow($editting, $col, $config[ConfigNames::BeerInfoColNum]) ){?>
				<?php if($config[ConfigNames::ShowBreweryImages]){ ?>
					<td class="breweryimg" >
					<?php if(isset($beer) && $beer['beername']){ ?>
						<img style="border:0;width:100px" src="<?php echo $beer['breweryImage']; ?>" />
					<?php } ?>
					</td>
				<?php } ?>
				
				<?php if($config[ConfigNames::ShowBeerImages]){ ?>
				<?php /* If not the first column in the beer section 
				       ($beerColSpan = 1 if just beer 
				        $beerColSpan = 2 if breweryimg or beerimg and beer, 
				        $beerColSpan = 3 if all 3
				 */ ?>
					<td style="<?php if($beerColSpan > 2){ echo 'border-left: none;'; } ?>" class="beerimg">
					<?php if(isset($beer) && $beer['beername']){ ?>
						<?php 
						beerImg($config, $beer['untID'], $beer['beerId']);
						?>
					<?php } ?>
					</td>
				<?php } ?>
                
				<!-- If not the first column in the beer section-->
				<td class="name" <?php if($beerColSpan > 1){ echo 'style="border-left: none; width : '.($maxTapCol==1?($beerColSpan > 2?80:90).'%"':'50%"'); } ?>
							     <?php if($beerColSpan == 1){ echo 'style="width : '.(100/$maxTapCol).'%"'; } ?>>	
					<?php if(isset($beer) && $beer['beername']){ ?>		
                    					
						<?php if($config[ConfigNames::ShowBeerName]){ ?>
                            <h1><?php echo $beer['beername']; ?></h1>
                        <?php } ?>
                        
                        <?php if(($editting || $config[ConfigNames::ShowBeerStyle]) && $beer['style']){ ?>
                            <h2 class="subhead"><?php echo str_replace("_","",$beer['style']); ?></h2>
                        <?php } ?>
                        
                        <?php if($config[ConfigNames::ShowBeerNotes]){ ?>
                            <p><?php echo $beer['notes']; ?></p>
                        <?php } ?>
                        
                        <?php 
                            if($config[ConfigNames::ShowBeerRating]){ 
                                beerRATING($config, $beer['untID'], $beer['rating']);
                            } 
                        ?>
					
					<?php } ?>
				</td>
				<?php } ?>
    			<?php 
        			$sgOg = $beer['og']?convert_gravity($beer['og'], $beer['ogUnit'], UnitsOfMeasure::GravitySG):NULL;
        			$sgFg = $beer['fg']?convert_gravity($beer['fg'], $beer['fgUnit'], UnitsOfMeasure::GravitySG):NULL;
    			?>
				<?php if(($config[ConfigNames::ShowAbvCol] &&
				         beerListShouldDisplayRow($editting, $col, $config[ConfigNames::AbvColNum]))){ ?>
					<td class="abv">
        			<?php if(isset($beer) && $beer['beername']){?>
    					<?php 
    					$abv = $beer['abv'];
    					if(!isset($abv) && $sgOg && $sgFg) $abv = ($sgOg - $sgFg) * 131; 
    					?>	
    					<?php if(($config[ConfigNames::ShowAbvImg])) { ?>
    						<div class="abv-container">
							<?php
							if(NULL !== $abv && $abv>=0){
							?>
								<div class="abv-indicator" style="  background: url(img/abv/abvSvg.php?container=<?php echo $beer['containerType']; ?>&empty) no-repeat bottom left;"><div class="abv-full" style="height:100%;  background: url(img/abv/abvSvg.php?container=<?php echo $beer['containerType']; ?>&fill=<?php echo $abv * 20; ?>&rgb=<?php echo $config[ConfigNames::AGVColorSRM]?$beer['srmRgb']:"255,165,0"?>) no-repeat bottom left;"></div></div>
							<?php
							}else{
							?>
							  N/A
							<?php 
							}
							?>
    						</div>
    					<?php } 
    					if((!$config[ConfigNames::ShowAbvImg] ||
    					     $config[ConfigNames::ShowAbvTxtWImg] )){ ?>
    						<?php if(NULL !== $abv && $abv>=0){?><h2><?php echo number_format($abv, 1, '.', ',')."%"; ?> ABV</h2><?php }?>
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
    					<?php if(($editting || $config[ConfigNames::ShowGravity]) && $beer['og'] > 0){ ?>
    						<h3>OG:<?php echo convert_gravity($beer['og'], $beer['ogUnit'], $config[ConfigNames::DisplayUnitGravity]); echo $config[ConfigNames::DisplayUnitGravity] != UnitsOfMeasure::GravitySG?$config[ConfigNames::DisplayUnitGravity]:''; ?></h3>
    					<?php } ?>
    				<?php } ?>
				<?php } ?>
				</td>								
			<?php } ?>
				
			<?php if(($editting || $config[ConfigNames::ShowKegCol]) &&
				         beerListShouldDisplayRow($editting, $col, $config[ConfigNames::KegColNum])){ ?>
				<td class="keg" >
				<?php if(isset($beer) && $beer['beername']){ ?>
				<?php 
				//Convert to the correct units (use gal and l)
				    $beer['startAmount']  = convert_volume($beer['startAmount'], $beer['startAmountUnit'], $config[ConfigNames::DisplayUnitVolume], TRUE);
					$beer['startAmountUnit'] = $config[ConfigNames::DisplayUnitVolume];
				    $beer['remainAmount'] = convert_volume($beer['remainAmount'], $beer['remainAmountUnit'], $config[ConfigNames::DisplayUnitVolume], TRUE);
					$beer['remainAmountUnit'] = $config[ConfigNames::DisplayUnitVolume]; 
				?>
				<?php } ?>
				<?php if(isset($beer) && $beer['beername'] && 
				         $beer['startAmount'] > 0){ ?>
					<?php if(($editting || $config[ConfigNames::ShowLastPouredValue]) &&
					         $tapOrBottle == ConfigNames::CONTAINER_TYPE_KEG &&
					         isset($beer['lastPour']) && $beer['lastPour'] != ''){ ?>
    					<h3><?php echo $beer['lastPour']?></h3>
    				<?php }?>
					<?php if($config[ConfigNames::ShowPouredValue]){?>
					<?php if($tapOrBottle == ConfigNames::CONTAINER_TYPE_KEG){ ?>
						<h3><?php echo number_format($beer['startAmount'] - $beer['remainAmount'], 1); echo (is_unit_imperial($config[ConfigNames::DisplayUnitVolume])?"Gal":"L"); ?> poured</h3>
					<?php } else { ?>
						<h3><?php echo $beer['remainAmount'].' x '.number_format(convert_volume($beer['volume'], $beer['volumeUnit'], $config[ConfigNames::DisplayUnitVolume]), 1); echo $config[ConfigNames::DisplayUnitVolume];?></h3> 
					<?php } ?>
					<?php } ?>
					<?php 
    					if($config[ConfigNames::ShowKegImg]){
    					    $kegImgColor = "0,255,0";
    						$percentRemaining = 0.0;
    						if($beer['startAmount'] && $beer['startAmount'] > 0)$percentRemaining = ($beer['remainAmount'] / $beer['startAmount']) * 100;
    						if( $beer['remainAmount'] <= 0 ) {
    						    $percentRemaining = 0;
    						} else if( $percentRemaining < 15 ) {
    						    $kegImgColor = "255,0,0";
    						} else if( $percentRemaining < 25 ) {
    						    $kegImgColor = "255,165,0";
    						} else if( $percentRemaining < 45 ) {
    						    $kegImgColor = "255,255,0";
    						} else if ( $percentRemaining < 100 ) {
    						    $kegImgColor = "0,255,0";
    						} else if( $percentRemaining >= 100 ) {
    						    $kegImgColor = "0,255,0";
    						}
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
    							<?php 
							     $kegType="keg";
							     if(strtolower(substr($beer['kegType'], 0, 4)) == "corn") $kegType = "corny";
							    ?>
    							<div class="keg-indicator" style="background: url(img/keg/kegSvg.php?container=<?php echo $kegType?>&empty) no-repeat bottom left;"> 
								<div class="keg-full" style="height:100%; width: 100%; background: url(img/keg/kegSvg.php?container=<?php echo $kegType?>&fill=<?php echo $percentRemaining; ?>&rgb=<?php echo $kegImgColor ?>) no-repeat bottom left;" >
    								       <div class="<?php echo $kegOn ?>"></div>
    								       <?php if($percentRemaining>=100){?><div style="height:100%;"><h1 style="height:100%;text-align: center;padding-top: 50%; color:white;  text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;">FULL</h1></div><?php }?>
    									   <?php if($percentRemaining<=0){?><div style="height:100%;"><h1 style="height:100%;text-align: center;padding-top: 50%; color:White;  text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;">MT</h1></div><?php }?>
    								</div>
    							</div>
    						<?php } else { ?>
    							<div class="bottle-indicator">
    								<div class="bottle-full" style="height:100%; background: url(img/bottle/bottleSvg.php?container=bottle&fill=<?php echo $percentRemaining; ?>&rgb=<?php echo $kegImgColor ?>) no-repeat bottom left;">
    								</div>
    							</div>
    						<?php } ?>
    					</div>
    					<?php }?>
						<?php if($tapOrBottle == ConfigNames::CONTAINER_TYPE_KEG){ ?>							
							<h3>
							<?php 
							 if( !isset($config[ConfigNames::AmountPerPint]) || $config[ConfigNames::AmountPerPint] == 0) {
							     echo number_format($beer['remainAmount'], 1); echo (is_unit_imperial($config[ConfigNames::DisplayUnitVolume])?"Gal":"L");
							 }else{
							     $beer['remainAmount'] = convert_volume($beer['remainAmount'], $beer['remainAmountUnit'], $config[ConfigNames::DisplayUnitVolume], FALSE, TRUE);
							     echo number_format($beer['remainAmount']/$config[ConfigNames::AmountPerPint], 1); echo "Pints";
							 }
							?> 
							left</h3>
						<?php } ?>
				<?php }elseif( isset($beer) && $beer['beername'] && 
				               isset($beer['lastPour']) && $beer['lastPour'] != ''){ ?>
					<?php if($config[ConfigNames::ShowPouredValue]){?>
						<h3>Last pour:<br/><?php echo $beer['lastPour']?></h3>
					<?php } ?>
				<?php }?>
				</td>
			<?php } ?>
			
				<?php if(($editting || $config[ConfigNames::ShowAccoladeCol]) &&
				         beerListShouldDisplayRow($editting, $col, $config[ConfigNames::AccoladeColNum])){ ?>
					<td class="accolades">
    				<table>
					<?php 
    					$accolades = explode(",",$beer['accolades']);
    					$img = "";
    					$maxAccRows = $config[ConfigNames::NumAccoladeDisplay];
    					for($accCol = 0; $accCol < $maxAccRows; $accCol++){
    				?>
    					<tr>
    					<?php 
    					for($ii = $accCol; $ii < count($accolades); $ii+=$maxAccRows){
    					    $accolade = $accolades[$ii];
    					    $accParts = explode("~", $accolade);
    					    if(count($accParts) < 3) continue;
    					    $style = "";
    					    $imgs = glob ( 'img/accolade/accolade'.$accParts[0].'.*' );
    					    if(count($imgs) > 0) $img = $imgs[0];
    					    ?>
    					    <td style="vertical-align: middle; border-right: none"><?php echo $accParts[2] ?></td>
    					    <td style="vertical-align: middle; border-left: none;" ><span class="tooltip"><img style="height: 40px" src="<?php echo $img; ?>" /><span class="tooltiptext" ><?php echo $accParts[1];?></span></span><?php if($img=="")echo $accParts[1];?></td>

                    <?php 
    					    }
				 	?>
					 	</tr>
					 <?php 
    					}
					 ?>
    				</table>
					</td>
				<?php } ?>
			<?php } //End for column loop ?>
			<?php if($maxTapCol > 1 && $tapCol != $maxTapCol-1){ echo "<td style=width:70px;></td>"; } ?>
			<?php } //End for tap column loop ?>
			</tr>
		<?php } ?>
	</tbody>
</table>