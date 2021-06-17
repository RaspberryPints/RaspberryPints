<?php
//Only to be called from /includes/common.php printBeerList
require_once __DIR__.'/functions.php';
require_once __DIR__.'/../admin/includes/managers/config_manager.php';
require_once __DIR__.'/../admin/includes/html_helper.php';
$config = getAllConfigs();
$htmlHelper = new HtmlHelper();
$beerColSpan = 1;
/** @var mixed $editingTable */
$editting = (isset($editingTable) && $editingTable);
$MAX_COLUMNS = 7;
if(!$editting){
    $showColumns = getAllConfigsLike('%ColNum');
    $MAX_COLUMNS = max($showColumns);
}
$maxTapCol = isset($config[ConfigNames::HozTapListCol])?$config[ConfigNames::HozTapListCol]+1:1;
if($editting) $maxTapCol = 1;
?>

<table id="beerList">
	<?php if($editting || $config[ConfigNames::ShowBeerTableHead]){?>
	<?php echo !$editting?'<thead>':'<tbody>' ?>
		<tr>
		<?php /** @var mixed $numberOfBeers */ for($tapCol = 0; $tapCol< $maxTapCol && $numberOfBeers > $tapCol; $tapCol++){ ?>
			<?php $beerColSpan = 1; ?>
			<?php for($col = 1; $col <= $MAX_COLUMNS; $col++){ ?>
    			<?php if(beerListShouldDisplayRow($editting, $col, $config[ConfigNames::TapNumColNum])){ ?>
    				<th class="tap-num<?php if(!$config[ConfigNames::ShowBeerTableHead]){echo ' disabled';}?>">
    					<?php if($editting)echo 'TAP<br>'; ?>
						<?php DisplayEditShowColumn($editting, $config, $col, ConfigNames::TapNumColNum)?>
    					<input type="hidden" name="<?php echo ConfigNames::TapNumColNum;?>" id="<?php echo ConfigNames::TapNumColNum;?>" value="<?php echo abs($config[ConfigNames::TapNumColNum]);?>"/>
					</th>
    			<?php } ?>
    			
    			<?php if(beerListShouldDisplayRow($editting, $col, $config[ConfigNames::SrmColNum])){ ?>
    				<th class="srm<?php if(!$config[ConfigNames::ShowBeerTableHead]){echo ' disabled';}?>">
    					COLOR
						<?php DisplayEditShowColumn($editting, $config, $col, ConfigNames::SrmColNum)?>
    					<input type="hidden" name="<?php echo ConfigNames::SrmColNum;?>" id="<?php echo ConfigNames::SrmColNum;?>" value="<?php echo abs($config[ConfigNames::SrmColNum]);?>"/>
					</th>
    			<?php } ?>
    			
    			<?php if(beerListShouldDisplayRow($editting, $col, $config[ConfigNames::IbuColNum])){ ?>
    				<th class="ibu<?php if(!$config[ConfigNames::ShowBeerTableHead]){echo ' disabled';}?>">
    					<?php if($config[ConfigNames::ShowBuGuValue]){ ?>
    						BALANCE<hr>
    					<?php } ?>
    					BITTERNESS
						<?php DisplayEditShowColumn($editting, $config, $col, ConfigNames::IbuColNum)?>
    					<input type="hidden" name="<?php echo ConfigNames::IbuColNum;?>" id="<?php echo ConfigNames::IbuColNum;?>" value="<?php echo abs($config[ConfigNames::IbuColNum]);?>"/>
					</th>
    			<?php } ?>
    		
    			<?php if( beerListShouldDisplayRow($editting, $col, $config[ConfigNames::BeerInfoColNum])){?>
    				<?php 
                        if($editting || $config[ConfigNames::ShowBreweryImages]){ $beerColSpan++; }
                        if($editting || $config[ConfigNames::ShowBeerImages]){ $beerColSpan++; }
                    ?> 
    				<th <?php if($beerColSpan > 1){ echo 'colspan="'.$beerColSpan.'"';}?> class="beername<?php if(!$config[ConfigNames::ShowBeerTableHead]){echo ' disabled';}?>"  <?php if($maxTapCol!=1) echo 'style="width:'.(100/$maxTapCol).'%";'?>>
    					<?php if($editting || $config[ConfigNames::ShowBeerName]){ ?>BEER NAME <?php } ?>
						<?php if($editting || $config[ConfigNames::ShowBeerStyle]){ ?>&nbsp; &nbsp; STYLE<hr><?php } ?>
						<?php if($editting || $config[ConfigNames::ShowBeerNotes]){ ?>&nbsp; &nbsp; TASTING NOTES<?php } ?>
						<?php if($editting || $config[ConfigNames::ShowBeerRating]){?>&nbsp; &nbsp; RATING<hr><?php } ?>
						<?php DisplayEditShowColumn($editting, $config, $col, ConfigNames::BeerInfoColNum)?>
					<input type="hidden" name="<?php echo ConfigNames::BeerInfoColNum;?>" id="<?php echo ConfigNames::BeerInfoColNum;?>" value="<?php echo abs($config[ConfigNames::BeerInfoColNum]);?>"/>
    				</th>
    			<?php }?>
    			<?php if(beerListShouldDisplayRow($editting, $col, $config[ConfigNames::AbvColNum])){ ?>
    				<th class="abv <?php if(!$config[ConfigNames::ShowBeerTableHead]){echo ' disabled';}?>" <?php if( !$editting && $maxTapCol > 0 && $tapCol == $maxTapCol-1 && $col == $MAX_COLUMNS){echo 'style="padding-right:20px"';}?>>
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
    			
    			<?php if(beerListShouldDisplayRow($editting, $col, $config[ConfigNames::KegColNum])){ ?>
    				<th class="keg<?php if(!$config[ConfigNames::ShowBeerTableHead]){echo ' disabled';}?>">
    					DRINKS<hr>REMAINING
						<?php DisplayEditShowColumn($editting, $config, $col, ConfigNames::KegColNum)?>
    					<input type="hidden" name="<?php echo ConfigNames::KegColNum;?>" id="<?php echo ConfigNames::KegColNum;?>" value="<?php echo abs($config[ConfigNames::KegColNum]);?>"/>
    				</th>
    			<?php } ?>
    			
    			<?php if(beerListShouldDisplayRow($editting, $col, $config[ConfigNames::AccoladeColNum])){ ?>
    				<th class="accolades<?php if(!$config[ConfigNames::ShowBeerTableHead]){echo ' disabled';}?>">
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
			/** @var mixed $beers */
			/** @var mixed $tapOrBottle */
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
				<?php if(beerListShouldDisplayRow($editting, $col, $config[ConfigNames::TapNumColNum])){ ?>
					<td class="tap-num">
					<?php if($tapOrBottle == ConfigNames::CONTAINER_TYPE_KEG){ ?>
    					<?php if(!$editting && $config[ConfigNames::AllowSamplePour]){ ?>
    						<a href ="./includes/pours.php/?tapId=<?php echo $beer['id']; ?>" style="height:100%">
    					<?php }?>
						<?php 
							$style = "";							
							if(isset($beer) && isset($beer['tapRgba']) && $beer['tapRgba']) $style = "background-color: ".$htmlHelper->CreateRGB($beer['tapRgba']);
							$imgs = glob ( 'img/tap/tap'.$beer['id'].'.*' );
							if(count($imgs) > 0) $style .= ($style != ""?";":"").'background:url('.$imgs[0].') no-repeat center; background-size:cover; -webkit-border-radius:0px; -mox-border-radius:0px; height:100px; width:50px';
							?>
							<span id="tapId" class="tapcircle" style="<?php echo $style; ?>">
		                    	<?php if(isset($beer['tapNumber']) && $beer['tapNumber'] != 0){echo $beer['tapNumber'];}elseif(count($imgs) == 0){echo $i;}else{echo '&nbsp;';} ?>
                            </span>
	                    	<?php if($editting){
	                    	    echo "<input type=\"hidden\" name=\"configs[]\" value=\"".ConfigNames::AllowSamplePour."\" />";
	                    	    echo "<span class=\"tooltip\"><input type=\"checkbox\" name=\"".ConfigNames::AllowSamplePour."\" value=\"1\"".($config[ConfigNames::AllowSamplePour]?" checked ":"").'>Sample Allowed<span class="tooltiptext" >Allow pressing the tap id to pour a sample</span></span>';
        					}?>
						<?php if(!$editting && $config[ConfigNames::AllowSamplePour]){ ?>
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
			
				<?php if(beerListShouldDisplayRow($editting, $col, $config[ConfigNames::SrmColNum])){ ?>
					<td class="srm">
					<?php if(isset($beer) && $beer['beername'] && $beer['srm'] >= 0){ ?>	
						<div>					
						<div class="srm-container">
							<?php if($editting || $config[ConfigNames::ShowSrmImg]){?>
								<?php echo '<img id="srmImg"'.($editting &&! $config[ConfigNames::ShowSrmImg]?'style="display:none"':'').' src="'.($editting?'../':'').'img/srm/'.($beer['srm']>40?40:floor($beer['srm'])).'-srm.png" />'?>
							<?php }if($editting || !$config[ConfigNames::ShowSrmImg]){?>
						   		<img width="100%" id="srmSvg" <?php echo $editting && $config[ConfigNames::ShowSrmImg]?'style="display:none"':'' ?> src="<?php echo ($editting?'../':'') ?>img/srm/containerSvg.php?container=<?php echo $beer['containerType']; ?>&rgb=<?php echo $beer['srmRgb']; ?>" />
							<?php }?>
						</div>
						<?php if($editting){
    						echo "<input type=\"hidden\" name=\"configs[]\" value=\"".ConfigNames::ShowSrmImg."\" />";
    						echo "<input type=\"checkbox\" name=\"".ConfigNames::ShowSrmImg."\" value=\"1\"".($config[ConfigNames::ShowSrmImg]?" checked ":"").' onchange="if(!$(this)[0].checked){$(\'#srmSvg\').show();$(\'#srmImg\').hide();}else{$(\'#srmSvg\').hide();$(\'#srmImg\').show();};">Image';
						}
						?>
						</div>
    					<?php if($editting || $config[ConfigNames::ShowSrmValue]){?>
    						<h2 id="srm" <?php if($editting && !$config[ConfigNames::ShowSrmValue])echo 'class="disabled"';?>><?php echo $beer['srm']; ?> SRM
						<?php DisplayEditCheckbox($editting, $config, ConfigNames::ShowSrmValue, 'srm'); ?></h2>
						<?php }?>
					<?php }elseif(isset($beer) && $beer['beername']){ echo "<h2>N/A</h2>"; } ?>
					</td>
				<?php } ?>
			
				<?php if(beerListShouldDisplayRow($editting, $col, $config[ConfigNames::IbuColNum])){ ?>
					<td class="ibu">
					<?php if(isset($beer) && $beer['beername']){ ?>
						<?php if(($editting || $config[ConfigNames::ShowBuGuValue]) && $beer['ibu'] != '' && $beer['og']){ ?>
						<h3 id="bugu" <?php if($editting && !$config[ConfigNames::ShowBuGuValue])echo 'class="disabled"';?>>
							<?php 
    							$sgOg = convert_gravity($beer['og'], $beer['ogUnit'], UnitsOfMeasure::GravitySG);
    							if( $sgOg > 1 ){
    							    echo number_format((($beer['ibu'])/(($sgOg-1)*1000)), 2, '.', '');
								}else{
									echo '0.00';
								}
							?> 
							BU:GU
						<?php DisplayEditCheckbox($editting, $config, ConfigNames::ShowBuGuValue, "bugu"); ?>
						</h3>
						<?php } ?>
						
						<?php if($beer['ibu'] != ''){ ?>
						
							<?php if($editting || $config[ConfigNames::ShowIbuImg]){ ?>
    						<div id="ibuImg" <?php if($editting && !$config[ConfigNames::ShowIbuImg])echo 'class="disabled"';?>>
    						<div class="ibu-container">
    							<div class="ibu-indicator"><div class="ibu-full" style="height:<?php echo $beer['ibu'] > 100 ? 100 : $beer['ibu']; ?>%"></div></div>
    						</div>
						    <?php DisplayEditCheckbox($editting, $config, ConfigNames::ShowIbuImg, 'ibuImg'); ?>
						    </div>
    						<?php } ?>
							<?php if($editting || $config[ConfigNames::ShowIbuValue]){ ?>
    						<h2 id="ibu" <?php if($editting && !$config[ConfigNames::ShowIbuValue])echo 'class="disabled"';?>><?php echo $beer['ibu']; ?> IBU
							<?php DisplayEditCheckbox($editting, $config, ConfigNames::ShowIbuValue, 'ibu'); ?></h2>
    						<?php }?>
						<?php }else{ echo "<h2>N/A</h2>"; } ?>
					<?php } ?>
					</td>
				<?php } ?>
				<?php if( beerListShouldDisplayRow($editting, $col, $config[ConfigNames::BeerInfoColNum]) ){?>
				<?php if($editting || $config[ConfigNames::ShowBreweryImages]){ ?>
					<td id="breweryImg" class="breweryimg<?php if($editting && !$config[ConfigNames::ShowBreweryImages])echo ' disabled';?>" >
					<?php if(isset($beer) && $beer['beername']){ ?>
						<img style="border:0;width:100px" src="<?php echo $beer['breweryImage']; ?>" />
						<?php DisplayEditCheckbox($editting, $config, ConfigNames::ShowBreweryImages, 'breweryImg'); ?>
					<?php } ?>
					</td>
				<?php } ?>
				
				<?php if($editting || $config[ConfigNames::ShowBeerImages]){ ?>
				<?php /* If not the first column in the beer section 
				       ($beerColSpan = 1 if just beer 
				        $beerColSpan = 2 if breweryimg or beerimg and beer, 
				        $beerColSpan = 3 if all 3
				 */ ?>
					<td id="beerImg" style="<?php if($beerColSpan > 2){ echo 'border-left: none;'; } ?>" class="beerimg<?php if($editting && !$config[ConfigNames::ShowBeerImages])echo ' disabled';?>">
					<?php if(isset($beer) && $beer['beername']){ ?>
						<?php 
						beerImg($config, $beer['untID'], $beer['beerId']);
						DisplayEditCheckbox($editting, $config, ConfigNames::ShowBeerImages, 'beerImg');
						?>
					<?php } ?>
					</td>
				<?php } ?>
                
				<!-- If not the first column in the beer section-->
				<td class="name" <?php if($beerColSpan > 1){ echo 'style="border-left: none; width : '.($maxTapCol==1?($beerColSpan > 2?80:90).'%"':'50%"'); } ?>
							     <?php if($beerColSpan == 1){ echo 'style="width : '.(100/$maxTapCol).'%"'; } ?>>	
					<?php if(isset($beer) && $beer['beername']){ ?>		
                    					
						<?php if($editting || $config[ConfigNames::ShowBeerName]){ ?>
                            <h1 id="beerName" <?php if($editting && !$config[ConfigNames::ShowBeerName])echo 'class="disabled"';?>><?php echo $beer['beername']; ?>
							<?php DisplayEditCheckbox($editting, $config, ConfigNames::ShowBeerName, 'beerName'); ?></h1>
                        <?php } ?>
                        
                        <?php if(($editting || $config[ConfigNames::ShowBeerStyle]) && $beer['style']){ ?>
                            <h2 id="beerStyle" class="subhead<?php if($editting && !$config[ConfigNames::ShowBeerStyle])echo ' disabled';?>"><?php echo str_replace("_","",$beer['style']); ?>
							<?php DisplayEditCheckbox($editting, $config, ConfigNames::ShowBeerStyle, 'beerStyle'); ?></h2>
                        <?php } ?>
                        
                        <?php if($editting || $config[ConfigNames::ShowBeerNotes]){ ?>
                            <p id="beerNotes" <?php if($editting && !$config[ConfigNames::ShowBeerNotes])echo 'class="disabled"';?>><?php echo htmlentities($beer['notes'],ENT_QUOTES| ENT_IGNORE); ?>
							<?php DisplayEditCheckbox($editting, $config, ConfigNames::ShowBeerNotes, 'beerNotes'); ?></p>
                        <?php } ?>
                        
                        <?php 
                            if($editting || $config[ConfigNames::ShowBeerRating]){ 
                                echo  '<div id="beerRating" '.(($editting && !$config[ConfigNames::ShowBeerRating])?'class="disabled"':'').'>';
                                beerRATING($config, $beer['untID'], $beer['rating']);
                                DisplayEditCheckbox($editting, $config, ConfigNames::ShowBeerRating, 'beerRating');
                                echo '</div>';
                            } 
                        ?>
					
					<?php } ?>
				</td>
				<?php } ?>
    			<?php 
        			$sgOg = $beer['og']?convert_gravity($beer['og'], $beer['ogUnit'], UnitsOfMeasure::GravitySG):NULL;
        			$sgFg = $beer['fg']?convert_gravity($beer['fg'], $beer['fgUnit'], UnitsOfMeasure::GravitySG):NULL;
    			?>
				<?php if(beerListShouldDisplayRow($editting, $col, $config[ConfigNames::AbvColNum])){ ?>
					<td class="abv" <?php if( !$editting && $maxTapCol > 0 && $tapCol == $maxTapCol-1 && $col == $MAX_COLUMNS){echo 'style="padding-right:20px"';}?>>
        			<?php if(isset($beer) && $beer['beername']){?>
    					<?php 
    					$abv = $beer['abv'];
    					if(!isset($abv) && $sgOg && $sgFg) $abv = ($sgOg - $sgFg) * 131; 
    					?>	
    					<?php if(($editting || $config[ConfigNames::ShowAbvImg])) { ?>
    						<div id="abvImg" class="abv-container<?php if($editting && !$config[ConfigNames::ShowAbvImg])echo ' disabled';?>">
							<?php
							if(NULL !== $abv && $abv>=0){
							?>
								<div class="abv-indicator" style="  background: url(<?php echo ($editting?'../':'') ?>img/abv/abvSvg.php?container=<?php echo $beer['containerType']; ?>&empty) no-repeat bottom left;"><div class="abv-full" style="height:100%;  background: url(<?php echo ($editting?'../':'') ?>img/abv/abvSvg.php?container=<?php echo $beer['containerType']; ?>&fill=<?php echo $abv * 20; ?>&rgb=<?php echo $config[ConfigNames::ABVColorSRM]?$beer['srmRgb']:"255,165,0"?>) no-repeat bottom left;"></div></div>
							<?php
							}else{
							?>
							  N/A
							<?php 
							}
							?>
    						</div>
    						<?php DisplayEditCheckbox($editting, $config, ConfigNames::ShowAbvImg, 'abvImg', false); ?>
    					<?php } 
    					if($editting || (!$config[ConfigNames::ShowAbvImg] ||
    					     $config[ConfigNames::ShowAbvTxtWImg] )){ ?>
    						<?php if(NULL !== $abv && $abv>=0){?>
								<h2 id="abvTxt" <?php if($editting && !$config[ConfigNames::ShowAbvTxtWImg])echo 'class="disabled"';?>><?php echo number_format($abv, 1, '.', ',')."%"; ?> ABV<?php DisplayEditCheckbox($editting, $config, ConfigNames::ShowAbvTxtWImg, 'abvTxt'); ?>
								</h2><?php }?>
    						<?php } ?>
    					<?php if(isset($beer)){ ?>
    						<?php if($editting || $config[ConfigNames::ShowCalories]){ ?>
    						<h3 id="calories" <?php if($editting && !$config[ConfigNames::ShowCalories])echo 'class="disabled"';?>><?php
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
							<?php DisplayEditCheckbox($editting, $config, ConfigNames::ShowCalories, 'calories'); ?>
    						</h3>
    						<?php } ?>
    					<?php if(($editting || $config[ConfigNames::ShowGravity]) && $beer['og'] > 0){ ?>
    						<h3 id="gravity" <?php if($editting && !$config[ConfigNames::ShowGravity])echo 'class="disabled"';?>>OG:<?php echo convert_gravity($beer['og'], $beer['ogUnit'], $config[ConfigNames::DisplayUnitGravity]); echo $config[ConfigNames::DisplayUnitGravity] != UnitsOfMeasure::GravitySG?$config[ConfigNames::DisplayUnitGravity]:''; ?>
							<?php DisplayEditCheckbox($editting, $config, ConfigNames::ShowGravity, 'gravity'); ?></h3>
    					<?php } ?>
    				<?php } ?>
				<?php } ?>
				</td>								
			<?php } ?>
				
			<?php if(beerListShouldDisplayRow($editting, $col, $config[ConfigNames::KegColNum])){ ?>
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
				             isset($beer['lastPour']) && strval($beer['lastPour']) != ''){ ?>
    					<h3 id="lastPour" <?php if($editting && !$config[ConfigNames::ShowLastPouredValue])echo 'class="disabled"';?>><?php echo convert_volume($beer['lastPour'], $beer['lastPourUnit'], $config[ConfigNames::DisplayUnitVolume]);?> Last
							<?php DisplayEditCheckbox($editting, $config, ConfigNames::ShowLastPouredValue, 'lastPour'); ?></h3>
    				<?php }?>
					<?php if($editting || $config[ConfigNames::ShowPouredValue]){?>
    					<?php if($tapOrBottle == ConfigNames::CONTAINER_TYPE_KEG){ ?>
    						<h3 id="poured" <?php if($editting && !$config[ConfigNames::ShowPouredValue])echo 'class="disabled"';?>><?php echo number_format($beer['startAmount'] - $beer['remainAmount'], 1); echo (is_unit_imperial($config[ConfigNames::DisplayUnitVolume])?" Gal":" L"); ?> poured
							<?php DisplayEditCheckbox($editting, $config, ConfigNames::ShowPouredValue, 'poured'); ?></h3>
    					<?php } else { ?>
    						<h3><?php echo $beer['remainAmount'].' x '.number_format(convert_volume($beer['volume'], $beer['volumeUnit'], $config[ConfigNames::DisplayUnitVolume]), 1); echo $config[ConfigNames::DisplayUnitVolume];?></h3> 
    					<?php } ?>
					<?php } ?>
					<?php 
    					if($editting || $config[ConfigNames::ShowKegImg]){
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
    					<div id="kegImg" <?php if($editting && !$config[ConfigNames::ShowKegImg])echo 'class="disabled"';?>>
    					<div class="keg-container">
    						<?php if($tapOrBottle == ConfigNames::CONTAINER_TYPE_KEG){ ?>
    							<div class="keg-indicator" style="background: url(<?php echo ($editting?'../':'') ?>img/keg/kegSvg.php?container=<?php echo $beer['kegType']?>&empty) no-repeat bottom left;"> 
								<div class="keg-full" style="height:100%; width: 100%; background: url(<?php echo ($editting?'../':'') ?>img/keg/kegSvg.php?container=<?php echo $beer['kegType']?>&fill=<?php echo $percentRemaining; ?>&rgb=<?php echo $kegImgColor ?>) no-repeat bottom left;" >
    								       <div class="<?php echo $kegOn ?>"></div>
    								       <?php if($percentRemaining>=100){?><div style="height:100%;"><h1 style="height:100%;text-align: center;padding-top: 50%; color:white;  text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;">FULL</h1></div><?php }?>
    									   <?php if($percentRemaining<=0){?><div style="height:100%;"><h1 style="height:100%;text-align: center;padding-top: 50%; color:White;  text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;">MT</h1></div><?php }?>
    								</div>
    							</div>
    						<?php } else { ?>
    							<div class="bottle-indicator">
    								<div class="bottle-full" style="height:100%; background: url(<?php echo ($editting?'../':'') ?>img/bottle/bottleSvg.php?container=bottle&fill=<?php echo $percentRemaining; ?>&rgb=<?php echo $kegImgColor ?>) no-repeat bottom left;">
    								</div>
    							</div>
    						<?php } ?>
    					</div>
						<?php DisplayEditCheckbox($editting, $config, ConfigNames::ShowKegImg, 'kegImg',false); ?>
    					</div>
    					<?php }?>
						<?php if($tapOrBottle == ConfigNames::CONTAINER_TYPE_KEG && ($editting || $config[ConfigNames::ShowRemainValue])){ ?>							
							<h3 id="remaining" <?php if($editting && !$config[ConfigNames::ShowRemainValue])echo 'class="disabled"';?>>
							<?php 
							if( $editting || (!isset($config[ConfigNames::AmountPerPint]) || $config[ConfigNames::AmountPerPint] == 0)) {
							    echo '<div id="volLeft" '.(!(!isset($config[ConfigNames::AmountPerPint]) || $config[ConfigNames::AmountPerPint] == 0)?'style="display:none"':'').'>'.number_format($beer['remainAmount'], 1); echo (is_unit_imperial($config[ConfigNames::DisplayUnitVolume])?" Gal":" L").' Left</div>';
							}
							if($editting || !( !isset($config[ConfigNames::AmountPerPint]) || $config[ConfigNames::AmountPerPint] == 0)){
							    $beer['remainAmount'] = convert_volume($beer['remainAmount'], $beer['remainAmountUnit'], $config[ConfigNames::DisplayUnitVolume], FALSE, TRUE);
							    echo '<div id="pintsLeft"'.((!isset($config[ConfigNames::AmountPerPint]) || $config[ConfigNames::AmountPerPint] == 0)?'style="display:none"':'').'>'.number_format($beer['remainAmount']/$config[ConfigNames::AmountPerPint], 1); echo " Pints Left</div>";
							}
							?>
							<?php DisplayEditCheckbox($editting, $config, ConfigNames::ShowRemainValue, 'remaining'); ?></h3>
							<?php if($editting){?><span class="tooltip">Amount (<?php echo $config[ConfigNames::DisplayUnitVolume]?>) Per Pint:<input type="number" min="0" class="smallbox" style="background-repeat: unset;" value="<?php echo $config[ConfigNames::AmountPerPint]; ?>" name="<?php echo ConfigNames::AmountPerPint; ?>" onchange="updateKegLeftText(this)"><span class="tooltiptext">If greater than 0 then pints remaining will be displayed</span></span><?php }?> 
						<?php } ?>
				<?php }elseif( isset($beer) && $beer['beername'] && 
				               isset($beer['lastPour']) && strval($beer['lastPour']) != ''){ ?>
					<?php if($editting || $config[ConfigNames::ShowLastPouredValue]){?>
						<h3 id="lastPour" <?php if($editting && !$config[ConfigNames::ShowLastPouredValue])echo 'class="disabled"';?>>Last pour:<br/><?php echo convert_volume($beer['lastPour'], $beer['lastPourUnit'], $config[ConfigNames::DisplayUnitVolume]);?>
							<?php DisplayEditCheckbox($editting, $config, ConfigNames::ShowLastPouredValue, 'lastPour'); ?></h3>
					<?php } ?>
				<?php }?>
				</td>
			<?php } ?>
			
				<?php if(beerListShouldDisplayRow($editting, $col, $config[ConfigNames::AccoladeColNum])){ ?>
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
    					    $imgs = glob ( ($editting?'../':'').'img/accolade/accolade'.$accParts[0].'.*' );
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
    				<?php if($editting){?>Max Accolades to Show:<input type="text" class="smallbox" style="background-repeat: unset;" value="<?php echo $config[ConfigNames::NumAccoladeDisplay]; ?>" name="<?php echo ConfigNames::NumAccoladeDisplay;?>"><?php }?>
					</td>
				<?php } ?>
			<?php } //End for column loop ?>
			<?php if($maxTapCol > 1 && $tapCol != $maxTapCol-1){ echo "<td style=width:70px;></td>"; } ?>
			<?php } //End for tap column loop ?>
			</tr>
		<?php } ?>
	</tbody>
</table>