<?php
require_once __DIR__.'/header.php';
$htmlHelper = new HtmlHelper();
$kegManager = new KegManager();
$kegStatusManager = new KegStatusManager();
$kegTypeManager = new KegTypeManager();
$beerManager = new BeerManager();

$config = getAllConfigs();

if (isset($_POST['inactivateKeg'])) {
	$kegManager->Inactivate($_POST['inactivateKeg']);		
}
if (isset($_POST['editKeg'])) {
	//Element contains kegId
	$id = $_POST ['editKeg'];
	$ii = 0;
	while(isset($_POST ['kegId'][$ii]))
	{
		if($_POST ['kegId'][$ii]==$id)break;
		$ii++;
	}
	if(isset($_POST['kegId'][$ii]))
	{
		$keg = $kegManager->GetById($id);
		if($keg){
		    $keg->set_label($_POST['label'][$ii]);
		    $beerExloded = explode("~", $_POST['beerId'][$ii]);
		    $selectedBeerId = $beerExloded[0];
		    $selectedBatchId = $beerExloded[1];
		    if($keg->get_beerId() != $selectedBeerId ||
		       $keg->get_beerBatchId() != $selectedBatchId){
		           $keg->set_beerId($selectedBeerId);
		           $keg->set_beerBatchId($selectedBatchId);
			       $keg->set_startAmount($keg->get_maxVolume());
			       $keg->set_currentAmount($keg->get_maxVolume());
			}
			$keg->set_kegStatusCode($_POST['kegStatusCode'][$ii]);
			$kegManager->save($keg);
		}
	}
	redirect("keg_form.php?id=$id");
}

