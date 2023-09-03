<?php
require_once __DIR__.'/header.php';
require_once __DIR__.'/includes/managers/pour_manager.php';
require_once __DIR__.'/../includes/functions.php';
$htmlHelper = new HtmlHelper();
$config = getAllConfigs();
$tapManager = new TapManager();    
$pourManager = new PourManager();
$tap = $tapManager->GetByID($_POST['tapId']);
$activeTaps = array();
$lastPour = NULL;
if (isset ( $_POST ['saveTapCalibration'] ) ){
    $pourAmount = $_POST ['displayAmount'];
    $countpergallonUnit = $_POST ['displayAmountUnit'];
    $originalPulses = $_POST ['originalPulses'];
    $countpergallon = (is_unit_imperial($countpergallonUnit)?128:1000)*($originalPulses/$pourAmount);
    $dbUnit = is_unit_imperial($countpergallonUnit)?UnitsOfMeasure::VolumeGallon:UnitsOfMeasure::VolumeLiter;
    //In local UOM convert to gallon to match database
    $pourAmount = convert_volume($pourAmount, $countpergallonUnit, $dbUnit);
    
    $tapManager->saveTapConfig ( $tap->get_id(), $tap->get_flowPinId(), $tap->get_valvePinId(), $tap->get_valveOn(), $countpergallon, $countpergallonUnit, $tap->get_plaatoAuthToken() );
    $pourManager->updatePour($_POST ['lastPourId'], $pourAmount, $dbUnit, $countpergallon);
}
if (isset ( $_POST ['saveTapCalibration'] ) ||
    isset ( $_POST [ 'revert'] ) ) {
        if(!isset($_POST['redirect']) || $_POST['redirect'] != ''){
            $_POST['redirect'] = "tap_list.php";
        }
        require_once __DIR__.'/includes/functions.php';
        redirect($_POST['redirect']);
}
if( NULL !== $tap)
{
    $totalRows = 0;
    $lastPours = $pourManager->getLastPoursFiltered(0, 1, $totalRows, NULL, NULL, $tap->get_id(), NULL, NULL);
    if($lastPours !== NULL && count($lastPours) > 0) $lastPour = array_values($lastPours)[0];
    array_push($activeTaps, $tap);
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
    		<li class="current">Calibrate Tap</li>            
    	</ul>
    </div>
    <!-- Top Breadcrumb End --> 
    <!-- Right Side/Main Content Start -->
    <div id="rightside">
    	<div class="contentcontainer med left" >
    	<?php $htmlHelper->ShowMessage(); ?>
    	
    <!-- Start On Tap Section -->
        <form method="POST" id="tap-form">        
                <?php foreach($activeTaps as $tap){ 
                    if(null == $tap)continue; 
    			?>
                	<input type="hidden" name="tapId[]" value="<?php echo $tap->get_id(); ?>" />
                <?php } ?> 
    		<div id="messageDiv" class="error status" style="display:none;"><span id="messageSpan"></span></div>
    		<div id="instructionDiv" ><span id="messageSpan">Enter the correct value for the last pour volume, <?php echo $config[ConfigNames::DisplayUnitVolume]?> per pulse will automatic update. <br/>Hit save to update last pour amount and set pulses per <?php echo is_unit_imperial($config[ConfigNames::DisplayUnitVolume])?"Gallon":"Liter"?> on the tap</span></div>
    		<table class="contentbox" style="width:75%; border:0;" >
            <thead>
                <tr>
                    <th>Tap<br>Description</th>
                    <th>Last Pour<br>Volume(<?php echo $config[ConfigNames::DisplayUnitVolume]?>)</th>
                    <th>Last Pour<br><?php echo $config[ConfigNames::DisplayUnitVolume]?>/Pulse</th>
                    <th>Last Pour<br>Pulse/<?php echo $config[ConfigNames::DisplayUnitVolume]?></th>
                    <th>Tap<br>Pulses/<?php echo ucfirst(is_unit_imperial($config[ConfigNames::DisplayUnitVolume])?UnitsOfMeasure::VolumeGallon:UnitsOfMeasure::VolumeLiter); ?></th>
                    <th>Last Pour<br>Pulses</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($activeTaps as $tap){ ?>
                    <?php if(null == $tap)continue; ?> 
                    <tr>
                        <td>
                            <?php 
                            if(isset($tap) ) { 
                            ?>
                            <div style="width:115px">
                               <?php 
                                    $style = "";
                                   // $hasImg = false;
                                    if(isset($tap) && null !== $tap->get_tapRgba()) $style = "background-color: ".$htmlHelper->CreateRGB($tap->get_tapRgba());
                                    if(isset($tap))
        							{
        							    $imgs = glob ( '../img/tap/tap'.$tap->get_id().'.*' );
            							if(count($imgs) > 0)
            							{
            							    $style .= ($style != ""?";":"").'background:url('.$imgs[0].') no-repeat bottom left; background-size:cover; -webkit-border-radius:0px; -mox-border-radius:0px; height:100%; width:50px';
            							   // $hasImg = true;
            							}
        							}
    							?> 
    							<input type="text" readonly="readonly" id="tapNumber<?php echo $tap->get_id();?>" class="smallbox" name="tapNumber[]" value="<?php echo $tap->get_tapNumber(); ?>" <?php echo $style != ""?'style="'.$style.'"':""; ?> />
                            	<input type="hidden" id="tapId" name="tapId" value="<?php echo $tap->get_id(); ?>" />
                            </div>
                            <?php } ?>
                        </td>
                        <td>
                            <input type="hidden" id="lastPourId" name="lastPourId" value="<?php echo $lastPour != NULL?$lastPour->get_id():"-1";?>" />
                            <input type="text" name="displayAmount" id="displayAmount" class="smallbox" value="<?php echo $lastPour != NULL?$lastPour->get_amountPouredDisplay():"No Last Pour";?>" onkeyup="updatePulses(<?php echo $lastPour != NULL?$lastPour->get_amountPouredDisplay():"-1";?>,<?php echo $lastPour != NULL?$lastPour->get_pulses():"-1";?>, <?php echo (is_unit_imperial($config[ConfigNames::DisplayUnitVolume])?"false":"true")?>)"/>
                            <input type="hidden" name="originalAmount" value="<?php echo $lastPour != NULL?$lastPour->get_amountPoured():"-1";?>" />
                            <input type="hidden" name="displayAmountUnit" value="<?php echo $config[ConfigNames::DisplayUnitVolume]?>" />
                        </td>
                        <td>
                        	<input type="text"name="newVolPerPulse" id="newVolPerPulse" class="smallbox" value="<?php echo $lastPour != NULL?$lastPour->get_amountPouredDisplay()/$lastPour->get_pulses():"No Last Pour";?>" onkeyup="updateVolumeFromVolPerPulse(<?php echo $lastPour != NULL?$lastPour->get_amountPouredDisplay():"-1";?>,<?php echo $lastPour != NULL?$lastPour->get_pulses():"-1";?>, <?php echo (is_unit_imperial($config[ConfigNames::DisplayUnitVolume])?"false":"true")?>)" />
                        </td>
                        <td>
                        	<input type="text"name="newPulsePerVol" id="newPulsePerVol" class="smallbox" value="<?php echo $lastPour != NULL?$lastPour->get_pulses()/$lastPour->get_amountPouredDisplay():"No Last Pour";?>" onkeyup="updateVolumeFromPulsePerVol(<?php echo $lastPour != NULL?$lastPour->get_amountPouredDisplay():"-1";?>,<?php echo $lastPour != NULL?$lastPour->get_pulses():"-1";?>, <?php echo (is_unit_imperial($config[ConfigNames::DisplayUnitVolume])?"false":"true")?>)" />
                        </td>
                        <td>
                        	<input type="text" readonly="readonly" name="newPulsePerGal" id="newPulsePerGal" class="smallbox" value="<?php echo $lastPour != NULL?convert_count($tap->get_count(), $tap->get_countUnit(), $config[ConfigNames::DisplayUnitVolume]):"No Last Pour";?>" onkeyup="updateVolume(<?php echo $lastPour != NULL?$lastPour->get_amountPouredDisplay():"-1";?>,<?php echo $lastPour != NULL?$lastPour->get_pulses():"-1";?>)" />
                        </td>
                        <td>
                            <?php echo $lastPour != NULL?$lastPour->get_pulses():"No Last Pour";?>
                            <input type="hidden" name="originalPulses" value="<?php echo $lastPour != NULL?$lastPour->get_pulses():"-1";?>" />
                        </td>
                </tr>					
                <?php } ?>
            </tbody>
        </table>
            <?php if($lastPour != NULL){?><input name="saveTapCalibration" type="submit" class="btn" value="Save" /><?php }?>
            <input type="submit" name="revert"        class="btn" value="Revert" />
        </form>	
        <br />
        <div id="dialog"></div>
        <div>
            &nbsp; &nbsp; 
        </div>
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
function updateVolumeFromVolPerPulse(originalVolume, originalPulses, convertToGals)
{
	$("#displayAmount")[0].value = ($("#newVolPerPulse")[0].value*originalPulses) ;
	$("#newPulsePerVol")[0].value = (originalPulses/$("#displayAmount")[0].value) ;
	$("#newPulsePerGal")[0].value = (!convertToGals?128:1000)*(originalPulses/$("#displayAmount")[0].value);
}
function updateVolumeFromPulsePerVol(originalVolume, originalPulses, convertToGals)
{
    $("#displayAmount")[0].value = (originalPulses/$("#newPulsePerVol")[0].value) ;
	$("#newVolPerPulse")[0].value = ($("#displayAmount")[0].value/originalPulses);
	$("#newPulsePerGal")[0].value = (!convertToGals?128:1000)*(originalPulses/$("#displayAmount")[0].value);
}
function updatePulses(originalVolume, originalPulses, convertToGals)
{
	$("#newVolPerPulse")[0].value = ($("#displayAmount")[0].value/originalPulses);
	$("#newPulsePerVol")[0].value = (originalPulses/$("#displayAmount")[0].value) ;
	$("#newPulsePerGal")[0].value = (!convertToGals?128:1000)*(originalPulses/$("#displayAmount")[0].value);
}
</script>
	<!-- End Js -->

</body>

</html>