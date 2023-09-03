<?php
	//Only to be called from /includes/common.php printBeerList
	require_once __DIR__.'/functions.php';
	require_once __DIR__.'/../admin/includes/managers/config_manager.php';	
	require_once __DIR__.'/../admin/includes/html_helper.php';
	require_once __DIR__.'/common.php';
	/** @var mixed $config **/
	/** @var mixed $pours **/
	if(!isset($config)) $config = getAllConfigs();
	$htmlHelper = new HtmlHelper();
	//$pourManager = new PourManager();
	$beerColSpan = 1;
	$i = 0;
	/** @var mixed $editingTable **/
	$editting = (isset($editingTable) && $editingTable);
	$config[ConfigNames::ShowVerticleTapList] = "0";
?>

<table style="width:100%">
	<thead>
		<tr>
			<?php if($editting || $config[ConfigNames::ShowPourDate]){ ?>
				<th class="poursdate">
					Date
				<?php DisplayEditCheckbox($editting, $config, ConfigNames::ShowPourDate)?>
				</th>
			<?php } ?>	
			<?php if($editting || $config[ConfigNames::ShowPourTapNumCol]){ ?>
				<th class="pourstap-num">
					TAP
				<?php DisplayEditCheckbox($editting, $config, ConfigNames::ShowPourTapNumCol)?>
				</th>
			<?php } ?>					
			<?php if($editting || $config[ConfigNames::ShowPourBeerName]){ ?>
				<?php 
				if($editting || $config[ConfigNames::ShowPourBreweryImages]){ $beerColSpan++; }
				if($editting || $config[ConfigNames::ShowPourBeerImages]){ $beerColSpan++; }
                ?> 
				<th <?php if($beerColSpan > 1){ echo 'colspan="'.$beerColSpan.'"';}?> class="poursbeername">
					<?php if($editting || $config[ConfigNames::ShowPourBeerName]){ 
					    echo (isset($config[ConfigNames::PourBeerCol])?$config[ConfigNames::PourBeerCol]:"BEER");
					    DisplayEditCheckbox($editting, $config, ConfigNames::ShowPourBeerName);
					} ?>
				</th>
			<?php } ?>						
			<?php if($editting || $config[ConfigNames::ShowPourAmount]){ ?>
				<th class="poursamount">
					Amount (<?php echo $config[ConfigNames::DisplayUnitVolume] ?>)
					    <?php DisplayEditCheckbox($editting, $config, ConfigNames::ShowPourAmount)?>
				</th>
			<?php } ?>
			<?php if($editting || $config[ConfigNames::ShowPourUserName]){ ?>
				<th class="poursuser">
					User
					    <?php DisplayEditCheckbox($editting, $config, ConfigNames::ShowPourUserName)?>
				</th>
			<?php } ?>	
		</tr>
	</thead>
	<tbody>
		<?php foreach($pours as $pour) {
			$i++;
		?>
			<tr class="<?php if($i%2 > 0){ echo 'altrow'; }?>">
			<?php if($editting || $config[ConfigNames::ShowPourDate]){ ?>
				<td class="poursdate">
					<h2><?php echo $pour->get_createdDateFormatted(); ?></h2>
				</td>
			<?php } ?>	
				<?php if($editting || $config[ConfigNames::ShowPourTapNumCol]){ ?>
					<td class="pourstap-num">
                    <span class="tapcircle" <?php if($pour->get_tapRgba()) echo "style=\"background-color: ".$htmlHelper->CreateRGB($pour->get_tapRgba())."\""; ?>> 
						<?php echo $pour->get_tapNumber(); ?>
                    </span>
					</td>
				<?php } ?>
			
				<?php if($editting || $config[ConfigNames::ShowPourBreweryImages]){ ?>
					<td style="<?php if($beerColSpan > 1){ echo 'border-left: none;'; } ?>" class="poursbreweryimg" >
					<?php if(null !== $pour->get_breweryImageUrl()){ ?>
						<img style="border:0;width:100px" src="<?php echo $pour->get_breweryImageUrl(); ?>" />
					<?php } ?>
					</td>
				<?php } ?>
						
				<?php if($editting || $config[ConfigNames::ShowPourBeerImages]){ ?>
                    <td style="<?php if($beerColSpan > 1){ echo 'border-left: none;'; } ?>" class="poursbeerimg">	
                    <?php beerImg($config, $pour->get_beerUntID(), $pour->get_beerId()); ?>
                    </td>
                <?php } ?>
					
				<?php if($editting || $config[ConfigNames::ShowPourBeerName]){ ?>
					<td class="poursbeername" <?php if($beerColSpan > 1){ echo 'style="border-left: none;"'; } ?>>	
						<h1><?php echo $pour->get_beerName(); ?></h1>
					</td>
				<?php } ?>
							
				<?php if($editting || $config[ConfigNames::ShowPourAmount]){ ?>
                    <td class="poursamount">
                        <h2><?php echo $pour->get_amountPouredDisplay(); ?></h2>
                    </td>
                <?php } ?>
                
				<?php if($editting || $config[ConfigNames::ShowPourUserName]){ ?>
					<td class="poursuser">
        				<?php if($pour->get_userName()){ ?>
        						<h2><?php echo $pour->get_userName(); ?></h2>
						<?php } ?>
					</td>
				<?php } ?>
			</tr>
				
		<?php } ?>
	</tbody>
</table>