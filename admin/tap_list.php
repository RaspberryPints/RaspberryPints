<?php
require_once __DIR__.'/header.php';
$htmlHelper = new HtmlHelper();
$tapManager = new TapManager();
$beerManager = new BeerManager();
$kegManager = new KegManager();

$config = getAllConfigs();

const TAP_TEXT_ENABLE =  "Let it flow";
const TAP_TEXT_DISABLE = "Stop flow";

$reconfig = false;
if( isset($_POST['enableTap']) && $_POST['enableTap'] != ""){
	//The element holds the tap Id
	$tapManager->enableTap($_POST['enableTap']);
	file_get_contents('http://' . $_SERVER['SERVER_NAME'] . '/admin/trigger.php?value=valve');
}

if( isset($_POST['disableTap']) && $_POST['disableTap'] != ""){
	//The element holds the tap Id
	$tapManager->disableTap($_POST['disableTap']);
	file_get_contents('http://' . $_SERVER['SERVER_NAME'] . '/admin/trigger.php?value=valve');
}

if (isset ( $_POST ['saveTapConfig'] )) {
	$ii = 0;
	while(isset($_POST ['tapId'][$ii]))
	{
		$id = $_POST ['tapId'][$ii];
		$tap = $tapManager->GetById($id);		
		if (isset ( $_POST ['tapNumber'][$ii] )) {
			$tap->set_tapNumber($_POST ['tapNumber'][$ii]);
		}
		$kegSelArr = explode("~", $_POST['kegId'][$ii]);
		//Select array is kegid~beerid(in keg)~tapId(keg is on)~etc
		$kegId = null;
		if(count($kegSelArr) > 0 && isset($kegSelArr[0]))$kegId = $kegSelArr[0];
		if($kegId){			
		    $selectedBeerId = explode("~", $_POST['beerId'][$ii])[0];
			$keg = $kegManager->GetById($kegId);
			if( $_POST ['startAmount'][$ii] != $_POST ['startAmountOriginal'][$ii]) {
			    $keg->set_startAmount($_POST['startAmount'][$ii]);
			    $keg->set_startAmountUnit($_POST['startAmountUnit'][$ii]);
			    if(convert_volume($keg->get_maxVolume(), $keg->get_maxVolumeUnit(), $_POST['startAmountUnit'][$ii], TRUE) < ($_POST['startAmount'][$ii])){;
    			    $keg->set_maxVolume($_POST['startAmount'][$ii]);
    			    $keg->set_maxVolumeUnit($_POST['startAmountUnit'][$ii]);
    			}
			}
			if( ISSET($_POST ['currentAmount']) && 
			    ISSET($_POST ['currentAmountOriginal']) && 
			    $_POST ['currentAmount'][$ii] != $_POST ['currentAmountOriginal'][$ii]) {
			     $keg->set_currentAmount($_POST['currentAmount'][$ii]);
			     $keg->set_currentAmountUnit($_POST['currentAmountUnit'][$ii]);
			}
			if( ISSET($_POST ['currentWeight']) && 
			    ISSET($_POST ['currentWeightOriginal']) &&
			    $_POST ['currentWeight'][$ii] != $_POST ['currentWeightOriginal'][$ii]) {
			     $keg->set_Weight($_POST['currentWeight'][$ii]);
			     $keg->set_WeightUnit($_POST['currentWeightUnit'][$ii]);
			}
    		if (isset ( $_POST ['fermentationPSI'][$ii] ) && 
    		    $_POST['defaultFermentiationPSI'][$ii] != 0 &&
    		    $_POST ['fermentationPSI'][$ii] != $_POST ['fermentationPSIOriginal'][$ii]) {
    		    $keg->set_fermentationPSI($_POST ['fermentationPSI'][$ii]);
    		    $keg->set_fermentationPSIUnit($_POST ['fermentationPSIUnit'][$ii]);
    		}
    		
    	    if (isset ( $_POST ['keggingTemp'][$ii] ) &&
    	        $_POST['defaultKeggingTemp'][$ii] != 0 &&
    	        $_POST ['keggingTemp'][$ii] != $_POST ['keggingTempOriginal'][$ii]) {
    		    $keg->set_keggingTemp($_POST ['keggingTemp'][$ii]);
    		    $keg->set_keggingTempUnit($_POST ['keggingTempUnit'][$ii]);
    		}
			$kegManager->Save($keg);
		    if( ( !isset($kegSelArr[1]) || !$kegSelArr[1] || $tap->get_beerId() != $selectedBeerId ) ||
			    ( !isset($kegSelArr[2]) || !$kegSelArr[2] || $tap->get_kegId() != $kegId ) ){
			        $tapManager->tapKeg($tap, $kegId, $selectedBeerId);		
			}
		}else if($tap->get_kegId()){
			//User indicated the tap was untapped
			$tapManager->closeTap($tap, false);	
		}
		$tapManager->Save($tap);
		
		$tapNumber = "";
		$flowpin = 0;
		$valveon = 0;
		$valvepin = 0;
		$countpergallon = 0;
		$countpergallonUnit = UnitsOfMeasure::VolumeGallon;
		$plaatoAuthToken = "";
		if (isset ( $_POST ['flowpin'][$ii] )) {
			$flowpin = $_POST ['flowpin'][$ii];
		}
	
		if (isset ( $_POST ['valvepin'][$ii] )) {
			$valvepin = $_POST ['valvepin'][$ii] * ($_POST ['valvepinPi'][$id]?-1:1);
		}
		
		if (isset ( $_POST ['tapOverride'][$ii] )) {
		    $valveon = $_POST ['tapOverride'][$ii];
		}
	
		if( isset ( $_POST ['countpergallonOriginal'][$ii] ) &&
		    $_POST ['countpergallon'][$ii] ==  $_POST ['countpergallonOriginal'][$ii] &&
		    $tap->get_count() > 0)
		{
		    $countpergallon = $tap->get_count();
		    $countpergallonUnit = $tap->get_countUnit();
		}else{
    		if (isset ( $_POST ['countpergallon'][$ii] )) {
    			$countpergallon = $_POST ['countpergallon'][$ii];
    		}
    		if (isset ( $_POST ['countpergallonUnit'][$ii] )) {
    			$countpergallonUnit = $_POST ['countpergallonUnit'][$ii];
    		}
		}
		if (isset ( $_POST ['plaatoAuthToken'][$ii] )) {
		    $plaatoAuthToken = $_POST ['plaatoAuthToken'][$ii];
		}
	
		$tapManager->saveTapConfig ( $id, $flowpin, $valvepin, $valveon, $countpergallon, $countpergallonUnit, $plaatoAuthToken );
		$ii++;
	}
	$reconfig = true;
} 
if (isset ( $_POST ['saveSettings'] )) {
	if (isset ( $_POST ['numberOfTaps'] )) {
		$oldTapNumber = $tapManager->getNumberOfTaps();
		$newTapNumber = $_POST ['numberOfTaps'];
		if( !isset($oldTapNumber) || $newTapNumber != $oldTapNumber) {
			$tapManager->updateNumberOfTaps ( $newTapNumber );
		}
		unset($_POST ['numberOfTaps']);
	} 
} 
if (isset ( $_POST ['saveSettings'] ) || isset ( $_POST ['configuration'] )) {
	setConfigurationsFromArray($_POST, $config);
	if (isset ( $_POST ['saveSettings'] ) )$reconfig = true;
}

