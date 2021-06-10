<?php
require_once __DIR__.'/header.php';
require_once 'includes/managers/fermenter_manager.php';
$htmlHelper = new HtmlHelper();
$fermenterManager = new FermenterManager();
$fermenterStatusManager = new FermenterStatusManager();
$fermenterTypeManager = new FermenterTypeManager();
$beerManager = new BeerManager();

$config = getAllConfigs();

if (isset($_POST['inactivateFermenter'])) {
	$fermenterManager->Inactivate($_POST['inactivateFermenter']);		
}
if (isset($_POST['editFermenter'])) {
	//Element contains fermenterId
	$id = $_POST ['editFermenter'];
	$ii = 0;
	while(isset($_POST ['fermenterId'][$ii]))
	{
		if($_POST ['fermenterId'][$ii]==$id)break;
		$ii++;
	}
	if(isset($_POST['fermenterId'][$ii]))
	{
		$fermenter = $fermenterManager->GetById($id);
		if($fermenter){
		    $fermenter->set_label($_POST['label'][$ii]);
		    $beerExloded = explode("~", $_POST['beerId'][$ii]);
		    $selectedBeerId = $beerExloded[0];
		    $selectedBatchId = $beerExloded[1];
		    if($fermenter->get_beerId() != $selectedBeerId ||
		        $fermenter->get_beerBatchId() != $selectedBatchId){
		            $fermenter->set_beerId($selectedBeerId);
		            $fermenter->set_beerBatchId($selectedBatchId);
			        $fermenter->set_startAmount($fermenter->get_maxVolume());
			        $fermenter->set_currentAmount($fermenter->get_maxVolume());
			        $fermenter->set_startDate(date('Y-m-d H:i:s'));
			}
			$fermenter->set_fermenterStatusCode($_POST['fermenterStatusCode'][$ii]);
			$fermenterManager->save($fermenter);
		}
	}
	redirect("fermenter_form.php?id=$id");
}

