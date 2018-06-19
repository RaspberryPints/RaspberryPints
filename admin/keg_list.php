<?php
require_once __DIR__.'/header.php';
$htmlHelper = new HtmlHelper();
$kegManager = new KegManager();
$kegStatusManager = new KegStatusManager();
$kegTypeManager = new KegTypeManager();
$beerManager = new BeerManager();

if (isset($_POST['inactivateKeg'])) {
	$kegManager->Inactivate($_POST['id']);		
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
			$keg->set_beerId($_POST['beerId'][$ii]);
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
			$keg->set_beerId($_POST['beerId'][$ii]);
			$keg->set_kegStatusCode($_POST['kegStatusCode'][$ii]);
			$kegManager->save($keg);
		}
		
		$ii++;
	}
}
$kegs = $kegManager->GetAllActive();
$kegStatusList = $kegStatusManager->GetAll();
$kegTypeList = $kegTypeManager->GetAll();
$beerList = $beerManager->GetAllActive();
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
			<input type="submit" class="btn" value="Add a Keg" onClick="window.location='keg_form.php'" />
			<?php 
            	foreach ($kegs as $keg){
			?>
                	<input type="hidden" name="kegId[]" value="<?php echo $keg->get_id() ?>" />
			<?php
				}		
			?>
			<table border="0" cellspacing="0" cellpadding="0" class="keglist outerborder">
				<thead class="intborder thick">
					<tr>
						<th ><center>Label</center></th>
						<th width="10%" colspan="2"><center>Status / Update</center></th>
						<th width="28%"><center>Beer Name</center></th>
						<th width="28%"><center>Keg Type</center></th>
						<th width="28%"><center>Make</center></th>
						<th width="29%"><center>Model</center></th>
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
									$kegStatus = $kegStatusManager->GetById($keg->get_kegStatusCode());
								}else{
									$kegStatus = new KegStatus();
								}
								
								if( $keg->get_kegTypeId() != null ){
									$kegType = $kegTypeManager->GetById($keg->get_kegTypeId());
								}else{
									$kegType = new KegType();
								}
					?>
					<tr>
						<td rowspan="2" class="intborder">
							<center><span class="kegsquare"> 
								<input type="text" id="label" class="smallbox" name="label[]" value="<?php echo $keg->get_label() ?>" />
                            </span></center>
						</td>
						
						<td colspan="2" class="leftborder rightborder" style="vertical-align:middle; font-size:1.2em;">
							<center>
							<?php 
								echo $htmlHelper->ToSelectList("kegStatusCode[]", "kegStatusCode", $kegStatusList, "name", "code", $keg->get_kegStatusCode(), "Select One"); 
							?>
                            </center>
						</td>
						<td style="vertical-align:middle; font-size:1.2em;">
							<center>
							<?php 
								echo $htmlHelper->ToSelectList("beerId[]", "beerId", $beerList, "name", "id", $keg->get_beerId(), ($keg->get_onTapId()?null:"Select One"));
							?>
                            </center>
						</td>						
						<td style="vertical-align:middle; font-size:1.2em;">
							<center><b><?php echo $kegType->get_name() ?></b></center>
						</td>
						<td style="vertical-align:middle; font-size:1.2em;">
							<center><b><?php echo $keg->get_make() ?></b></center>
						</td>
						
						<td style="vertical-align:middle; font-size:1.2em;">
							<center><b><?php echo $keg->get_model() ?></b></center>
						</td>
						<td class="rightborder thick" style="vertical-align:middle; font-size:1.2em;">
							<center>
                            	<button class="btn" name="editKeg" type="submit" value="<?php echo $keg->get_id()?>" >Edit</button>
                            </center>
                        </td>
					</tr>
					<tr class="intborder">
						<td class="leftborder">
						</td>		
						<td class="rightborder">
						</td>						
						<td colspan="4">
							<b>Stamped Owner / Location:</b> &nbsp; <?php echo $keg->get_stampedOwner() ?> / <?php echo $keg->get_stampedLoc() ?><br>
							<b>Serial Number:</b> &nbsp; <?php echo $keg->get_serial() ?> &nbsp; &nbsp; &nbsp; <b>Empty weight:</b> <?php echo $keg->get_weight() ?><br>
							<b>Notes:</b> &nbsp; <?php echo htmlentities($keg->get_notes()) ?>
						</td>
						<td class="rightborder thick" style="vertical-align:middle; font-size:1.2em;">
							<center>
								<button class="inactivateKeg btn" name="inactivateKeg" type="submit" value="<?php echo $keg->get_id()?>" >Delete</button>
							</center>
						</td>
					</tr>
		<?php 
				}
			}
		?>
				</tbody>
			</table>
			<input type="submit" class="btn" value="Save All" name="saveAll" />
			<input type="submit" class="btn" value="Add a Keg" onClick="window.location='keg_form.php'" />
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
include 'scripts.php';
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
