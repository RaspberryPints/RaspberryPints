<?php
require_once __DIR__.'/header.php';
$htmlHelper = new HtmlHelper();
$tapManager = new TapManager();
//$beerManager = new BeerManager();
//$kegManager = new KegManager();

$config = getAllConfigs();

const TAP_TEXT_ENABLE =  "Let it flow";
const TAP_TEXT_DISABLE = "Stop flow";

$reconfig = false;
if( isset($_POST['enableTap']) && $_POST['enableTap'] != ""){
	//The element holds the tap Id
    $tapManager->enableTap($_POST['enableTap']);
    triggerPythonAction("valve");
}

if( isset($_POST['disableTap']) && $_POST['disableTap'] != ""){
	//The element holds the tap Id
    $tapManager->disableTap($_POST['disableTap']);
    triggerPythonAction("valve");
}

if (isset ( $_POST ['saveTapConfig'] )) {
	$ii = 0;
	while(isset($_POST ['tapId'][$ii]))
	{
		$id = $_POST ['tapId'][$ii];
		$tap = $tapManager->GetById($id);		
				
		$flowpin = $tap->get_flowPinId();
		$valveon = 0;
		$valvepin = 0;
		$countpergallon = $tap->get_count();
		$countpergallonunit = $tap->get_countUnit();
		$plaatoAuthToken = $tap->get_plaatoAuthToken();
		if (isset ( $_POST ['valvepin'][$ii] )) {
			$valvepin = $_POST ['valvepin'][$ii] * ($_POST ['valvepinPi'][$id]?-1:1);
		}
		
		if (isset ( $_POST ['tapOverride'][$ii] )) {
		    $valveon = $_POST ['tapOverride'][$ii];
		}
	
		$tapManager->saveTapConfig ( $id, $flowpin, $valvepin, $valveon, $countpergallon, $countpergallonunit, $plaatoAuthToken );
		$ii++;
	}
	$reconfig = true;
} 
if (isset ( $_POST ['saveSettings'] ) || isset ( $_POST ['configuration'] )) {
	setConfigurationsFromArray($_POST, $config);
	if (isset ( $_POST ['saveSettings'] ) )$reconfig = true;
}

if($reconfig){
    triggerPythonAction();
}

$activeTaps = $tapManager->GetAllActive();
//$numberOfTaps = count($activeTaps);
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
			<li class="current">Valve List</li>            
		</ul>
	</div>
	<!-- Top Breadcrumb End --> 
	<!-- Right Side/Main Content Start -->
	<div id="rightside">
		<div class="contentcontainer med left" >
		<?php $htmlHelper->ShowMessage(); ?>
              
	<!-- Start Tap Config Form -->
		<div id="settingsDiv">
        
        <form id="configuration" method="post">
        	<input type="hidden" name="configuration" id="configuration" />
        	<input type="hidden" name="settingsExpanded" id="settingsExpanded" value="<?php echo (isset($_POST['settingsExpanded'])?$_POST['settingsExpanded']:'display:none'); ?>" />
            <table class="contentbox" style="width:100%; border:0;" >
            	<tr>
			<?php
			$result = getValveConfigurableConfigs();
				foreach($result as $row) {
					echo '<td>';
					echo '	<input type="hidden" name="' . $row['configName'] . '" value="0"/>';
					echo '	<input type="checkbox" ' . ($row['configValue']?'checked':'') . ' name="' . $row['configName'] . '" value="1" onClick="this.form.submit()">'.$row['displayName']."&nbsp;\n";
					echo '</td>';
				}
			?>        
            	</tr>
            </table>
        </form>
        
		<form method="POST" name="settings" >        
	<?php if($config[ConfigNames::UseTapValves]) { ?>
			<input type="hidden" name="tapValveConfig" id="tapValveConfig" />
	<?php } ?>
			<table class="contentbox" style="width:100%; border:0;" >
				<thead>
					<tr>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
	<?php if($config[ConfigNames::UseTapValves]) { ?>
					<tr>
						<td><b>Pour Shutoff Count:</b><br/>The flow meter count in one pour after which a tap is shutoff (0 to turn off) </td>
						<td><input type="text" name="pourShutOffCount" class="smallbox"	value="<?php echo ($config[ConfigNames::PourShutOffCount]) ?>"></td>
                    </tr>
                    <?php if($config[ConfigNames::Use3WireValves]) {?>
    					<tr>
    						<td><b>Valve Power Pin:</b><br/>The pin that powers three way the valves </td>
    						<td><input type="text" name="valvesPowerPin" class="smallbox" value="<?php echo ($config[ConfigNames::ValvesPowerPin]) ?>"></td>
    					</tr>
					<?php }?>
					<tr>
						<td><b>Valve On Time:</b><br/>The time the valves remain on </td>
						<td><input type="text" name="valvesOnTime" class="smallbox" value="<?php echo ($config[ConfigNames::ValvesOnTime]) ?>"></td>
					</tr>
					<tr>
						<td colspan="3">
                        	<input type="submit" name="saveSettings" class="btn" value="Save" />
                            <input type="submit" name="revert"       class="btn" value="Revert" />
                        </td>
					</tr>
	<?php } ?>
			</tbody>
		</table>
	</form>
    </div>
	<!-- End Tap Config Form -->