if (isset($_POST['saveAll'])) {
	$ii = 0;
	while(isset($_POST ['kegId'][$ii]))
	{
		$id = $_POST ['kegId'][$ii];
		
		$keg = $kegManager->GetById($id);
		if($keg){
		    $keg->set_label($_POST['label'][$ii]);		    
		    $beerExloded = explode("~", $_POST['beerId'][$ii]);
		    $selectedBeerId = $beerExloded[0];
		    $selectedBatchId = $beerExloded[1];
		    if($keg->get_beerId() != $selectedBeerId ||
		       $keg->get_beerBatchId() != $selectedBatchId){
		        $keg->set_beerId($selectedBeerId);
		        $keg->set_beerBatchId($selectedBatchId);
		        $keg->set_startAmount($keg->get_maxVolume());
		        $keg->set_currentAmount($keg->get_maxVolume());
		    }
			$keg->set_kegStatusCode($_POST['kegStatusCode'][$ii]);
			$kegManager->save($keg);
		}
		
		$ii++;
	}
}
$kegs = $kegManager->GetAllActive();
$kegStatusList = $kegStatusManager->GetAll();
//$kegTypeList = $kegTypeManager->GetAll();
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
			<li class="current">Keg List</li>            
		</ul>
	</div>
	<!-- Top Breadcrumb End --> 
	
	<!-- Right Side/Main Content Start -->
	<div id="rightside">
		<div class="contentcontainer left">
			<?php $htmlHelper->ShowMessage(); ?>
			<div class="headings alt">
				<h2>Keg List</h2>
			</div>
			<!-- Start On Keg Section -->
			
			<form method="POST">
			<input type="submit" class="btn" value="Save All" name="saveAll" />
			<input type="button" class="btn" value="Add a Keg" onClick="window.location='keg_form.php'" />
			<?php 
            	foreach ($kegs as $keg){
			?>
                	<input type="hidden" name="kegId[]" value="<?php echo $keg->get_id() ?>" />
			<?php
				}		
			?>
			<table style="border:0;cellspacing:1;cellpadding:0;" class="keglist outerborder">
				<thead class="intborder thick">
					<tr>
						<th style="align-content:center">Label</th>
						<th style="width:10%;align-content:center">Status / Update</th>
						<th style="width:28%;align-content:center">Beer Name</th>
						<th style="width:28%;align-content:center">Keg Type</th>
						<th style="width:28%;align-content:center">Make</th>
						<th style="width:29%;align-content:center">Model</th>
                        <th></th>
					</tr>
				</thead>

				<tbody>
					<?php 
						if( count($kegs) == 0 ){  
					?>
					<tr><td class="no-results" colspan="99">No kegs :(<br>Perhaps you should add one?</td></tr>
					<?php 
						}else{  
							foreach ($kegs as $keg){
								
								if( $keg->get_kegStatusCode() != null ){
									//$kegStatus = $kegStatusManager->GetById($keg->get_kegStatusCode());
								}else{
									//$kegStatus = new KegStatus();
								}
								
								if( $keg->get_kegTypeId() != null ){
									$kegType = $kegTypeManager->GetById($keg->get_kegTypeId());
								}else{
									$kegType = new KegType();
								}
					?>
					<tr>
						<td rowspan="3" class="leftborder intborder" style="vertical-align:middle;align-content:center">
							<span class="kegsquare"> 
								<input type="text" id="label" class="smallbox" name="label[]" value="<?php echo $keg->get_label() ?>" />
                            </span>
						</td>
						
						<td rowspan="3" class="leftborder rightborder intborder" style="vertical-align:middle; align-content:center; font-size:1.2em">
							<?php 
								echo $htmlHelper->ToSelectList("kegStatusCode[]", "kegStatusCode", $kegStatusList, "name", "code", $keg->get_kegStatusCode(), "Select One"); 
							?>
						</td>
						<td rowspan="3" class="leftborder rightborder intborder" style="vertical-align:middle; align-content:center; font-size:1.2em">
        					<?php 
        						$str = "<select id='beerId' name='beerId[]' class=''>\n";
        						$str .= "<option value=''>Select One</option>\n";
        						foreach($beerList as $item){
        						    if( !$item ) continue;
        						    $sel = "";
        						    if( isset($keg) && $keg->get_beerId() == ($item->get_beerBatchId()<=0?$item->get_id():$item->get_beerId()) && (($keg->get_beerBatchId() <= 0 && $item->get_beerBatchId()<=0) || $keg->get_beerBatchId() == $item->get_beerBatchId()) )  $sel .= "selected ";
        						    $desc = $item->get_displayName();
        						    $str .= "<option value='".($item->get_beerBatchId()<=0?$item->get_id():$item->get_beerId())."~".$item->get_beerBatchId()."~".$item->get_fg()."~".$item->get_fgUnit()."' ".$sel.">".$desc."</option>\n";
        						}
        						$str .= "</select>\n";
        						
        						echo $str;
        						// echo $htmlHelper->ToSelectList("beerId", "beerId", $beerList, "name", "id", $keg->get_beerId(), ($keg->get_onTapId()?null:"Select One")); 
        					?>
						</td>						
						<td style="vertical-align:middle; align-content:center; font-size:1.2em">
							<b><?php echo $kegType->get_name() ?></b>
						</td>
						<td style="vertical-align:middle; align-content:center; font-size:1.2em">
							<b><?php echo $keg->get_make() ?></b>
						</td>
						
						<td style="vertical-align:middle; align-content:center; font-size:1.2em">
							<b><?php echo $keg->get_model() ?></b>
						</td>
						<td class="rightborder thick" style="vertical-align:middle; align-content:center; font-size:1.2em">
							<button class="btn" name="editKeg" type="submit" value="<?php echo $keg->get_id()?>" >Edit</button>
                        </td>
					</tr>
					<tr>					
						<td style="padding-bottom: 1px; padding-top: 1px">
							<b>Stamped Owner:</b> &nbsp; <?php echo $keg->get_stampedOwner() ?><br>
							<b>Serial Number:</b> &nbsp; <?php echo $keg->get_serial() ?><br>
							<b>Max Volume(<?php echo (is_unit_imperial($config[ConfigNames::DisplayUnitVolume])?"Gal":"L")?>):</b> &nbsp; <?php echo convert_volume($keg->get_maxVolume(), $keg->get_maxVolumeUnit(), $config[ConfigNames::DisplayUnitVolume], TRUE) ?><br>
						</td>			
						<td  style="padding-bottom: 1px; padding-top: 1px">
							<b>Location:</b> &nbsp; <?php echo $keg->get_stampedLoc() ?><br>
							<b>Start Amount(<?php echo (is_unit_imperial($config[ConfigNames::DisplayUnitVolume])?"Gal":"L")?>):</b> &nbsp; <?php echo convert_volume($keg->get_startAmount(), $keg->get_startAmountUnit(), $config[ConfigNames::DisplayUnitVolume], TRUE) ?><br>
							<b>Current Amount(<?php echo (is_unit_imperial($config[ConfigNames::DisplayUnitVolume])?"Gal":"L")?>):</b> &nbsp; <?php echo convert_volume($keg->get_currentAmount(), $keg->get_currentAmountUnit(), $config[ConfigNames::DisplayUnitVolume], TRUE) ?><br>
						</td>
						<td style="padding-bottom: 1px; padding-top: 1px">
						</td>
						<td class="rightborder thick" style="vertical-align:middle; align-content:center; font-size:1.2em; padding-bottom: 2px">
							<button class="inactivateKeg btn" name="inactivateKeg" type="submit" value="<?php echo $keg->get_id()?>" >Delete</button>
						</td>
					</tr>
					<tr class="intborder">				
						<td colspan="4" class="rightborder thick"  style="padding-top: 1px">
							<b>Notes:</b> &nbsp; <?php echo htmlentities($keg->get_notes()) ?>
						</td>
					</tr>
		<?php 
				}
			}
		?>
				</tbody>
			</table>
			<input type="submit" class="btn" value="Save All" name="saveAll" />
			<input type="button" class="btn" value="Add a Keg" onClick="window.location='keg_form.php'" />
			</form>
			<!-- Start Footer -->   
			<?php
				include 'footer.php';
			?>
			<!-- End Footer -->
		</div>
	</div>
	
	<!-- End On Keg Section -->
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
		$('.inactivateKeg').on('click', function(){
			if(!confirm('Are you sure you want to delete this keg?')){
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
