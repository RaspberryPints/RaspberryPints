<?php
require_once __DIR__.'/header.php';

$htmlHelper = new HtmlHelper();
$kegManager = new KegManager();
$kegStatusManager = new KegStatusManager();
$kegTypeManager = new KegTypeManager();
$beerManager = new BeerManager();
$tapManager = new TapManager();

$config = getAllConfigs();
//Change the beerId value from beerId~fg to just beerId
if(isset($_POST['beerId'])){
    $_POST['beerId'] = explode('~', $_POST['beerId'])[0];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['save']) ) {
    $keg = new Keg();
    $keg->setFromArray($_POST);
    if( isset($_POST['kickKeg'])){
        $tapManager->closeTapById($keg->get_onTapId());
    }
    if($kegManager->Save($keg)){
        unset($_POST);
        redirect('keg_list.php');
    }
}

$keg = null;
if( isset($_GET['id'])){
    $keg = $kegManager->GetById($_GET['id']);
}else if( isset($_POST['id'])){
    $keg = $kegManager->GetById($_POST['id']);
}

if($keg == null){
    $keg = new Keg();
    $keg->setFromArray($_POST);
}

$kegStatusList = $kegStatusManager->GetAll();
$kegTypeList = $kegTypeManager->GetAll();
$beerList = $beerManager->GetAllActive();