<br />
	<!-- Start On Tap Section -->
    <form method="POST" id="tap-form">        
            <?php foreach($activeTaps as $tap){ 
                if(null == $tap)continue; 
			?>
            	<input type="hidden" name="tapId[]" value="<?php echo $tap->get_id(); ?>" />
            <?php } ?> 
		<div id="messageDiv" class="error status" style="display:none;"><span id="messageSpan"></span></div>
		<table class="contentbox" style="width:75%; border:0;" >
        <thead>
            <tr>
                <th>Tap</th>
                <th>Valve Pin</th>
                <th> PI<br>Pin?</th>
            	<th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($activeTaps as $tap){ ?>
                <?php if(null == $tap)continue; ?> 
                <tr>
                    <td>
                        <?php if(isset($tap) ) { ?>
                            <span class="tapcircle">
                            	<?php echo $tap->get_tapNumber(); ?>
                            </span>
                        <?php } ?>
                    </td>
                    <?php if($config[ConfigNames::UseTapValves]) { ?>
                        <td>
                            <?php if( isset($tap) ) { ?>
                                <input type="text" id="valvepin<?php echo $tap->get_id();?>" class="smallbox" name="valvepin[]" value="<?php echo abs($tap->get_valvePinId()); ?>" />
                            <?php } ?>
                        </td>
                        <td>
                            <?php if( isset($tap) ) { ?>
                            	<input type="checkbox" id="valvepinPi<?php echo $tap->get_id();?>" class="xsmallbox" name="valvepinPi[<?php echo $tap->get_id();?>]" value="1" <?php if($tap->get_valvePinId() < 0)echo "checked" ?>  />
                            <?php } ?>
                        </td>
                    <?php } ?>
      				<?php 
                        if($config[ConfigNames::UseTapValves]) {
                        ?>
                        <td>
                            <?php if( isset($tap) ) { ?>
                                <button name="tapOverride[]" id="tapOverride<?php echo $tap->get_id();?>" type="button" class="btn" style="white-space:nowrap" value="<?php echo $tap->get_valveOn(); ?>" onClick="changeTapState(this, <?php echo $tap->get_id()?>)"><?php echo ($tap->get_valveOn() < 1?TAP_TEXT_ENABLE:TAP_TEXT_DISABLE);?></button>
                            <?php } ?>
                        </td>
                    <?php } ?>
            </tr>					
            <?php } ?>
        </tbody>
    </table>
        <input name="saveTapConfig" type="submit" class="btn" value="Save" />
        <input type="submit" name="revert"        class="btn" value="Revert" />
    </form>	
    <br />
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
	
	function toggleDisplay(selectObject, kegSelectStart, secSelectBeerStart, tapId) {
		var msgDiv = document.getElementById("messageDiv");
		if(msgDiv != null) msgDiv.style.display = "none"
		var display = true;
		var kegSelArr = selectObject.value.split("~");
		//Select array is kegid~beerid(in keg)~tapId(keg is on)
		var beerId = null;
		if(kegSelArr.length > 1 && kegSelArr[1] != "")
		{
			beerId = kegSelArr[1];
		}
		else
		{
			var secSelect = document.getElementById(secSelectBeerStart+tapId);
			secSelect.selectedIndex = 0;
		}
		if(kegSelArr.length > 2 && kegSelArr[2] != "") 
		{
			var onOtherTap = null;
			var ii = 1;
			var secOtherTapKegSelect = null;
			while( (secOtherTapKegSelect = document.getElementById(kegSelectStart+ii++)) != null){
				if(ii-1 == tapId)continue;
				otherKegSelArr = secOtherTapKegSelect.value.split("~");
				if(otherKegSelArr[0] == kegSelArr[0]) onOtherTap = kegSelArr[2];
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
				if(msgSpan != null) msgSpan.innerHTML = "Keg "+kegSelArr[0]+" currently on Tap "+kegSelArr[2]+" and will be moved to tap <?php echo ($tap?$tap->get_id():'');?> and updated to current selected beer"
				if(secOtherTapBeerSelect != null)secOtherTapBeerSelect.selectedIndex = 0;
				if(secOtherTapKegSelect != null)secOtherTapKegSelect.selectedIndex = 0;		
			}	
		}
		if(beerId != null){
			var secSelect = document.getElementById(secSelectBeerStart+tapId);
			var secSelectOptions = secSelect.options;
			for (var i = 0; i < secSelectOptions.length; i++) 
			{
				if (secSelectOptions[i].value == beerId) {
					secSelect.selectedIndex = i;
					break;
				}
			}
		}
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
</script>
	<!-- End Js -->

</body>

</html>