<?php
require_once __DIR__.'/header.php';
require_once 'includes/managers/gasTank_manager.php';

$htmlHelper = new HtmlHelper();
$gasTankManager = new GasTankManager();
$gasTankStatusManager = new GasTankStatusManager();
$gasTankTypeManager = new GasTankTypeManager();

$config = getAllConfigs();
if (isset ( $_POST ['tare'] )) {
    $gasTankManager->set_GasTankTareRequested($_POST ['tare'], TRUE);
    triggerPythonAction("tare");
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['save']) ) {
    $gasTank = new GasTank();
    $gasTank->setFromArray($_POST);
    $orgGasTank = $gasTankManager->GetByID($gasTank->get_id());
    if($gasTankManager->Save($gasTank)){
        if($orgGasTank && 
            (   $orgGasTank->get_loadCellCmdPin() != $gasTank->get_loadCellCmdPin() || 
                $orgGasTank->get_loadCellRspPin() != $gasTank->get_loadCellRspPin() || 
                $orgGasTank->get_loadCellTareOffset() != $gasTank->get_loadCellTareOffset() || 
                $orgGasTank->get_loadCellScaleRatio() != $gasTank->get_loadCellScaleRatio() ) ){
            include("triggerAll.php");
        }
        unset($_POST);
        redirect('gasTank_list.php');
    }
}

$gasTank = null;
if( isset($_GET['id'])){
    $gasTank = $gasTankManager->GetById($_GET['id']);
}else if( isset($_POST['id'])){
    $gasTank = $gasTankManager->GetById($_POST['id']);
}

if($gasTank == null){
    $gasTank = new GasTank();
    $gasTank->setFromArray($_POST);
}

