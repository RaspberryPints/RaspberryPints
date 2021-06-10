<?php
require_once __DIR__.'/header.php';
require_once 'includes/managers/fermenter_manager.php';

$htmlHelper = new HtmlHelper();
$fermenterManager = new FermenterManager();
$fermenterStatusManager = new FermenterStatusManager();
$fermenterTypeManager = new FermenterTypeManager();
$beerManager = new BeerManager();

$config = getAllConfigs();
//Change the beerId value from beerId~beerBatchId~fg to just beerId
if(isset($_POST['beerId'])){
    $beerExloded = explode("~", $_POST['beerId']);
    $_POST['beerId'] = $beerExloded[0];
    $_POST['beerBatchId'] = $beerExloded[1];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['save']) ) {
    
    $fermenterOld = $fermenterManager->GetByID($_POST['id']);
    $fermenter = new Fermenter();
    $fermenter->setFromArray($_POST);
    if(!$fermenterOld || $fermenter->get_beerId() != $fermenterOld->get_beerId() ||
        $fermenter->get_beerBatchId() != $fermenterOld->get_BatchId()){
            $fermenter->set_startDate(date('Y-m-d H:i:s'));
    }
    if($fermenterManager->Save($fermenter)){
        unset($_POST);
        redirect('fermenter_list.php');
    }
}

$fermenter = null;
if( isset($_GET['id'])){
    $fermenter = $fermenterManager->GetById($_GET['id']);
}else if( isset($_POST['id'])){
    $fermenter = $fermenterManager->GetById($_POST['id']);
}

if($fermenter == null){
    $fermenter = new Fermenter();
    $fermenter->setFromArray($_POST);
}

$fermenterStatusList = $fermenterStatusManager->GetAll();
$fermenterTypeList = $fermenterTypeManager->GetAll();
$beerList = $beerManager->GetAllActiveWithBatches();