if($reconfig){
	file_get_contents ( 'http://' . $_SERVER ['SERVER_NAME'] . '/admin/trigger.php?value=all' );
}

$activeTaps = $tapManager->GetAllActive();
$numberOfTaps = count($activeTaps);
$beerList = $beerManager->GetAllActive();
$kegList = $kegManager->GetAllActive();
$allTapsConfigured = $config[ConfigNames::UseFlowMeter];
foreach($activeTaps as $tap)
{
    if(null === $tap)continue;
    $allTapsConfigured = $allTapsConfigured && $tap->get_flowPinId() != 0 && $tap->get_count() != 0;
    if(!$allTapsConfigured)break;
    if($config[ConfigNames::UseTapValves])$allTapsConfigured = $allTapsConfigured && $tap->get_valvePinId() != 0;
    if(!$allTapsConfigured)break;
}
?>
<body>
	<!-- Start Header  -->
<?php
include 'top_menu.php';
?>
	<!-- End Header -->
	<!-- Top Breadcrumb Start -->
	<div id="breadcrumb">
		<ul>	
			<li><img src="img/icons/icon_breadcrumb.png" alt="Location" /></li>
			<li><strong>Location:</strong></li>
			<li class="current">Tap List</li>            
		</ul>
	</div>
	<!-- Top Breadcrumb End --> 
	<!-- Right Side/Main Content Start -->
	<div id="rightside">
		<div class="contentcontainer med left" >
		<?php $htmlHelper->ShowMessage(); ?>
              
        
		<table>
		<tr>
        <td><a onClick="toggleSettings(this, 'settingsDiv')" class="collapsed heading">Settings</a></td>
        <?php if($config[ConfigNames::UseFlowMeter]) {?> <td><input type="checkbox" onclick="togglePinSettings(this)" <?php if(!$allTapsConfigured)echo 'checked';?>/>Show Pin Settings </td><?php }?>
        </tr>
        </table>
		
	<!-- Start Tap Config Form -->
		<div id="settingsDiv" style="<?php echo (isset($_POST['settingsExpanded'])?$_POST['settingsExpanded']:'display:none'); ?>">
        
        <form id="configuration" method="post">
        	<input type="hidden" name="configuration" id="configuration" />
        	<input type="hidden" name="settingsExpanded" id="settingsExpanded" value="<?php echo (isset($_POST['settingsExpanded'])?$_POST['settingsExpanded']:'display:none'); ?>" />
            <table class="contentbox" style="width:100%; border:0;" >
            	<tr>
			<?php
			    $result = getTapConfigurableConfigs();
				foreach($result as $row) {
					echo '<td>';
					echo '	<input type="hidden" name="' . $row['configName'] . '" value="0"/>';
					echo '	<input type="checkbox" ' . ($row['configValue']?'checked':'') . ' name="' . $row['configName'] . '" value="1" onClick="this.form.submit()">'.$row['displayName']."&nbsp;\n";
					echo '</td>';
				}
			?>        
            	</tr>
            </table>
            
        	<?php if($config[ConfigNames::UseKegWeightCalc]) { ?>
				<table class="contentbox" style="width:100%; border:0;" >
					<thead>
					<tr>
						<th></th>
						<th></th>
						<th></th>
					</tr>
					</thead>
    				<tbody>
    					<tr>
    						<td><b>Weight Calculator:</b></td>
    						<td><b>Brewery Altitude:</b><br/>The altitude (<?php echo $config[ConfigNames::DisplayUnitDistance]?>) above see level</td>
    						<td>
    							<input type="text" name="breweryAltitude" class="smallbox" value="<?php echo (convert_distance($config[ConfigNames::BreweryAltitude], $config[ConfigNames::BreweryAltitudeUnit], $config[ConfigNames::DisplayUnitDistance])) ?>">
    							<input type="hidden" name="breweryAltitudeUnit" value="<?php echo $config[ConfigNames::DisplayUnitDistance];?>" >
    						</td>
    					</tr>
    					<tr>
    						<td><b>Weight Calculator:</b></td>
    						<td><b>Only Use Defaults:</b><br/>If you do not want to configure each tap seperately<br/>for each weight calculator setting</td>
    						<td>
								<input type="hidden" name="<?php echo ConfigNames::UseDefWeightSettings; ?>" value="0"/>
								<input type="checkbox" <?php echo $config[ConfigNames::UseDefWeightSettings]?'checked':''; ?> name="<?php echo ConfigNames::UseDefWeightSettings; ?>" value="1">
							</td>
    					</tr>
    					<tr>
    						<td><b>Weight Calculator:</b></td>
    						<td><b>Default Fermentation Pressure:</b><br/>The <?php echo $config[ConfigNames::DisplayUnitPressure]?> of fermentation<br/>0 if not fermenting under pressure</td>
    						<td>
    							<input type="text" name="defaultFermPSI" class="smallbox" value="<?php echo (convert_pressure($config[ConfigNames::DefaultFermPSI], $config[ConfigNames::DefaultFermPSIUnit], $config[ConfigNames::DisplayUnitPressure])) ?>">
    							<input type="hidden" name="defaultFermPSIUnit" value="<?php echo $config[ConfigNames::DisplayUnitPressure];?>" >
    						</td>
    					</tr>
    					<tr>
    						<td><b>Weight Calculator:</b></td>
    						<td><b>Default Kegging Temperature:</b><br/>The Temperature (<?php echo $config[ConfigNames::DisplayUnitTemperature]?>) when transfering into the Keg.<br/>This is used to calculate the CO2 in the beer at that time</td>
    						<td>
    							<input type="text" name="defaultKeggingTemp" class="smallbox" value="<?php echo (convert_temperature($config[ConfigNames::DefaultKeggingTemp], $config[ConfigNames::DefaultKeggingTempUnit], $config[ConfigNames::DisplayUnitTemperature])) ?>">
    							<input type="hidden" name="defaultKeggingTempUnit" value="<?php echo $config[ConfigNames::DisplayUnitTemperature];?>" >
    						</td>
    					</tr>
    					<tr>
    						<td colspan="3">
                            	<input type="submit" name="saveSettings" class="btn" value="Save" />
                                <input type="submit" name="revert"       class="btn" value="Revert" />
                            </td>
    					</tr>
					</tbody>
        		</table>
        	<?php } ?>
        </form>
        
		<form method="POST" name="settings" >        
	<?php if($config[ConfigNames::UseFlowMeter]) { ?>
    		<input type="hidden" name="alamodeConfig" id="alamodeConfig" />
    <?php } ?>
	<?php if($config[ConfigNames::UseFanControl]) { ?>
			<input type="hidden" name="fanConfig" id="fanConfig" />
    <?php } ?>
	<?php if($config[ConfigNames::UseTapValves]) { ?>
			<input type="hidden" name="tapValveConfig" id="tapValveConfig" />
	<?php } ?>
	<?php if($config[ConfigNames::UseKegWeightCalc]) { ?>
			<input type="hidden" name="weightCalcConfig" id="weightCalcConfig" />
	<?php } ?>
			<table class="contentbox" style="width:100%; border:0;" >
				<thead>
					<tr>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>

	<?php if($config[ConfigNames::UseFlowMeter]) { ?>
					<tr>
						<td><b>Alamode Setup:</b></td>
						<td><b>Pour Message Delay:</b><br/>The number of milliseconds after pulses stop to send the pour</td>
						<td><input type="text" name="alamodePourMessageDelay" class="smallbox" value="<?php echo ($config[ConfigNames::AlamodePourMessageDelay]) ?>"></td>
					</tr>
					<tr>
						<td><b>Alamode Setup:</b></td>
						<td><b>Pour Trigger Count:</b><br/> The minimum flow meter count to start a pour</td>
						<td><input type="text" name="alamodePourTriggerCount" class="smallbox" value="<?php echo ($config[ConfigNames::AlamodePourTriggerCount]) ?>"></td>
					</tr>
					<tr>
						<td><b>Alamode Setup:</b></td>
						<td><b>Kick Trigger Count:</b><br/> The flow meter count within one millisecond that indicates a kick</td>
						<td><input type="text" name="alamodeKickTriggerCount" class="smallbox" value="<?php echo ($config[ConfigNames::AlamodeKickTriggerCount]) ?>"></td>
					</tr>
					<tr>
						<td><b>Alamode Setup:</b></td>
						<td><b>Update Trigger Count:</b><br/>The flow meter count after which a internal update is reported</td>
						<td><input type="text" name="alamodeUpdateTriggerCount" class="smallbox" value="<?php echo ($config[ConfigNames::AlamodeUpdateTriggerCount]) ?>"></td>
					</tr>
		<?php } ?>
		<?php if($config[ConfigNames::UseFanControl]) { ?>
					<tr>
						<td><b>Fan Setup:</b></td>
						<td><b>Fan Pin (GPIO):</b><br>The pin that powers the fan</td>
						<td><input type="text" name="useFanPin" class="smallbox" value="<?php echo $config[ConfigNames::UseFanPin] ?>" /></td>
					</tr>
					<tr>
						<td><b>Fan Setup:</b></td>
						<td><b>Fan Interval (mins):</b><br/>The interval with which the fan will be triggered<br/>(every x minutes, turn the fan on).<br/>If zero or less, the fan always runs.</td>
						<td><input type="text" name="fanInterval" class="smallbox"
							value="<?php echo $config[ConfigNames::FanInterval] ?>" /></td>
					</tr>
					<tr>
						<td><b>Fan Setup:</b></td>
						<td><b>Fan Duration (mins):</b><br/>The duration the fan will run after it has been triggered.<br/>If zero or less, the fan never runs.</td>
						<td><input type="text" name="fanOnTime" class="smallbox" value="<?php echo $config[ConfigNames::FanOnTime] ?>" /></td>
					</tr>
					<tr>
						<td><b>Fan Setup:</b></td>
						<td><b>Restart On Pour:</b><br/>If you want the fan to turn on after a pour</td>
						<td>
							<input type="hidden" name="<?php echo ConfigNames::RestartFanAfterPour; ?>" value="0"/>
							<input type="checkbox" <?php echo $config[ConfigNames::RestartFanAfterPour]?'checked':''; ?> name="<?php echo ConfigNames::RestartFanAfterPour; ?>" value="1">
						</td>
					</tr>
	<?php } ?>
	<?php if($config[ConfigNames::UseTapValves]) { ?>
					<tr>
						<td><b>Tap Valves Setup:</b></td>
						<td><b>Pour Shutoff Count:</b><br/>The flow meter count in one pour after which a tap is shutoff (0 to turn off) </td>
						<td><input type="text" name="pourShutOffCount" class="smallbox"	value="<?php echo ($config[ConfigNames::PourShutOffCount]) ?>"></td>
                    </tr>
                    <?php if($config[ConfigNames::Use3WireValves]) {?>
    					<tr>
							<td><b>Tap Valves Setup:</b></td>
    						<td><b>Valve Power Pin:</b><br/>The pin that powers three way the valves </td>
    						<td><input type="text" name="valvesPowerPin" class="smallbox" value="<?php echo ($config[ConfigNames::ValvesPowerPin]) ?>"></td>
    					</tr>
					<?php }?>
					<tr>
						<td><b>Tap Valves Setup:</b></td>
						<td><b>Valve On Time:</b><br/>The time the valves remain on </td>
						<td><input type="text" name="valvesOnTime" class="smallbox" value="<?php echo ($config[ConfigNames::ValvesOnTime]) ?>"></td>
					</tr>
	<?php } ?>
					<tr>
						<td><b>Tap Setup:</b></td>
						<td><b>Number Of Taps:</b><br/>The number of taps in the system</td> 
						<td><input type="text" name="numberOfTaps" class="smallbox" value="<?php echo $numberOfTaps ?>" /></td>
					</tr>
					<tr>
						<td colspan="3">
                        	<input type="submit" name="saveSettings" class="btn" value="Save" />
                            <input type="submit" name="revert"       class="btn" value="Revert" />
                        </td>
					</tr>
			</tbody>
		</table>
	</form>
    </div>
	<!-- End Tap Config Form -->