if( isset($_GET['beerId'])){
    $beer = $beerManager->GetById($_GET['beerId']);
}else{
    $beer = new Beer();
}
?>
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
			<li><a href="keg_list.php">Keg List</a></li>
			<li>/</li>
			<li class="current">Keg Form</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End --> 
	
	<!-- Right Side/Main Content Start -->
	<div id="rightside">
		<div class="contentcontainer med left">
	<p>
		fields marked with an * are required
		<?php $htmlHelper->ShowMessage(); ?>

	<form id="keg-form" method="POST">
		<input type="hidden" name="id" value="<?php echo $keg->get_id() ?>" />
		<input type="hidden" name="active" value="1" />

		<table style="width:950;border:0;cellspacing:1;cellpadding:0;">
			<tr>
				<td>
					Label: <b><font color="red">*</font></b>
				</td>
				<td>
					<input type="text" id="label" class="mediumbox" name="label" value="<?php echo $keg->get_label() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Beer Name:
				</td>
				<td>
					<?php 
						$str = "<select id='beerId' name='beerId' class=''>\n";
						$str .= "<option value=''>Select One</option>\n";
						foreach($beerList as $item){
						    if( !$item ) continue;
						    $sel = "";
						    if( isset($keg) && $keg->get_beerId() == $item->get_id())  $sel .= "selected ";
						    $desc = $item->get_name();
						    $str .= "<option value='".$item->get_id()."~".$item->get_fg()."~".$item->get_fgUnit()."' ".$sel.">".$desc."</option>\n";
						}
						$str .= "</select>\n";
						
						echo $str;
						// echo $htmlHelper->ToSelectList("beerId", "beerId", $beerList, "name", "id", $keg->get_beerId(), ($keg->get_onTapId()?null:"Select One")); 
					?>
				</td>
			</tr>
            <?php if($keg->get_onTapId()) { ?>
			<tr>
				<td>
                	<?php 
						$tap = $tapManager->GetByID($keg->get_onTapId());
						if($tap){
							echo "On Tap ".$tap->get_tapNumber().":";
		                    echo '<input type="hidden" name="onTapId" value="'.$tap->get_id().'" />';
		                    echo '<input type="hidden" name="tapNumber" value="'.$tap->get_tapNumber().'" />';
						}
					?>
				</td>
				<td>
					<input name="kickKeg" type="submit" class="btn" value="Kick Keg" />
				</td>
			</tr>
            <?php } ?>
			<tr>
				<td>
					Status: <b><font color="red">*</font></b>
				</td>
				<td>
					<?php echo $htmlHelper->ToSelectList("kegStatusCode", "kegStatusCode", $kegStatusList, "name", "code", $keg->get_kegStatusCode(), "Select One"); ?>
				</td>
			</tr>
			<tr>
				<td>
					Type: <b><font color="red">*</font></b>
				</td>
				<td>
					<?php echo $htmlHelper->ToSelectList("kegTypeId", "kegTypeId", $kegTypeList, "name", "id", $keg->get_kegTypeId(), "Select One"); ?>
				</td>
			</tr>	
			<tr>
				<td>
					Make: 
				</td>
				<td>
					<input type="text" id="make" class="mediumbox" name="make" value="<?php echo $keg->get_make() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Model: 
				</td>
				<td>
					<input type="text" id="model" class="mediumbox" name="model" value="<?php echo $keg->get_model() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Serial: 
				</td>
				<td>
					<input type="text" id="serial" class="mediumbox" name="serial" value="<?php echo $keg->get_serial() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Stamped Owner: 
				</td>
				<td>
					<input type="text" id="stampedOwner" class="mediumbox" name="stampedOwner" value="<?php echo $keg->get_stampedOwner() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Stamped Location: 
				</td>
				<td>
					<input type="text" id="stampedLoc" class="mediumbox" name="stampedLoc" value="<?php echo $keg->get_stampedLoc() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Current Weight(<?php echo $config[ConfigNames::DisplayUnitWeight]; ?>):<br>(not &lt; Empty Weight)
				</td>
				<td>
					<input type="text" id="weight" class="mediumbox" name="weight" value="<?php echo convert_weight($keg->get_weight(), $keg->get_weightUnit(), $config[ConfigNames::DisplayUnitWeight]); ?>" onchange="updateCurrentAmount()"/>
					<input type="hidden" id="weightUnit" name="weightUnit" value="<?php echo $config[ConfigNames::DisplayUnitWeight]; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Empty Weight(<?php echo $config[ConfigNames::DisplayUnitWeight]; ?>): 
				</td>
				<td>
					<input type="text" id="emptyWeight" class="mediumbox" name="emptyWeight" value="<?php echo convert_weight($keg->get_emptyWeight(), $keg->get_emptyWeightUnit(), $config[ConfigNames::DisplayUnitWeight]); ?>" />
					<input type="hidden" id="emptyWeightUnit" name="emptyWeightUnit" value="<?php echo $config[ConfigNames::DisplayUnitWeight]; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					
					<div class="tooltip">Continuous Lid:<span class="tooltiptext">Keg will always be full<br/>if start amount in keg is 0 then <br/>remaining is hidden on list</span></div>
				</td>
				<td>
					<input type="checkbox" id="hasContinuousLid" name="hasContinuousLid" value="1" <?php echo $keg->get_hasContinuousLid()?'checked':''; ?> />
				</td>
			</tr>
			<tr>
				<td>
					Max Volume (<?php echo (is_unit_imperial($config[ConfigNames::DisplayUnitVolume])?"Gal":"L"); ?>): 
				</td>
				<td>
					<input type="text" id="maxVolume" class="mediumbox" name="maxVolume" value="<?php echo convert_Volume($keg->get_maxVolume(), $keg->get_maxVolumeUnit(), $config[ConfigNames::DisplayUnitVolume], TRUE); ?>" />
					<input type="hidden" id="maxVolumeUnit" name="maxVolumeUnit" value="<?php echo $config[ConfigNames::DisplayUnitVolume]; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Start Amount (<?php echo (is_unit_imperial($config[ConfigNames::DisplayUnitVolume])?"Gal":"L"); ?>): 
				</td>
				<td>
					<input type="text" id="startAmount" class="mediumbox" name="startAmount" value="<?php echo convert_Volume($keg->get_startAmount(), $keg->get_startAmountUnit(), $config[ConfigNames::DisplayUnitVolume], TRUE); ?>" />
					<input type="hidden" id="startAmountUnit" name="startAmountUnit" value="<?php echo $config[ConfigNames::DisplayUnitVolume]; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Current Amount (<?php echo (is_unit_imperial($config[ConfigNames::DisplayUnitVolume])?"Gal":"L"); ?>): 
				</td>
				<td>
					<input type="text" id="currentAmount" class="mediumbox" name="currentAmount" value="<?php echo convert_Volume($keg->get_currentAmount(), $keg->get_currentAmountUnit(), $config[ConfigNames::DisplayUnitVolume], TRUE) ?>" onchange="updateCurrentWeight()" />
        			<input type="hidden" id="currentAmountUnit" name="currentAmountUnit" value="<?php echo $config[ConfigNames::DisplayUnitVolume]; ?>" />
					<?php if($config[ConfigNames::UseDefWeightSettings]){?>
            			<input type="hidden" id="fermentationPSI" class="mediumbox" name="fermentationPSI" value="<?php echo convert_pressure($config[ConfigNames::DefaultFermPSI], $config[ConfigNames::DefaultFermPSIUnit], $config[ConfigNames::DisplayUnitPressure]); ?>" />
        				<input type="hidden" id="fermentationPSIUnit" name="fermentationPSIUnit" value="<?php echo $config[ConfigNames::DisplayUnitPressure]; ?>" />
						<input type="hidden" id="keggingTemp" class="mediumbox" name="keggingTemp" value="<?php echo convert_temperature($config[ConfigNames::DefaultKeggingTemp], $config[ConfigNames::DefaultKeggingTempUnit], $config[ConfigNames::DisplayUnitTemperature]); ?>" />
						<input type="hidden" id="keggingTempUnit" name="keggingTempUnit" value="<?php echo $config[ConfigNames::DisplayUnitTemperature]; ?>" />
    				<?php } ?>
				</td>
			</tr>
			<?php if(!$config[ConfigNames::UseDefWeightSettings]){?>
    			<tr>
    				<td>
    					Fermentation<br/>Pressure(<?php echo $config[ConfigNames::DisplayUnitPressure]?>): 
    				</td>
    				<td>
    					<input type="text" id="fermentationPSI" class="mediumbox" name="fermentationPSI" value="<?php echo convert_pressure($keg->get_fermentationPSI(), $keg->get_fermentationPSIUnit(), $config[ConfigNames::DisplayUnitPressure]); ?>" onchange="updateCurrentAmount()" />
        				<input type="hidden" id="fermentationPSIUnit" name="fermentationPSIUnit" value="<?php echo $config[ConfigNames::DisplayUnitPressure]; ?>" />
    				</td>
    			</tr>
    			<tr>
    				<td>
    					Kegging<br/>Temperature(<?php echo $config[ConfigNames::DisplayUnitTemperature]?>): 
    				</td>
    				<td>
    					<input type="text" id="keggingTemp" class="mediumbox" name="keggingTemp" value="<?php echo convert_temperature($keg->get_keggingTemp(), $keg->get_keggingTempUnit(), $config[ConfigNames::DisplayUnitTemperature]); ?>" onchange="updateCurrentAmount()" />
        				<input type="hidden" id="keggingTempUnit" name="keggingTempUnit" value="<?php echo $config[ConfigNames::DisplayUnitTemperature]; ?>" />
    				</td>
    			</tr>
			<?php } ?>
			<tr>
				<td>
					Notes: 
				</td>
				<td>
					<textarea id="notes" class="text-input textarea" name="notes" style="width:500px;height:100px"><?php echo $keg->get_notes() ?></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input name="save" type="submit" class="btn" value="Save" />
					<input type="button" class="btn" value="Cancel" onclick="window.location='keg_list.php'" />
				</td>
			</tr>								
		</table>
		<br />
		<div align="right">			
			&nbsp; &nbsp; 
		</div>

	</form>
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
    updateCurrentWeight();
	function updateCurrentWeight(){
		var beerSelArr = document.getElementById("beerId").value.split("~");
		var fg = 1.000;
		var fgUnit = 'sg';
		if(beerSelArr.length > 1 && beerSelArr[1] != "")
		{
			fg = beerSelArr[1];
			fgUnit = beerSelArr[2];
		}
		weight = getWeightByVol(document.getElementById("currentAmount").value,  
																				document.getElementById("currentAmountUnit").value,
																				document.getElementById("emptyWeight").value, 
																				document.getElementById("emptyWeightUnit").value,
																		     	document.getElementById("keggingTemp").value, 
																		     	document.getElementById("keggingTempUnit").value, 
																		     	<?php echo $config[ConfigNames::BreweryAltitude] ?>,
																		     	'<?php echo $config[ConfigNames::BreweryAltitudeUnit] ?>',
																		     	document.getElementById("fermentationPSI").value, 
																		     	document.getElementById("fermentationPSIUnit").value, 
																		     	fg, 
																		     	fgUnit,
																				'<?php echo $config[ConfigNames::DisplayUnitWeight]?>');
		if(!isNaN(weight))document.getElementById("weight").value = parseFloat(weight).toFixed(5);
	}
	function updateCurrentAmount(){
		var beerSelArr = document.getElementById("beerId").value.split("~");
		var fg = 1.000;
		var fgUnit = 'sg';
		if(beerSelArr.length > 1 && beerSelArr[1] != "")
		{
			fg = beerSelArr[1];
			fgUnit = beerSelArr[2];
		}
		var volume = getVolumeByWeight(document.getElementById("weight").value, 
																				document.getElementById("weightUnit").value, 
																				document.getElementById("emptyWeight").value,
																				document.getElementById("emptyWeightUnit").value,
																		     	document.getElementById("keggingTemp").value, 
																		     	document.getElementById("keggingTempUnit").value, 
																		     	<?php echo $config[ConfigNames::BreweryAltitude] ?>, 
																		     	'<?php echo $config[ConfigNames::BreweryAltitudeUnit] ?>', 
																		     	document.getElementById("fermentationPSI").value, 
																		     	document.getElementById("fermentationPSIUnit").value, 
																				fg,
																				fgUnit,
																				'<?php echo $config[ConfigNames::DisplayUnitVolume]?>');
		if(!isNaN(volume))document.getElementById("currentAmount").value = parseFloat(volume).toFixed(5);
	}

	$(function() {		
		
		$('#keg-form').validate({
			rules: {
				label: { required: true },
				kegTypeId: { required: true },
				kegStatusCode: { required: true },
				beerId: { required: false },
				make: { required: false },
				model: { required: false },
				serial: { required: false },
				stampedOwner: { required: false },
				stampedLoc: { required: false },
				weight: { required: false },
				notes: { required: false }
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