$gasTankStatusList = $gasTankStatusManager->GetAll();
$gasTankTypeList = $gasTankTypeManager->GetAll();
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
			<li><a href="gasTank_list.php">Gas Tank List</a></li>
			<li>/</li>
			<li class="current">Gas Tank Form</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End --> 
	
	<!-- Right Side/Main Content Start -->
	<div id="rightside">
		<div class="contentcontainer med left">
	<p>
		fields marked with an * are required
		<?php $htmlHelper->ShowMessage(); ?>

	<form id="gasTank-form" method="POST">
		<input type="hidden" name="id" value="<?php echo $gasTank->get_id() ?>" />
		<input type="hidden" name="active" value="1" />

		<table style="width:950;border:0;cellspacing:1;cellpadding:0;">
			<tr>
				<td>
					Label: <b><font color="red">*</font></b>
				</td>
				<td>
					<input type="text" id="label" class="mediumbox" name="label" value="<?php echo $gasTank->get_label() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Status: <b><font color="red">*</font></b>
				</td>
				<td>
					<?php echo $htmlHelper->ToSelectList("gasTankStatusCode", "gasTankStatusCode", $gasTankStatusList, "name", "code", $gasTank->get_gasTankStatusCode(), "Select One"); ?>
				</td>
			</tr>
			<tr>
				<td>
					Type: <b><font color="red">*</font></b>
				</td>
				<td>
					<?php echo $htmlHelper->ToSelectList("gasTankTypeId", "gasTankTypeId", $gasTankTypeList, "name", "id", $gasTank->get_gasTankTypeId(), "Select One"); ?>
				</td>
			</tr>	
			<tr>
				<td>
					Make: 
				</td>
				<td>
					<input type="text" id="make" class="mediumbox" name="make" value="<?php echo $gasTank->get_make() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Model: 
				</td>
				<td>
					<input type="text" id="model" class="mediumbox" name="model" value="<?php echo $gasTank->get_model() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Serial: 
				</td>
				<td>
					<input type="text" id="serial" class="mediumbox" name="serial" value="<?php echo $gasTank->get_serial() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Current Weight(<?php echo $config[ConfigNames::DisplayUnitWeight]; ?>):<br>(not &lt; Empty Weight)
				</td>
				<td>
					<input type="text" id="weight" class="mediumbox" name="weight" value="<?php echo convert_weight($gasTank->get_weight(), $gasTank->get_weightUnit(), $config[ConfigNames::DisplayUnitWeight]); ?>" onchange="updateCurrentAmount()"/>
					<input type="hidden" id="weightUnit" name="weightUnit" value="<?php echo $config[ConfigNames::DisplayUnitWeight]; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Empty Weight(<?php echo $config[ConfigNames::DisplayUnitWeight]; ?>): 
				</td>
				<td>
					<input type="text" id="emptyWeight" class="mediumbox" name="emptyWeight" value="<?php echo convert_weight($gasTank->get_emptyWeight(), $gasTank->get_emptyWeightUnit(), $config[ConfigNames::DisplayUnitWeight]); ?>" />
					<input type="hidden" id="emptyWeightUnit" name="emptyWeightUnit" value="<?php echo $config[ConfigNames::DisplayUnitWeight]; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Max Weight (<?php echo $config[ConfigNames::DisplayUnitWeight]; ?>): 
				</td>
				<td>
					<input type="text" id="maxWeight" class="mediumbox" name="maxWeight" value="<?php echo convert_Weight($gasTank->get_maxWeight(), $gasTank->get_maxWeightUnit(), $config[ConfigNames::DisplayUnitWeight], TRUE); ?>" />
					<input type="hidden" id="maxWeightUnit" name="maxWeightUnit" value="<?php echo $config[ConfigNames::DisplayUnitWeight]; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Load Cell Notes: 
				</td>
				<td>
					<textarea id="notes" class="text-input textarea" name="notes" style="width:500px;height:100px"><?php echo $gasTank->get_notes() ?></textarea>
				</td>
			</tr>
			<tr>
				<td>
					Load Cell Command Pin: 
				</td>
				<td>
					<input type="text" id="loadCellCmdPin" class="smallbox" name="loadCellCmdPin" value="<?php echo $gasTank->get_loadCellCmdPin() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Response Pin: 
				</td>
				<td>
					<input type="text" id="loadCellRspPin" class="smallbox" name="loadCellRspPin" value="<?php echo $gasTank->get_loadCellRspPin() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Load Cell Scale Ratio: 
				</td>
				<td>
					<input type="text" id="loadCellScaleRatio" class="smallbox" name="loadCellScaleRatio" value="<?php echo $gasTank->get_loadCellScaleRatio() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Load Cell Tare Offset: 
				</td>
				<td>
					<input type="text" id="loadCellTareOffset" class="smallbox" name="loadCellTareOffset" value="<?php echo $gasTank->get_loadCellTareOffset() ?>" />
                </td>
			</tr>
			<tr>
				<td>
					Load Cell Unit: 
				</td>
				<td>
                    <select name="loadCellUnit">
                    <?php
                        $result = getConfigByName(ConfigNames::DisplayUnitWeight);
        				foreach($result as $row) {
        				    $options = explode('|', $row['validation']);
        				    foreach($options as $option){
        				        echo '<option ' . ($gasTank->get_loadCellUnit()==$option?'selected':'') . ' value="'.$option.'">'.$option.'</option>'; 
        					}
        			} ?>
        			</select>	
				</td>
			</tr>
			<tr>
				<td> 
				</td>
				<td>
                <?php if( $gasTank->get_loadCellCmdPin() != '' ) { ?>
                    <button name="tare" id="tare<?php echo $gasTank->get_id();?>" type="button" class="btn" style="white-space:nowrap;" value="1" 
                    onClick='tareTank(this, <?php echo $gasTank->get_id()?>); $(loadCellTareOffset<?php echo $gasTank->get_id()?>).attr("disabled", "disabled");'>Tare</button>
                    <span id="tare<?php echo $gasTank->get_id();?>Success" style="display:none; color: #8EA534;"> (Success<br>Refresh to see Offset)</span>
                <?php } ?>
                </td>
			</tr>			
			<tr>
				<td colspan="2">
					<input name="save" type="submit" class="btn" value="Save" />
					<input type="button" class="btn" value="Cancel" onclick="window.location='gasTank_list.php'" />
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
	$(function() {		
		
		$('#gasTank-form').validate({
			rules: {
				label: { required: true },
				gasTankTypeId: { required: true },
				gasTankStatusCode: { required: true },
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


	function tareTank(button, gasTankId){
		var data
		data = { "tare" : gasTankId }
		
		$.ajax(
            {
                   type: "POST",
                   url: "gasTank_form.php",
                   data: data,// data to send to above script page if any
                   cache: false,
                   success: function(response)
                   {
                	   document.getElementById(button.id + 'Success').style.display = ""; 
                   }
             });
  	}
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
