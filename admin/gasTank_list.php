<?php
require_once __DIR__.'/header.php';
require_once 'includes/managers/gasTank_manager.php';
$htmlHelper = new HtmlHelper();
$gasTankManager = new GasTankManager();
$gasTankStatusManager = new GasTankStatusManager();
$gasTankTypeManager = new GasTankTypeManager();

$config = getAllConfigs();

if (isset($_POST['inactivateGasTank'])) {
	$gasTankManager->Inactivate($_POST['inactivateGasTank']);		
}
if (isset($_POST['editGasTank'])) {
	//Element contains gasTankId
	$id = $_POST ['editGasTank'];
	$ii = 0;
	while(isset($_POST ['gasTankId'][$ii]))
	{
		if($_POST ['gasTankId'][$ii]==$id)break;
		$ii++;
	}
	if(isset($_POST['gasTankId'][$ii]))
	{
		$gasTank = $gasTankManager->GetById($id);
		if($gasTank){
			$gasTank->set_label($_POST['label'][$ii]);
			$gasTank->set_gasTankStatusCode($_POST['gasTankStatusCode'][$ii]);
			$gasTankManager->save($gasTank);
		}
	}
	redirect("gasTank_form.php?id=$id");
}

if (isset($_POST['saveAll'])) {
	$ii = 0;
	while(isset($_POST ['gasTankId'][$ii]))
	{
		$id = $_POST ['gasTankId'][$ii];
		
		$gasTank = $gasTankManager->GetById($id);
		if($gasTank){
		    $gasTank->set_label($_POST['label'][$ii]);
			$gasTank->set_gasTankStatusCode($_POST['gasTankStatusCode'][$ii]);
			$gasTankManager->save($gasTank);
		}
		
		$ii++;
	}
}
$gasTanks = $gasTankManager->GetAllActive();
$gasTankStatusList = $gasTankStatusManager->GetAll();
//$gasTankTypeList = $gasTankTypeManager->GetAll();
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
			<li class="current">Gas Tank List</li>            
		</ul>
	</div>
	<!-- Top Breadcrumb End --> 
	
	<!-- Right Side/Main Content Start -->
	<div id="rightside">
		<div class="contentcontainer left">
			<?php $htmlHelper->ShowMessage(); ?>
			<div class="headings alt">
				<h2>Gas Tank List</h2>
			</div>
			<!-- Start On GasTank Section -->
			
			<form method="POST">
			<input type="submit" class="btn" value="Save All" name="saveAll" />
			<input type="button" class="btn" value="Add a GasTank" onClick="window.location='gasTank_form.php'" />
			<?php 
            	foreach ($gasTanks as $gasTank){
			?>
                	<input type="hidden" name="gasTankId[]" value="<?php echo $gasTank->get_id() ?>" />
			<?php
				}		
			?>
			<table style="border:0;cellspacing:1;cellpadding:0;" class="gasTanklist outerborder">
				<thead class="intborder thick">
					<tr>
						<th style="align-content:center">Label</th>
						<th style="width:10%;align-content:center">Status / Update</th>
						<th style="width:28%;align-content:center">GasTank Type</th>
						<th style="width:28%;align-content:center">Make</th>
						<th style="width:29%;align-content:center">Model</th>
                        <th></th>
					</tr>
				</thead>

				<tbody>
					<?php 
						if( count($gasTanks) == 0 ){  
					?>
					<tr><td class="no-results" colspan="99">No gasTanks :(<br>Perhaps you should add one?</td></tr>
					<?php 
						}else{  
							foreach ($gasTanks as $gasTank){
															
								if( $gasTank->get_gasTankTypeId() != null ){
									$gasTankType = $gasTankTypeManager->GetById($gasTank->get_gasTankTypeId());
								}else{
									$gasTankType = new GasTankType();
								}
					?>
					<tr>
						<td rowspan="3" class="leftborder intborder" style="vertical-align:middle;align-content:center">
							<span class="gasTanksquare"> 
								<input type="text" id="label" class="smallbox" name="label[]" value="<?php echo $gasTank->get_label() ?>" />
                            </span>
						</td>
						
						<td rowspan="3" class="leftborder rightborder intborder" style="vertical-align:middle; align-content:center; font-size:1.2em">
							<?php 
								echo $htmlHelper->ToSelectList("gasTankStatusCode[]", "gasTankStatusCode", $gasTankStatusList, "name", "code", $gasTank->get_gasTankStatusCode(), "Select One"); 
							?>
						</td>					
						<td style="vertical-align:middle; align-content:center; font-size:1.2em">
							<b><?php echo $gasTankType->get_name() ?></b>
						</td>
						<td style="vertical-align:middle; align-content:center; font-size:1.2em">
							<b><?php echo $gasTank->get_make() ?></b>
						</td>
						
						<td style="vertical-align:middle; align-content:center; font-size:1.2em">
							<b><?php echo $gasTank->get_model() ?></b>
						</td>
						<td class="rightborder thick" style="vertical-align:middle; align-content:center; font-size:1.2em">
							<button class="btn" name="editGasTank" type="submit" value="<?php echo $gasTank->get_id()?>" >Edit</button>
                        </td>
					</tr>
					<tr>					
						<td style="padding-bottom: 1px; padding-top: 1px">
							<b>Serial Number:</b> &nbsp; <?php echo $gasTank->get_serial() ?><br>
							<b>Empty Weight(<?php echo $config[ConfigNames::DisplayUnitWeight]?>):</b> &nbsp; <?php echo convert_weight($gasTank->get_emptyWeight(), $gasTank->get_emptyWeightUnit(), $config[ConfigNames::DisplayUnitWeight], TRUE) ?><br>
						</td>			
						<td  style="padding-bottom: 1px; padding-top: 1px">
							<b>Current Weight(<?php echo $config[ConfigNames::DisplayUnitWeight]?>):</b> &nbsp; <?php echo convert_weight($gasTank->get_currentWeight(), $gasTank->get_currentWeightUnit(), $config[ConfigNames::DisplayUnitWeight], TRUE) ?><br>
							<b>Full Weight(<?php echo $config[ConfigNames::DisplayUnitWeight]?>):</b> &nbsp; <?php echo convert_weight($gasTank->get_maxWeight(), $gasTank->get_maxWeightUnit(), $config[ConfigNames::DisplayUnitWeight], TRUE) ?><br>
						</td>
						<td style="padding-bottom: 1px; padding-top: 1px">
						</td>
						<td class="rightborder thick" style="vertical-align:middle; align-content:center; font-size:1.2em; padding-bottom: 2px">
							<button class="inactivateGasTank btn" name="inactivateGasTank" type="submit" value="<?php echo $gasTank->get_id()?>" >Delete</button>
						</td>
					</tr>
					<tr class="intborder">				
						<td colspan="4" class="rightborder thick"  style="padding-top: 1px">
							<b>Notes:</b> &nbsp; <?php echo htmlentities($gasTank->get_notes()); ?>
						</td>
					</tr>
		<?php 
				}
			}
		?>
				</tbody>
			</table>
			<input type="submit" class="btn" value="Save All" name="saveAll" />
			<input type="button" class="btn" value="Add a GasTank" onClick="window.location='gasTank_form.php'" />
			</form>
			<!-- Start Footer -->   
			<?php
				include 'footer.php';
			?>
			<!-- End Footer -->
		</div>
	</div>
	
	<!-- End On GasTank Section -->
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
	$(function(){
		$('.inactivateGasTank').on('click', function(){
			if(!confirm('Are you sure you want to delete this Gas Tank?')){
				return false;
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