<br />
	<!-- Start On Tap Section -->
	<?php 
		$tapsErrorMsg = "";
		if( count($beerList) == 0 ){
			$tapsErrorMsg .= "At least 1 beer needs to be created, before you can assign a tap. <a href='beer_form.php'>Click here to create a beer</a><br/>";
		}
		if( count($kegList) == 0 ){
			$tapsErrorMsg .= "At least 1 keg needs to be created, before you can assign a tap. <a href='keg_form.php'>Click here to create a keg</a><br/>";
		}						

		if( strlen($tapsErrorMsg) > 0 ){ 
			echo $htmlHelper->CreateMessage('warning', $tapsErrorMsg);	
		}else{
?>	
	    <form method="POST" id="tap-form" onSubmit='return validateBeerSelected("kegId", "beerId")'>        
                <?php foreach($activeTaps as $tap){ 
	                if(null == $tap)continue; 
				?>
                	<input type="hidden" name="tapId[]" value="<?php echo $tap->get_id(); ?>" />
                <?php } ?> 
    		<div id="messageDiv" class="error status" style="display:none;"><span id="messageSpan"></span></div>
			<table class="contentbox" style="width:75%; border:0;" >
            <thead>
                <tr>
                    <th>Tap<br>Description</th>
                    <th>Keg<br>(OnTap Number)</th>
                    <th style="width:10%">Beer</th>
                    <th><div class="tooltip">Start<br>Amount (<?php echo (is_unit_imperial($config[ConfigNames::DisplayUnitVolume])?"Gal":"L");?>)<span class="tooltiptext">Set to 0 to hide the Remaining Keg on the list</span></div></th>
                    <th>Current<br>Amount(<?php echo (is_unit_imperial($config[ConfigNames::DisplayUnitVolume])?"Gal":"L");?>)</th>
					<?php if($config[ConfigNames::UseKegWeightCalc]) { ?>
                        <th>Current<br>Weight(<?php echo $config[ConfigNames::DisplayUnitWeight]?>)</th>
    					<?php if(!$config[ConfigNames::UseDefWeightSettings]) { ?>
                            <th><div class="tooltip">Fermenter<br>PSI<span class="tooltiptext">0 If not fermenting under pressure</span></div></th>
                            <th><div class="tooltip">Kegging<br>Temp<span class="tooltiptext">Temperature of Beer when kegged<br>room temp if not cold crashing or keg conditioning</span></div></th>
                        <?php } ?>
                    <?php } ?>
                    <?php if($config[ConfigNames::UseFlowMeter]) { ?>
                        <th id="flowPin" <?php if($allTapsConfigured) echo 'style=display:none ' ?>>Flow Pin</th>
                        <th id="flowCount" <?php if($allTapsConfigured) echo 'style=display:none ' ?>>Count<br>Per <?php echo (is_unit_imperial($config[ConfigNames::DisplayUnitVolume])?"Gal":"L");?></th>
                    <?php } ?>
                    <?php if($config[ConfigNames::UseTapValves]) { ?>
                        <th id="valvepin" <?php if($allTapsConfigured) echo 'style=display:none ' ?>>Valve Pin</th>
                        <th id="valvepinPi" <?php if($allTapsConfigured) echo 'style=display:none ' ?>>Valve<br>PI Pin?</th>
                    	<th>Valve<br/>Control</th>
                    	<th>Calibrate</th>
                        <?php if($config[ConfigNames::UsePlaato]) { ?>
                    		<th>Plaato<br/>Auth<br/>Token</th>
                        <?php } ?>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach($activeTaps as $tap){ ?>
                    <?php if(null == $tap)continue; ?> 
                    <tr>
                    <?php 
                        $keg = null;
                        $beer = null;
                        if(null !== $tap->get_kegId())$keg = $kegManager->GetById($tap->get_kegId());
                        if(null !== $keg)$beer = $beerManager->GetById($keg->get_beerId());
                        if(null == $keg)unset($keg);
                        if(null == $beer)unset($beer);
                    ?>
                        <td>
                            <?php 
                            if(isset($tap) ) { 
                            ?>
                            <div style="width:115px">
                               <?php 
                                    $style = "";
                                    $hasImg = false;
                                    if(isset($tap) && null !== $tap->get_tapRgba()) $style = "background-color: ".$htmlHelper->CreateRGB($tap->get_tapRgba());
                                    if(isset($tap))
        							{
        							    $imgs = glob ( '../img/tap/tap'.$tap->get_id().'.*' );
            							if(count($imgs) > 0)
            							{
            							    $style .= ($style != ""?";":"").'background:url('.$imgs[0].') no-repeat bottom left; background-size:cover; -webkit-border-radius:0px; -mox-border-radius:0px; height:100%; width:50px';
            							    $hasImg = true;
            							}
        							}
    							?> 
    							<input type="text" id="tapNumber<?php echo $tap->get_id();?>" class="smallbox" name="tapNumber[]" value="<?php echo $tap->get_tapNumber(); ?>" <?php echo $style != ""?'style="'.$style.'"':""; ?> />
    							<a href="image_prompt.php?id=<?php echo $tap->get_id();?>" target="_blank"><span class="tooltip"><img src="img/icons/upload.png" /><span class="tooltiptext">Upload Tap Image</span></span></a>
                            	<?php if($hasImg) {?>
                            		<a href="image_remove.php?id=<?php echo $tap->get_id();?>&type=tap" target="_blank"><span class="tooltip"><img src="img/icons/icon_missing.png" /><span class="tooltiptext">Remove Tap Image</span></span></a>
                            	<?php }?>
                            </div>
                            <?php } ?>
                        </td>
                        <td>                            
							<?php 					
							    $str = "<select id='kegId".$tap->get_id()."' name='kegId[]' class='' onChange='toggleDisplay(this, \"kegId\", \"beerId\", ".$tap->get_id().", \"".$tap->get_tapNumber()."\")'>\n";
                                $str .= "<option value=''>Select One</option>\n";
                                foreach($kegList as $item){
                                    if( !$item ) continue;
                                    $sel = "";
                                    if( $tap && $tap->get_kegId() == $item->get_id() ) $sel .= "selected ";
                                    $desc = $item->get_id();
                                    if($item->get_label() && $item->get_label() != "" && $item->get_label() != $item->get_id())$desc.="-".$item->get_label();
                                    if($item->get_onTapId()){
                                        if($item->get_tapNumber() != ""){
                                            $desc.="(".$item->get_tapNumber().")";
                                        }else{
                                            $desc.="(".$item->get_onTapId().")";                                        
                                        }
                                    }
                                    //do not change this line (php line)
                                    $val = $item->get_id()."~".$item->get_beerId()."~".$item->get_ontapId()."~";
                                    //Change these lines for Javascript)
                                    $val .= $item->get_emptyWeight().'~'.$item->get_emptyWeightUnit()."~";
                                    $val .= convert_volume($item->get_maxVolume(), $item->get_maxVolumeUnit(), $config[ConfigNames::DisplayUnitVolume], TRUE)."~".$config[ConfigNames::DisplayUnitVolume]."~";
                                    $val .= convert_volume($item->get_startAmount(), $item->get_startAmountUnit(), $config[ConfigNames::DisplayUnitVolume], TRUE)."~".$config[ConfigNames::DisplayUnitVolume]."~";
                                    $val .= convert_volume($item->get_currentAmount(), $item->get_currentAmountUnit(), $config[ConfigNames::DisplayUnitVolume], TRUE)."~".$config[ConfigNames::DisplayUnitVolume]."~";
									$val .= ($item->get_fermentationPSI() != ''?$item->get_fermentationPSI():$config[ConfigNames::DefaultFermPSI])."~";
									$val .= ($item->get_fermentationPSI() != ''?$item->get_fermentationPSIUnit():$config[ConfigNames::DefaultFermPSIUnit])."~";
									$val .= ($item->get_keggingTemp() != ''?$item->get_keggingTemp():$config[ConfigNames::DefaultKeggingTemp])."~";
									$val .= ($item->get_keggingTemp() != ''?$item->get_keggingTempUnit():$config[ConfigNames::DefaultKeggingTempUnit]);
									$str .= "<option value='".$val."' ".$sel.">".$desc."</option>\n";
                                }					
                                $str .= "</select>\n";
                                                        
                                echo $str;
                            ?>
                        </td> 
                        <td style="width:5%">	
                            <?php 
								$str = "<select id='beerId".$tap->get_id()."' name='beerId[]' class=''>\n";
								$str .= "<option value=''>Select One</option>\n";
								foreach($beerList as $item){
								    if( !$item ) continue;
								    $sel = "";
								    if( isset($tap) && $tap->get_beerId() == $item->get_id())  $sel .= "selected ";
								    $desc = $item->get_name();
								    $str .= "<option value='".$item->get_id()."~".$item->get_fg()."~".$item->get_fgUnit()."' ".$sel.">".$desc."</option>\n";
								}
								$str .= "</select>\n";
								
								echo $str;
								//echo $htmlHelper->ToSelectList("beerId[]", "beerId".$tap->get_id(), $beerList, "name", "id", $selectedBeer, "Select One"); 
							?>
                        </td>             
                        <td>
							<input type="text" id="startAmount<?php echo $tap->get_id();?>" class="smallbox" name="startAmount[]" value="<?php echo (isset($keg)?convert_volume($keg->get_startAmount(), $keg->get_startAmountUnit(), $config[ConfigNames::DisplayUnitVolume], TRUE):'') ?>" />
                        	<input type="hidden" id="startAmountOriginal<?php echo $tap->get_id();?>" class="smallbox" name="startAmountOriginal[]" value="<?php echo (isset($keg)?convert_volume($keg->get_startAmount(), $keg->get_startAmountUnit(), $config[ConfigNames::DisplayUnitVolume], TRUE):'-1') ?>" />
                        	<input type="hidden" id="startAmountUnit<?php echo $tap->get_id();?>" class="smallbox" name="startAmountUnit[]" value="<?php echo $config[ConfigNames::DisplayUnitVolume]; ?>" />
                    	</td>  
                    	<td>
							<input type="text" id="currentAmount<?php echo $tap->get_id();?>" class="smallbox" name="currentAmount[]" value="<?php echo (isset($keg)?convert_volume($keg->get_currentAmount(), $keg->get_currentAmountUnit(), $config[ConfigNames::DisplayUnitVolume], TRUE):'') ?>" onchange="updateCurrentWeight(<?php echo $tap->get_id();?>);"/>
                        	<input type="hidden" id="currentAmountOriginal<?php echo $tap->get_id();?>" class="smallbox" name="currentAmountOriginal[]" value="<?php echo (isset($keg)?convert_volume($keg->get_currentAmount(), $keg->get_currentAmountUnit(), $config[ConfigNames::DisplayUnitVolume], TRUE):'-1') ?>" />
                            <input type="hidden" id="currentAmountUnit<?php echo $tap->get_id();?>" class="smallbox" name="currentAmountUnit[]" value="<?php echo $config[ConfigNames::DisplayUnitVolume]; ?>" />
                        </td>
						<?php if($config[ConfigNames::UseKegWeightCalc]) { ?>  
                        <td>
							<input type="text" id="currentWeight<?php echo $tap->get_id();?>" class="smallbox" name="currentWeight[]" value="<?php echo (isset($keg)?convert_weight($keg->get_weight(), $keg->get_weightUnit(), $config[ConfigNames::DisplayUnitWeight]):'') ?>" onchange="updateCurrentAmount(<?php echo $tap->get_id();?>);"/>
							<input type="hidden" id="currentWeightOriginal<?php echo $tap->get_id();?>" class="smallbox" name="currentWeightOriginal[]" value="<?php echo (isset($keg)?convert_weight($keg->get_weight(), $keg->get_weightUnit(), $config[ConfigNames::DisplayUnitWeight]):'') ?>" />
                            <input type="hidden" id="currentWeightUnit<?php echo $tap->get_id();?>" class="smallbox" name="currentWeightUnit[]" value="<?php echo $config[ConfigNames::DisplayUnitWeight]; ?>" />
                        <?php if(!$config[ConfigNames::UseDefWeightSettings]) { ?> 
						</td>            
                        <td>
						<?php } ?>
						<?php 
						  $useKegPSI      = (!$config[ConfigNames::UseDefWeightSettings] && isset($keg) && $keg->get_fermentationPSI() && $keg->get_fermentationPSI() != ''); 
						  $keggingPSIUnit = $useKegPSI?$keg->get_fermentationPSIUnit():$config[ConfigNames::DefaultFermPSIUnit];
						  $keggingPSI     = convert_pressure($useKegPSI?$keg->get_fermentationPSI():$config[ConfigNames::DefaultFermPSI], $keggingPSIUnit, $config[ConfigNames::DisplayUnitPressure]);
						?>  
							<input type="<?php echo $config[ConfigNames::UseDefWeightSettings]?'hidden':'text';  ?>" id="fermentationPSI<?php echo $tap->get_id();?>" class="smallbox" name="fermentationPSI[]" value="<?php echo $keggingPSI;?>" onchange="updateCurrentAmount(<?php echo $tap->get_id();?>);"/>
							<input type="hidden" id="fermentationPSIOriginal<?php echo $tap->get_id();?>" class="smallbox" name="fermentationPSIOriginal[]" value="<?php echo $keggingPSI;?>"/>
							<input type="hidden" id="fermentationPSIUnit<?php echo $tap->get_id();?>" class="smallbox" name="fermentationPSIUnit[]" value="<?php echo $config[ConfigNames::DisplayUnitPressure]; ?>" />
                        	<input type="hidden" id="defaultFermentationPSI<?php echo $tap->get_id();?>" name="defaultFermentiationPSI[]" value="<?php echo (!isset($keg) || !$keg->get_fermentationPSI() || $keg->get_fermentationPSI() == '')?"1":"0"; ?>"/>
						<?php if(!$config[ConfigNames::UseDefWeightSettings]) { ?> 
						</td>            
                        <td>
						<?php } ?>  
						<?php 
						  $useKegKeggingTemp = (!$config[ConfigNames::UseDefWeightSettings] && isset($keg) && $keg->get_keggingTemp() && $keg->get_keggingTemp() != ''); 
						  $keggingTempUnit   = $useKegKeggingTemp?$keg->get_keggingTempUnit():$config[ConfigNames::DefaultKeggingTempUnit];
						  $keggingTemp       = convert_temperature($useKegKeggingTemp?$keg->get_keggingTemp():$config[ConfigNames::DefaultKeggingTemp], $keggingTempUnit, $config[ConfigNames::DisplayUnitTemperature]);						  
						?>  
							<input type="<?php echo $config[ConfigNames::UseDefWeightSettings]?'hidden':'text';  ?>" id="keggingTemp<?php echo $tap->get_id();?>" class="smallbox" name="keggingTemp[]" value="<?php echo $keggingTemp;?>" onchange="updateCurrentAmount(<?php echo $tap->get_id();?>);"/>
							<input type="hidden" id="keggingTempOriginal<?php echo $tap->get_id();?>" class="smallbox" name="keggingTempOriginal[]" value="<?php echo $keggingTemp;?>"/>
							<input type="hidden" id="keggingTempUnit<?php echo $tap->get_id();?>" class="smallbox" name="keggingTempUnit[]" value="<?php echo $config[ConfigNames::DisplayUnitTemperature]; ?>" />
                        	<input type="hidden" id="defaultKeggingTemp<?php echo $tap->get_id();?>" name="defaultKeggingTemp[]" value="<?php echo (!isset($keg) || !$keg->get_keggingTemp() || $keg->get_keggingTemp() == '')?"1":"0"; ?>"/>						
						</td>      
						<?php } ?>      
                        <?php if($config[ConfigNames::UseFlowMeter]) { ?>
                                <td <?php if($allTapsConfigured) echo 'style=display:none ' ?>>
                                    <?php if( isset($tap) ) { ?>
                                        <input type="text" id="flowpin<?php echo $tap->get_id();?>" class="smallbox" name="flowpin[]" value="<?php echo $tap->get_flowPinId(); ?>" />
                                    <?php } ?>
                                </td>
                                <td <?php if($allTapsConfigured) echo 'style=display:none ' ?>>
                                    <?php if( isset($tap) ) { ?>
                                        <input type="text" id="countpergallon<?php echo $tap->get_id();?>" class="smallbox" name="countpergallon[]" value="<?php echo convert_count($tap->get_count(), $tap->get_countUnit(), $config[ConfigNames::DisplayUnitVolume]); ?>" />
                                        <input type="hidden" id="countpergallonOriginal<?php echo $tap->get_id();?>" class="smallbox" name="countpergallonOriginal[]" value="<?php echo convert_count($tap->get_count(), $tap->get_countUnit(), $config[ConfigNames::DisplayUnitVolume]); ?>" />
                                	    <input type="hidden" id="countpergallonUnit<?php echo $tap->get_id();?>" class="smallbox" name="countpergallonUnit[]" value="<?php echo $config[ConfigNames::DisplayUnitVolume]; ?>" />
                                    <?php } ?>
                                </td>
                        <?php } ?>
                        <?php if($config[ConfigNames::UseTapValves]) { ?>
                            <td <?php if($allTapsConfigured) echo 'style=display:none ' ?>>
                                <?php if( isset($tap) ) { ?>
                                    <input type="text" id="valvepin<?php echo $tap->get_id();?>" class="smallbox" name="valvepin[]" value="<?php echo abs($tap->get_valvePinId()); ?>" />
                                <?php } ?>
                            </td>
                            <td <?php if($allTapsConfigured) echo 'style=display:none ' ?>>
                                <?php if( isset($tap) ) { ?>
                                	<input type="checkbox" id="valvepinPi<?php echo $tap->get_id();?>" class="xsmallbox" name="valvepinPi[<?php echo $tap->get_id();?>]" value="1" <?php if($tap->get_valvePinId() < 0)echo "checked"; ?>  />
                                <?php } ?>
                            </td>
                        <?php } ?>
          				<?php 
                            if($config[ConfigNames::UseTapValves]) {
                            ?>
                            <td>
                                <?php if( isset($tap) ) { ?>
                                    <button name="tapOverride[]" id="tapOverride<?php echo $tap->get_id();?>" type="button" class="btn" style="white-space:nowrap;" value="<?php echo $tap->get_valveOn(); ?>" onClick="changeTapState(this, <?php echo $tap->get_id()?>)"><?php echo ($tap->get_valveOn() < 1?TAP_TEXT_ENABLE:TAP_TEXT_DISABLE);?></button>
                                <?php } ?>
                            </td>
                        <?php } ?>
          				<?php 
          				if($config[ConfigNames::UseFlowMeter]) {
                            ?>
                            <td>
                                <?php if( isset($tap) ) { ?>
                                    <button name="calibrate[]" id="calibrate<?php echo $tap->get_id();?>" type="button" class="btn" style="white-space:nowrap;" value="1" onClick="calibrateTap(this, <?php echo $tap->get_id()?>)">Calibrate</button>
                                <?php } ?>
                            </td>
                        <?php } ?>
                        <?php if($config[ConfigNames::UsePlaato]) { ?>
                            <td>
                                <?php if( isset($tap) ) { ?>
                                    <input type="text" id="plaatoAuthToken<?php echo $tap->get_id();?>" class="mediumbox" name="plaatoAuthToken[]" value="<?php echo $tap->get_plaatoAuthToken(); ?>" />
                                <?php } ?>
                            </td>
                        <?php } ?>
<!--                        <td>
                            <input name="kickKeg" type="submit" class="btn" value="Kick Keg" />
                        </td>-->
                </tr>					
                <?php } ?>
            </tbody>
        </table>
            <input name="saveTapConfig" type="submit" class="btn" value="Save" />
            <input type="submit" name="revert"        class="btn" value="Revert" />
        </form>	
        <br />
        <div id="dialog"></div>
        <div>
            &nbsp; &nbsp; 
        </div>
    <?php } ?>
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
<?php if($config[ConfigNames::UseKegWeightCalc]) { ?> 
<?php 
    foreach($activeTaps as $tap){
        if(null == $tap)continue; 
        echo "updateCurrentWeight(".$tap->get_id().");\n";
    }
?>
	function updateCurrentWeight(tapId){
		var kegSelArr = document.getElementById("kegId"+tapId).value.split("~");
		var emptyKegWeight = 0;
		var emptyKegWeightUnit = '';
		if(kegSelArr.length > 4 && kegSelArr[3] != "")
		{
			emptyKegWeight = kegSelArr[3];
			if(kegSelArr.length > 5) emptyKegWeightUnit = kegSelArr[4];
		}
		var beerSelArr = document.getElementById("beerId"+tapId).value.split("~");
		var fg = 1.000;
		var fgUnit = 'sg';
		if(beerSelArr.length > 1 && beerSelArr[1] != "")
		{
			fg = beerSelArr[1];
			if(beerSelArr.length > 2)fgUnit = beerSelArr[2];
		}
		weight = getWeightByVol(document.getElementById("currentAmount"+tapId).value,  
																				document.getElementById("currentAmountUnit"+tapId).value,
																				emptyKegWeight, 
																				emptyKegWeightUnit,
																		     	document.getElementById("keggingTemp"+tapId).value, 
																		     	document.getElementById("keggingTempUnit"+tapId).value, 
																		     	<?php echo $config[ConfigNames::BreweryAltitude] ?>,
																		     	'<?php echo $config[ConfigNames::BreweryAltitudeUnit] ?>',
																		     	document.getElementById("fermentationPSI"+tapId).value, 
																		     	document.getElementById("fermentationPSIUnit"+tapId).value, 
																		     	fg, 
																		     	fgUnit,
																				'<?php echo $config[ConfigNames::DisplayUnitWeight]?>');
		if(!isNaN(weight))document.getElementById("currentWeight"+tapId).value = parseFloat(weight).toFixed(5);
	}
	function updateCurrentAmount(tapId){
		var kegSelArr = document.getElementById("kegId"+tapId).value.split("~");
		var emptyKegWeight = 0;
		var emptyKegWeightUnit = '';
		if(kegSelArr.length > 4 && kegSelArr[3] != "")
		{
			emptyKegWeight = kegSelArr[3];
			if(kegSelArr.length > 5) emptyKegWeightUnit = kegSelArr[4];
		}
		var beerSelArr = document.getElementById("beerId"+tapId).value.split("~");
		var fg = 1.000;
		var fgUnit = 'sg';
		if(beerSelArr.length > 1 && beerSelArr[1] != "")
		{
			fg = beerSelArr[1];
			if(beerSelArr.length > 2)fgUnit = beerSelArr[2];
		}
		var volume = getVolumeByWeight(document.getElementById("currentWeight"+tapId).value, 
																			    document.getElementById("currentWeightUnit"+tapId).value,
																				emptyKegWeight,
																				emptyKegWeightUnit,
																		     	document.getElementById("keggingTemp"+tapId).value, 
																		     	document.getElementById("keggingTempUnit"+tapId).value, 
																		     	<?php echo $config[ConfigNames::BreweryAltitude] ?>, 
																				'<?php echo $config[ConfigNames::BreweryAltitudeUnit] ?>', 
																		     	document.getElementById("fermentationPSI"+tapId).value, 
																		     	document.getElementById("fermentationPSIUnit"+tapId).value, 
																				fg, 
																				fgUnit,
																				'<?php echo $config[ConfigNames::DisplayUnitVolume]?>');
		if(!isNaN(volume))document.getElementById("currentAmount"+tapId).value = parseFloat(volume).toFixed(5);
	}
<?php } ?>
	function validateBeerSelected(kegSelectStart, beerSelectStart) {
		var ii = 1;
		var kegSelect = null;
		while( (kegSelect = document.getElementById(kegSelectStart+ii)) != null){
			if(kegSelect.selectedIndex != 0){
				if(document.getElementById(beerSelectStart+ii).selectedIndex == 0) {
					var msgDiv = document.getElementById("messageDiv");
					if(msgDiv != null)msgDiv.style.display = "";
					var msgSpan = document.getElementById("messageSpan");
					var kegSelArr = kegSelect.value.split("~");
					if(msgSpan != null) msgSpan.innerHTML = "Tap "+ii+" Keg "+kegSelArr[0]+" needs to have a beer associated to it or not associated to a tap"
					return false;
				}
			}	 
			ii++;
		}
	    return true; 
	 } 
	 
	$(function() {		
		$('#tap-form').validate({
		rules: {		
			<?php 
			$comma = "";
			foreach($activeTaps as $tap){ 
				if(null == $tap)continue; 
			?>
				<?php echo $comma; ?>tapId<?php echo $tap->get_id(); ?>: { required: true }
				<?php $comma = ","; ?>
				<?php echo $comma; ?>tapNumber<?php echo $tap->get_id(); ?>: { required: true, number: true, min: 1, integer: true }
				<?php echo $comma; ?>kegId<?php echo $tap->get_id(); ?>: { required: true }
				<?php echo $comma; ?>startAmount<?php echo $tap->get_id(); ?>: { required: true, number: true, min: 0 }
				<?php echo $comma; ?>currentAmount<?php echo $tap->get_id(); ?>: { required: true, number: true, min: 0 }
			<?php } ?> 
				//,tapId: { required: true }				
				//,kegId: { required: true, beerRequired: true }
				//,startAmount: { required: true, number: true }
				//,currentAmount: { required: true, number: true }
			}
		});		
	});
	function toggleSettings(callingAnchor, settingsDiv) {
		var div = document.getElementById(settingsDiv);
		if(div != null){
			if(div.style.display == ""){
				div.style.display = "none";
				callingAnchor.style.background = "url(img/bg_navigation.png) no-repeat top;";				
			}else{
				div.style.display = "";
				callingAnchor.style.background = "url(img/bg_navigation.png) 0 -76px;";				
			}
			if(document.getElementById("settingsExpanded")!= null)document.getElementById("settingsExpanded").value = div.style.display;
		}
	}
	
	function togglePinSettings(checkBox) {
		$("#flowPin").css("display", checkBox.checked?"visible":"none");
		$("#flowCount").css("display", checkBox.checked?"visible":"none");
		$("#valvepin").css("display", checkBox.checked?"visible":"none");
		$("#valvepinPi").css("display", checkBox.checked?"visible":"none");
		$("input[name='flowpin[]']").css("display", checkBox.checked?"visible":"none");
		$("input[name='flowpin[]']").parent().css("display", checkBox.checked?"visible":"none");
		$("input[name='countpergallon[]']").css("display", checkBox.checked?"visible":"none");
		$("input[name='countpergallon[]']").parent().css("display", checkBox.checked?"visible":"none");
		$("input[name='valvepin[]']").css("display", checkBox.checked?"visible":"none");
		$("input[name='valvepin[]']").parent().css("display", checkBox.checked?"visible":"none");
		$("input[name^='valvepinPi']").css("display", checkBox.checked?"visible":"none");
		$("input[name^='valvepinPi']").parent().css("display", checkBox.checked?"visible":"none");
	}
	
	function toggleDisplay(selectObject, kegSelectStart, secSelectBeerStart, tapId, tapNumber) {
		var msgDiv = document.getElementById("messageDiv");
		if(msgDiv != null) msgDiv.style.display = "none"
		var display = true;
		//Select array is kegid~beerid(in keg)~tapId(keg is on)~...
		var kegSelArr = selectObject.value.split("~");

		if( kegSelArr[0] == '' ){
			var beerSelect = document.getElementById(secSelectBeerStart+tapId);
			beerSelect.selectedIndex = 0;
			return;
		}
		
		//Check if the user selected this keg for any other tap
		var onOtherTap = null;
		var ii = 1;
		var secOtherTapKegSelect = null;
		while( (secOtherTapKegSelect = document.getElementById(kegSelectStart+ii++)) != null){
			if(ii-1 == tapId)continue;
			otherKegSelArr = secOtherTapKegSelect.value.split("~");
			if(otherKegSelArr[0] == kegSelArr[0]) onOtherTap = ii;
			if(onOtherTap)
			{
				while(3 > kegSelArr.length)kegSelArr.push(null);
				kegSelArr[2] = otherKegSelArr[2];
			 	break;
			}
		}
		if(onOtherTap){
			var secOtherTapBeerSelect = document.getElementById(secSelectBeerStart+onOtherTap);
			if(msgDiv != null)msgDiv.style.display = "";
			var msgSpan = document.getElementById("messageSpan");
			if(msgSpan != null) msgSpan.innerHTML = "Keg "+kegSelArr[0]+" currently on Tap "+kegSelArr[2]+" and will be moved to tap "+tapNumber+" and updated to current selected beer"
			if(secOtherTapBeerSelect != null)secOtherTapBeerSelect.selectedIndex = 0;
			if(secOtherTapKegSelect != null)secOtherTapKegSelect.selectedIndex = 0;		

			moveKegAttribute("startAmount", kegSelArr[2], tapId, "text");
			moveKegAttribute("startAmountOriginal", kegSelArr[2], tapId, "hidden");
			moveKegAttribute("startAmountUnit", kegSelArr[2], tapId, "hidden");
			moveKegAttribute("currentAmount", kegSelArr[2], tapId, "text");
			moveKegAttribute("currentAmountOriginal", kegSelArr[2], tapId, "hidden");
			moveKegAttribute("currentAmountUnit", kegSelArr[2], tapId, "hidden");
			moveKegAttribute("currentWeight", kegSelArr[2], tapId, "text");
			moveKegAttribute("currentWeightOriginal", kegSelArr[2], tapId, "hidden");
			moveKegAttribute("currentWeightUnit", kegSelArr[2], tapId, "hidden");
			moveKegAttribute("fermentationPSI", kegSelArr[2], tapId, "text");
			moveKegAttribute("fermentationPSIOriginal", kegSelArr[2], tapId, "hidden");
			moveKegAttribute("fermentationPSIUnit", kegSelArr[2], tapId, "hidden");
			moveKegAttribute("keggingTemp", kegSelArr[2], tapId, "text");
			moveKegAttribute("keggingTempOriginal", kegSelArr[2], tapId, "hidden");
			moveKegAttribute("keggingTempUnit", kegSelArr[2], tapId, "hidden");
		}else{
			var ii = 7; // Use this incase the start value changes. Note the original is the same so dont increment until after original
			$("#startAmount"+tapId).val(kegSelArr[ii]); 
			$("#startAmountOriginal"+tapId).val(kegSelArr[ii]);
			$("#startAmountUnit"+tapId).val(kegSelArr[++ii]); 
			$("#currentAmount"+tapId).val(kegSelArr[++ii]);
			$("#currentAmountOriginal"+tapId).val(kegSelArr[ii]);
			$("#currentAmountUnit"+tapId).val(kegSelArr[++ii]);
			if($("#fermentationPSI"+tapId+"[type='text']").length > 0)$("#fermentationPSI"+tapId).val(kegSelArr[++ii]); 
			if($("#fermentationPSIOriginal"+tapId+"[type='hidden']").length > 0)$("#fermentationPSI"+tapId).val(kegSelArr[ii]);
			if($("#fermentationPSIUnit"+tapId+"[type='hidden']").length > 0)$("#fermentationPSIUnit"+tapId).val(kegSelArr[++ii]); 
			if($("#keggingTemp"+tapId+"[type='text']").length > 0)$("#keggingTemp"+tapId).val(kegSelArr[++ii]); 
			if($("#keggingTempOriginal"+tapId+"[type='hidden']").length > 0)$("#keggingTemp"+tapId).val(kegSelArr[ii]);
			if($("#keggingTempUnit"+tapId+"[type='hidden']").length > 0)$("#keggingTempUnit"+tapId).val(kegSelArr[++ii]); 
			updateCurrentWeight(tapId)
		}	

		var beerSelect = document.getElementById(secSelectBeerStart+tapId);
		var beerSelectOptions = beerSelect.options;
		var beerId = (kegSelArr.length > 1 && kegSelArr[1] != "")?kegSelArr[1]:null;
		var i = 0;
		if(beerId != null){
			var beerSelectOptions = beerSelect.options;
			for (i = 0; i < beerSelectOptions.length; i++) 
			{
				if (beerSelectOptions[i].value.split("~")[0] == beerId) {
					beerSelect.selectedIndex = i;
					break;
				}
			}
		}
		//If no beerId or beerId not found in the select
		if(beerId == null || i >= beerSelectOptions.length){
			beerSelect.selectedIndex = 0;
		}
	}

	function moveKegAttribute(attribute, fromTapId, toTapId, inputType=''){
		//Only modify the correct type
		if(inputType != '' && $("#"+attribute+toTapId+"[type='"+inputType+"']").length == 0) return;
		$("#"+attribute+toTapId).val($("#"+attribute+fromTapId).val());
		$("#"+attribute+fromTapId).val("");
	}

	function changeTapState(btn, tapId){
		var data
		if(btn.value < 1){
			data = { "enableTap" : tapId }
		}else{
			data = { "disableTap" : tapId }
		}
		$.ajax(
            {
                   type: "POST",
                   url: "tap_list.php",
                   data: data,// data to send to above script page if any
                   cache: false,
    
                   success: function(response)
                   {
                    btn.value = ((parseInt(btn.value) + 1)%2);
                    btn.innerHTML = btn.value < 1?"<?php echo TAP_TEXT_ENABLE;?>":"<?php echo TAP_TEXT_DISABLE;?>";
                   }
             });
  	}

	function calibrateTap(btn, tapId){
	    var form = document.createElement("form");
	    var element2 = document.createElement("input"); 
	    form.method = "POST";
	    form.action = "calibrate_tap.php";   
	    element2.value=tapId;
	    element2.name="tapId";
	    form.appendChild(element2);  
	    document.body.appendChild(form);

	    form.submit();
  	}
  	
	$("input[name='countpergallon[]']").change(inputChanged);
    function inputChanged(){
        var changeInput = this.id + "changed"
    	$("input[id='"+changeInput+"']").val(1)
    }
</script>
	<!-- End Js -->

</body>

</html>