// if( isset($_GET['beerId'])){
//     $beer = $beerManager->GetById($_GET['beerId']);
// }else{
//     $beer = new Beer();
// }
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
			<li><a href="fermenter_list.php">Fermenter List</a></li>
			<li>/</li>
			<li class="current">Fermenter Form</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End --> 
	
	<!-- Right Side/Main Content Start -->
	<div id="rightside">
		<div class="contentcontainer med left">
	<p>
		fields marked with an * are required
		<?php $htmlHelper->ShowMessage(); ?>

	<form id="fermenter-form" method="POST">
		<input type="hidden" name="id" value="<?php echo $fermenter->get_id() ?>" />
		<input type="hidden" name="active" value="1" />

		<table style="width:950;border:0;cellspacing:1;cellpadding:0;">
			<tr>
				<td>
					Label: <b><font color="red">*</font></b>
				</td>
				<td>
					<input type="text" id="label" class="mediumbox" name="label" value="<?php echo $fermenter->get_label() ?>" />
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
						    if( isset($fermenter) && $fermenter->get_beerId() == ($item->get_beerBatchId()<=0?$item->get_id():$item->get_beerId()) && (($fermenter->get_beerBatchId() <= 0 && $item->get_beerBatchId()<=0) || $fermenter->get_beerBatchId() == $item->get_beerBatchId()) )  $sel .= "selected ";
						    $desc = $item->get_displayName();
						    $str .= "<option value='".($item->get_beerBatchId()<=0?$item->get_id():$item->get_beerId())."~".$item->get_beerBatchId()."~".$item->get_fg()."~".$item->get_fgUnit()."' ".$sel.">".$desc."</option>\n";
						}
						$str .= "</select>\n";
						
						echo $str;
						// echo $htmlHelper->ToSelectList("beerId", "beerId", $beerList, "name", "id", $fermenter->get_beerId(), ($fermenter->get_onTapId()?null:"Select One")); 
					?>
				</td>
			</tr>
			<tr>
				<td>
					Status: <b><font color="red">*</font></b>
				</td>
				<td>
					<?php echo $htmlHelper->ToSelectList("fermenterStatusCode", "fermenterStatusCode", $fermenterStatusList, "name", "code", $fermenter->get_fermenterStatusCode(), "Select One"); ?>
				</td>
			</tr>
			<tr>
				<td>
					Type: <b><font color="red">*</font></b>
				</td>
				<td>
					<?php echo $htmlHelper->ToSelectList("fermenterTypeId", "fermenterTypeId", $fermenterTypeList, "name", "id", $fermenter->get_fermenterTypeId(), "Select One"); ?>
				</td>
			</tr>	
			<tr>
				<td>
					Make: 
				</td>
				<td>
					<input type="text" id="make" class="mediumbox" name="make" value="<?php echo $fermenter->get_make() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Model: 
				</td>
				<td>
					<input type="text" id="model" class="mediumbox" name="model" value="<?php echo $fermenter->get_model() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Serial: 
				</td>
				<td>
					<input type="text" id="serial" class="mediumbox" name="serial" value="<?php echo $fermenter->get_serial() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Current Weight(<?php echo $config[ConfigNames::DisplayUnitWeight]; ?>):<br>(not &lt; Empty Weight)
				</td>
				<td>
					<input type="text" id="weight" class="mediumbox" name="weight" value="<?php echo convert_weight($fermenter->get_weight(), $fermenter->get_weightUnit(), $config[ConfigNames::DisplayUnitWeight]); ?>" onchange="updateCurrentAmount()"/>
					<input type="hidden" id="weightUnit" name="weightUnit" value="<?php echo $config[ConfigNames::DisplayUnitWeight]; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Empty Weight(<?php echo $config[ConfigNames::DisplayUnitWeight]; ?>): 
				</td>
				<td>
					<input type="text" id="emptyWeight" class="mediumbox" name="emptyWeight" value="<?php echo convert_weight($fermenter->get_emptyWeight(), $fermenter->get_emptyWeightUnit(), $config[ConfigNames::DisplayUnitWeight]); ?>" />
					<input type="hidden" id="emptyWeightUnit" name="emptyWeightUnit" value="<?php echo $config[ConfigNames::DisplayUnitWeight]; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Max Volume (<?php echo (is_unit_imperial($config[ConfigNames::DisplayUnitVolume])?"Gal":"L"); ?>): 
				</td>
				<td>
					<input type="text" id="maxVolume" class="mediumbox" name="maxVolume" value="<?php echo convert_Volume($fermenter->get_maxVolume(), $fermenter->get_maxVolumeUnit(), $config[ConfigNames::DisplayUnitVolume], TRUE); ?>" />
					<input type="hidden" id="maxVolumeUnit" name="maxVolumeUnit" value="<?php echo $config[ConfigNames::DisplayUnitVolume]; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Start Amount (<?php echo (is_unit_imperial($config[ConfigNames::DisplayUnitVolume])?"Gal":"L"); ?>): 
				</td>
				<td>
					<input type="text" id="startAmount" class="mediumbox" name="startAmount" value="<?php echo convert_Volume($fermenter->get_startAmount(), $fermenter->get_startAmountUnit(), $config[ConfigNames::DisplayUnitVolume], TRUE); ?>" />
					<input type="hidden" id="startAmountUnit" name="startAmountUnit" value="<?php echo $config[ConfigNames::DisplayUnitVolume]; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Current Amount (<?php echo (is_unit_imperial($config[ConfigNames::DisplayUnitVolume])?"Gal":"L"); ?>): 
				</td>
				<td>
					<input type="text" id="currentAmount" class="mediumbox" name="currentAmount" value="<?php echo convert_Volume($fermenter->get_currentAmount(), $fermenter->get_currentAmountUnit(), $config[ConfigNames::DisplayUnitVolume], TRUE) ?>" onchange="updateCurrentWeight()" />
        			<input type="hidden" id="currentAmountUnit" name="currentAmountUnit" value="<?php echo $config[ConfigNames::DisplayUnitVolume]; ?>" />
					<?php if($config[ConfigNames::UseDefWeightSettings]){?>
            			<input type="hidden" id="fermentationPSI" class="mediumbox" name="fermentationPSI" value="<?php echo convert_pressure($config[ConfigNames::DefaultFermPSI], $config[ConfigNames::DefaultFermPSIUnit], $config[ConfigNames::DisplayUnitPressure]); ?>" />
        				<input type="hidden" id="fermentationPSIUnit" name="fermentationPSIUnit" value="<?php echo $config[ConfigNames::DisplayUnitPressure]; ?>" />
						<input type="hidden" id="KeggingTemp" class="mediumbox" name="KeggingTemp" value="<?php echo convert_temperature($config[ConfigNames::DefaultKeggingTemp], $config[ConfigNames::DefaultKeggingTempUnit], $config[ConfigNames::DisplayUnitTemperature]); ?>" />
						<input type="hidden" id="KeggingTempUnit" name="KeggingTempUnit" value="<?php echo $config[ConfigNames::DisplayUnitTemperature]; ?>" />
    				<?php } ?>
				</td>
			</tr>
			<?php if(!$config[ConfigNames::UseDefWeightSettings]){?>
    			<tr>
    				<td>
    					Fermentation<br/>Pressure(<?php echo $config[ConfigNames::DisplayUnitPressure]?>): 
    				</td>
    				<td>
    					<input type="text" id="fermentationPSI" class="mediumbox" name="fermentationPSI" value="<?php echo convert_pressure($fermenter->get_fermentationPSI(), $fermenter->get_fermentationPSIUnit(), $config[ConfigNames::DisplayUnitPressure]); ?>" onchange="updateCurrentAmount()" />
        				<input type="hidden" id="fermentationPSIUnit" name="fermentationPSIUnit" value="<?php echo $config[ConfigNames::DisplayUnitPressure]; ?>" />
    				</td>
    			</tr>
			<?php } ?>
			<tr>
				<td>
					Notes: 
				</td>
				<td>
					<textarea id="notes" class="text-input textarea" name="notes" style="width:500px;height:100px"><?php echo $fermenter->get_notes() ?></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input name="save" type="submit" class="btn" value="Save" />
					<input type="button" class="btn" value="Cancel" onclick="window.location='fermenter_list.php'" />
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
require_once 'scripts.php';
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
																		     	document.getElementById("KeggingTemp").value, 
																		     	document.getElementById("KeggingTempUnit").value, 
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
																		     	document.getElementById("KeggingTemp").value, 
																		     	document.getElementById("KeggingTempUnit").value, 
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
		
		$('#fermenter-form').validate({
			rules: {
				label: { required: true },
				fermenterTypeId: { required: true },
				fermenterStatusCode: { required: true },
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
