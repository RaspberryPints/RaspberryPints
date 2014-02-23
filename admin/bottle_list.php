<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
	header("location:index.php");
}

require_once __DIR__.'/includes/conn.php';
require_once __DIR__.'/../includes/config_names.php';
require_once __DIR__.'/includes/html_helper.php';
require_once __DIR__.'/includes/functions.php';

require_once __DIR__.'/includes/models/keg.php';
require_once __DIR__.'/includes/models/kegType.php';
require_once __DIR__.'/includes/models/kegStatus.php';

require_once __DIR__.'/includes/managers/bottle_manager.php';
require_once __DIR__.'/includes/managers/kegStatus_manager.php';
require_once __DIR__.'/includes/managers/bottleType_manager.php';

$htmlHelper = new HtmlHelper();
$BottleManager = new BottleManager();
$kegStatusManager = new KegStatusManager();
$bottleTypeManager = new BottleTypeManager();



if (isset($_POST['inactivateKeg'])) {
	$BottleManager->Inactivate($_POST['id']);		
}

$kegs = $BottleManager->GetAllActive();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>RaspberryPints</title>
<link href="styles/layout.css" rel="stylesheet" type="text/css" />
<link href="styles/wysiwyg.css" rel="stylesheet" type="text/css" />
	<!-- Theme Start -->
<link href="styles.css" rel="stylesheet" type="text/css" />
	<!-- Theme End -->
<link href='http://fonts.googleapis.com/css?family=Fredoka+One' rel='stylesheet' type='text/css'>
</head>
	<!-- Start Header  -->
<?php
include 'header.php';
?>
	<!-- End Header -->
		
	<!-- Top Breadcrumb Start -->
	<div id="breadcrumb">
		<ul>	
			<li><img src="img/icons/icon_breadcrumb.png" alt="Location" /></li>
			<li><strong>Location:</strong></li>
			<li class="current">Bottle List</li>            
		</ul>
	</div>
	<!-- Top Breadcrumb End --> 
	
	<!-- Right Side/Main Content Start -->
	<div id="rightside">
		<div class="contentcontainer lg left">
			<div class="headings alt">
				<h2>Bottle Set List</h2>
			</div>
			<br><br>
			<h3>Currently Serving:</h3>
			<br>
			<!-- Start On Tap Section -->
			
			<table width="800px" border="0" cellspacing="0" cellpadding="0" class="keglist outerborder">
				<thead class="intborder thick">
					<tr>
						<th width="5%"><center>Label</center></th>
						<th width="10%" colspan="2"><center>Status / Update</center></th>
						<th width="28%"><center>Bottle Type</center></th>
						<th width="28%"><center></center></th>
						<th width="29%"><center></center></th>
					</tr>
				</thead>

				<tbody>
					<?php 
						if( count($kegs) == 0 ){  
					?>
					<tr><td class="no-results" colspan="99">No bottle sets :(<br>Perhaps you should add one?</td></tr>
					<?php 
						}else{  
							foreach ($kegs as $keg){
								
								if( $keg->get_kegStatusCode() != null ){
									$kegStatus = $kegStatusManager->GetByCode($keg->get_kegStatusCode());
								}else{
									$kegStatus = new KegStatus();
								}
								
								if( $keg->get_bottleTypeId() != null ){
									$kegType = $bottleTypeManager->GetById($keg->get_bottleTypeId());
								}else{
									$kegType = new KegType();
								}
					?>
					<tr>
						<td rowspan="2" class="intborder">
							<center><span class="kegsquare"><?php echo $keg->get_label() ?></span></center>
						</td>
						
						<td colspan="2" class="leftborder rightborder" style="vertical-align:middle; font-size:1.2em;">
							<center><b><?php echo $kegStatus->get_name() ?></b></center>
						</td>
						
						<td style="vertical-align:middle; font-size:1.2em;">
							<center><b><?php echo $kegType->get_name() ?></b></center>
						</td>
						
						<td style="vertical-align:middle; font-size:1.2em;">
							<center><b></b></center>
						</td>
						
						<td class="rightborder thick"style="vertical-align:middle; font-size:1.2em;">
							<center><b></b></center>
						</td>
					</tr>
					<tr class="intborder">
						<td class="leftborder">
							<center><input name="editBottle" type="button" class="btn" value="Edit" onclick="window.location='bottle_form.php?id=<?php echo $keg->get_id()?>'" /></center>
						</td>
						
						<td class="rightborder">
							<center>
							<form method="POST">
								<input type='hidden' name='id' value='<?php echo $keg->get_id()?>'/>
								<input class="inactivateKeg btn" name="inactivateKeg" type="submit" value="Delete" />
							</form>
							</center>
						</td>
						<td colspan="3">
							<b>Notes:</b> &nbsp; <?php echo $keg->get_notes() ?>
						</td>
					</tr>
		<?php 
				}
			}
		?>
				</tbody>
			</table>
			
			<?php $htmlHelper->ShowMessage(); ?>
			<br/><br/>
			<input type="submit" class="btn" value="Add a Bottle Set" onclick="window.location='bottle_form.php'" />
				<!-- Start Footer -->   
<?php
include 'footer.php';
?>
	<!-- End Footer -->
		</div>
	</div>
	
	<!-- End On Tap Section -->


		
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