if (isset($_POST['saveAll'])) {
	$ii = 0;
	while(isset($_POST ['fermenterId'][$ii]))
	{
		$id = $_POST ['fermenterId'][$ii];
		
		$fermenter = $fermenterManager->GetById($id);
		if($fermenter){
		    $fermenter->set_label($_POST['label'][$ii]);
		    $beerExloded = explode("~", $_POST['beerId'][$ii]);
		    $selectedBeerId = $beerExloded[0];
		    $selectedBatchId = $beerExloded[1];
		    if($fermenter->get_beerId() != $selectedBeerId ||
		        $fermenter->get_beerBatchId() != $selectedBatchId){
		            $fermenter->set_beerId($selectedBeerId);
		            $fermenter->set_beerBatchId($selectedBatchId);
		            $fermenter->set_startAmount($fermenter->get_maxVolume());
		            $fermenter->set_currentAmount($fermenter->get_maxVolume());
		            $fermenter->set_startDate(date('Y-m-d H:i:s'));
		    }
			$fermenter->set_fermenterStatusCode($_POST['fermenterStatusCode'][$ii]);
			$fermenterManager->save($fermenter);
		}
		
		$ii++;
	}
}
$fermenters = $fermenterManager->GetAllActive();
$fermenterStatusList = $fermenterStatusManager->GetAll();
//$fermenterTypeList = $fermenterTypeManager->GetAll();
$beerList = $beerManager->GetAllActiveWithBatches();
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
			<li class="current">Fermenter List</li>            
		</ul>
	</div>
	<!-- Top Breadcrumb End --> 
	
	<!-- Right Side/Main Content Start -->
	<div id="rightside">
		<div class="contentcontainer left">
			<?php $htmlHelper->ShowMessage(); ?>
			<div class="headings alt">
				<h2>Fermenter List</h2>
			</div>
			<!-- Start On Fermenter Section -->
			
			<form method="POST">
			<input type="submit" class="btn" value="Save All" name="saveAll" />
			<input type="button" class="btn" value="Add a Fermenter" onClick="window.location='fermenter_form.php'" />
			<?php 
            	foreach ($fermenters as $fermenter){
			?>
                	<input type="hidden" name="fermenterId[]" value="<?php echo $fermenter->get_id() ?>" />
			<?php
				}		
			?>
			<table style="border:0;cellspacing:1;cellpadding:0;" class="fermenterlist outerborder">
				<thead class="intborder thick">
					<tr>
						<th style="align-content:center">Label</th>
						<th style="width:10%;align-content:center">Status / Update</th>
						<th style="width:28%;align-content:center">Beer Name</th>
						<th style="width:28%;align-content:center">Fermenter Type</th>
						<th style="width:28%;align-content:center">Make</th>
						<th style="width:29%;align-content:center">Model</th>
                        <th></th>
					</tr>
				</thead>

				<tbody>
					<?php 
						if( count($fermenters) == 0 ){  
					?>
					<tr><td class="no-results" colspan="99">No fermenters :(<br>Perhaps you should add one?</td></tr>
					<?php 
						}else{  
							foreach ($fermenters as $fermenter){
															
								if( $fermenter->get_fermenterTypeId() != null ){
									$fermenterType = $fermenterTypeManager->GetById($fermenter->get_fermenterTypeId());
								}else{
									$fermenterType = new FermenterType();
								}
					?>
					<tr>
						<td rowspan="3" class="leftborder intborder" style="vertical-align:middle;align-content:center">
							<span class="fermentersquare"> 
								<input type="text" id="label" class="smallbox" name="label[]" value="<?php echo $fermenter->get_label() ?>" />
                            </span>
						</td>
						
						<td rowspan="3" class="leftborder rightborder intborder" style="vertical-align:middle; align-content:center; font-size:1.2em">
							<?php 
								echo $htmlHelper->ToSelectList("fermenterStatusCode[]", "fermenterStatusCode", $fermenterStatusList, "name", "code", $fermenter->get_fermenterStatusCode(), "Select One"); 
							?>
						</td>
						<td rowspan="3" class="leftborder rightborder intborder" style="vertical-align:middle; align-content:center; font-size:1.2em">
							<?php 
							
    							$str = "<select id='beerId' name='beerId[]' class=''>\n";
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
    							//echo $htmlHelper->ToSelectList("beerId[]", "beerId", $beerList, "name", "id", $fermenter->get_beerId(), "Select One");
							?>
						</td>						
						<td style="vertical-align:middle; align-content:center; font-size:1.2em">
							<b><?php echo $fermenterType->get_name() ?></b>
						</td>
						<td style="vertical-align:middle; align-content:center; font-size:1.2em">
							<b><?php echo $fermenter->get_make() ?></b>
						</td>
						
						<td style="vertical-align:middle; align-content:center; font-size:1.2em">
							<b><?php echo $fermenter->get_model() ?></b>
						</td>
						<td class="rightborder thick" style="vertical-align:middle; align-content:center; font-size:1.2em">
							<button class="btn" name="editFermenter" type="submit" value="<?php echo $fermenter->get_id()?>" >Edit</button>
                        </td>
					</tr>
					<tr>					
						<td style="padding-bottom: 1px; padding-top: 1px">
							<b>Serial Number:</b> &nbsp; <?php echo $fermenter->get_serial() ?><br>
							<b>Max Volume(<?php echo (is_unit_imperial($config[ConfigNames::DisplayUnitVolume])?"Gal":"L")?>):</b> &nbsp; <?php echo convert_volume($fermenter->get_maxVolume(), $fermenter->get_maxVolumeUnit(), $config[ConfigNames::DisplayUnitVolume], TRUE) ?><br>
						</td>			
						<td  style="padding-bottom: 1px; padding-top: 1px">
							<b>Start Amount(<?php echo (is_unit_imperial($config[ConfigNames::DisplayUnitVolume])?"Gal":"L")?>):</b> &nbsp; <?php echo convert_volume($fermenter->get_startAmount(), $fermenter->get_startAmountUnit(), $config[ConfigNames::DisplayUnitVolume], TRUE) ?><br>
							<b>Current Amount(<?php echo (is_unit_imperial($config[ConfigNames::DisplayUnitVolume])?"Gal":"L")?>):</b> &nbsp; <?php echo convert_volume($fermenter->get_currentAmount(), $fermenter->get_currentAmountUnit(), $config[ConfigNames::DisplayUnitVolume], TRUE) ?><br>
						</td>
						<td style="padding-bottom: 1px; padding-top: 1px">
						</td>
						<td class="rightborder thick" style="vertical-align:middle; align-content:center; font-size:1.2em; padding-bottom: 2px">
							<button class="inactivateFermenter btn" name="inactivateFermenter" type="submit" value="<?php echo $fermenter->get_id()?>" >Delete</button>
						</td>
					</tr>
					<tr class="intborder">				
						<td colspan="4" class="rightborder thick"  style="padding-top: 1px">
							<b>Notes:</b> &nbsp; <?php echo htmlentities($fermenter->get_notes()) ?>
						</td>
					</tr>
		<?php 
				}
			}
		?>
				</tbody>
			</table>
			<input type="submit" class="btn" value="Save All" name="saveAll" />
			<input type="button" class="btn" value="Add a Fermenter" onClick="window.location='fermenter_form.php'" />
			</form>
			<!-- Start Footer -->   
			<?php
				include 'footer.php';
			?>
			<!-- End Footer -->
		</div>
	</div>
	
	<!-- End On Fermenter Section -->
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
		$('.inactivateFermenter').on('click', function(){
			if(!confirm('Are you sure you want to delete this fermenter?')){
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
