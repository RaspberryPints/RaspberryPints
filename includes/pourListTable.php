<?php
	//Only to be called from /includes/common.php printBeerList
	require_once __DIR__.'/functions.php';
	require_once __DIR__.'/../admin/includes/managers/config_manager.php';	
	require_once __DIR__.'/../admin/includes/html_helper.php';	
	$config = getAllConfigs();
	$htmlHelper = new HtmlHelper();
	$pourManager = new PourManager();
	$beerColSpan = 1;
	$i = 0;
?>

<table style="width:100%">
	<thead>
		<tr>
			<?php if($config[ConfigNames::ShowPourDate]){ ?>
				<th class="poursdate">
					Date
				</th>
			<?php } ?>	
			<?php if($config[ConfigNames::ShowPourTapNumCol]){ ?>
				<th class="pourstap-num">
					TAP
				</th>
			<?php } ?>					
			<?php if($config[ConfigNames::ShowPourBeerName]){ ?>
				<?php 
                    if($config[ConfigNames::ShowPourBreweryImages]){ $beerColSpan++; }
                    if($config[ConfigNames::ShowPourBeerImages]){ $beerColSpan++; }
                ?> 
				<th <?php if($beerColSpan > 1){ echo 'colspan="'.$beerColSpan.'"';}?> class="poursbeername">
					<?php if($config[ConfigNames::ShowPourBeerName]){ ?>
						BEER 
					<?php } ?>
				</th>
			<?php } ?>						
			<?php if($config[ConfigNames::ShowPourAmount]){ ?>
				<th class="poursamount">
					Amount (<?php echo getConfigValue(ConfigNames::DisplayUnits) ?>)
				</th>
			<?php } ?>
			<?php if($config[ConfigNames::ShowPourUserName]){ ?>
				<th class="poursuser">
					User
				</th>
			<?php } ?>	
		</tr>
	</thead>
	<tbody>
		<?php foreach($pours as $pour) {
			$i++;
		?>
			<tr class="<?php if($i%2 > 0){ echo 'altrow'; }?>">
			<?php if($config[ConfigNames::ShowPourDate]){ ?>
				<td class="poursdate">
					<h2><?php echo $pour->get_createdDate(); ?></h2>
				</td>
			<?php } ?>	
				<?php if($config[ConfigNames::ShowPourTapNumCol]){ ?>
					<td class="pourstap-num">
                    <span class="tapcircle" <?php if($pour->get_tapRgba()) echo "style=\"background-color: ".$htmlHelper->CreateRGB($pour->get_tapRgba())."\""; ?>> 
						<?php echo $pour->get_tapNumber(); ?>
                    </span>
					</td>
				<?php } ?>
			
				<?php if($config[ConfigNames::ShowPourBreweryImages]){ ?>
					<td style="<?php if($beerColSpan > 1){ echo 'border-left: none;'; } ?>" class="poursbreweryimg" >
					<?php if(null !== $pour->get_breweryImageUrl()){ ?>
						<img style="border:0;width:100%" src="<?php echo $pour->get_breweryImageUrl(); ?>" />
					<?php } ?>
					</td>
				<?php } ?>
						
				<?php if($config[ConfigNames::ShowPourBeerImages]){ ?>
                    <td style="<?php if($beerColSpan > 1){ echo 'border-left: none;'; } ?>" class="poursbeerimg">	
                    <?php beerImg($config, $pour->get_beerUntID()); ?>
                    </td>
                <?php } ?>
					
				<?php if($config[ConfigNames::ShowPourBeerName]){ ?>
					<td class="poursbeername" <?php if($beerColSpan > 1){ echo 'style="border-left: none;"'; } ?>>	
						<h1><?php echo $pour->get_beerName(); ?></h1>
					</td>
				<?php } ?>
							
				<?php if($config[ConfigNames::ShowPourAmount]){ ?>
                    <td class="poursamount">
                        <h2><?php echo $pourManager->getDisplayAmount($pour->get_amountPoured()) ; ?></h2>
                    </td>
                <?php } ?>
                
				<?php if($config[ConfigNames::ShowPourUserName]){ ?>
					<td class="poursuser">
						<h2><?php echo $pour->get_userName(); ?></h2>
					</td>
				<?php } ?>
			</tr>
				
		<?php } ?>
	</tbody>
</table>