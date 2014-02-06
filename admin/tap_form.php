<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
	header("location:index.php");
}
require_once __DIR__.'/includes/conn.php';
require_once __DIR__.'/../includes/config_names.php';
require_once __DIR__.'/includes/html_helper.php';
require_once __DIR__.'/includes/functions.php';

require_once __DIR__.'/includes/models/tap.php';
require_once __DIR__.'/includes/models/beer.php';
require_once __DIR__.'/includes/models/keg.php';
require_once __DIR__.'/includes/models/kegType.php';

require_once __DIR__.'/includes/managers/beer_manager.php';
require_once __DIR__.'/includes/managers/keg_manager.php';
require_once __DIR__.'/includes/managers/kegType_manager.php';
require_once __DIR__.'/includes/managers/tap_manager.php';

$htmlHelper = new HtmlHelper();
$tapManager = new TapManager();
$beerManager = new BeerManager();
$kegManager = new KegManager();
$kegTypeManager = new KegTypeManager();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if( isset($_POST['saveTap']) ){
		$tap = new Tap();
		$tap->setFromArray($_POST);
		$tapManager->Save($tap);
	}
	redirect('tap_list.php');
}


$beerList = $beerManager->GetAllActive();
$kegList = $kegManager->GetAllAvailable();

$tapNumber = $_GET['tapNumber'];
if( isset($_GET['id'])){
	$tap = $tapManager->GetById($_GET['id']);
	
	if( !array_key_exists($tap->get_kegId(), $kegList) ){
		$kegList[$tap->get_kegId()] = $kegManager->GetById($tap->get_kegId());
	}
	
}else{
	$tap = new Tap();
	$tap->set_tapNumber($tapNumber);
	$tap->set_active(true);
}

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
			<li><a href="tap_list.php">Tap List</a></li>
			<li>/</li>
			<li class="current">Tap Form</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End --> 
	
	<!-- Right Side/Main Content Start -->
	<div id="rightside">
		<div class="contentcontainer med left">
	<p>
		fields marked with an * are required

	<form id="tap-form" method="POST">
		<input type="hidden" name="id" value="<?php echo $tap->get_id() ?>" />
		<input type="hidden" name="tapNumber" value="<?php echo $tap->get_tapNumber() ?>" />
		<input type="hidden" name="active" value="<?php echo $tap->get_active() ?>" />
		
		<table width="950" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td>
					Beer*
				</td>
				<td>
					<?php echo $htmlHelper->ToSelectList("beerId", $beerList, "name", "id", $tap->get_beerId(), "Select One"); ?>
				</td>
			</tr>
			<tr>
				<td>
					SRM*
				</td>
				<td>
					<input type="text" id="srm" class="mediumbox" name="srm" value="<?php echo $tap->get_srm() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					IBU*
				</td>
				<td>
					<input type="text" id="ibu" class="mediumbox" name="ibu" value="<?php echo $tap->get_ibu() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					OG*
				</td>
				<td>
					<input type="text" id="og" class="mediumbox" name="og" value="<?php echo $tap->get_og() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					FG*
				</td>
				<td>
					<input type="text" id="fg" class="mediumbox" name="fg" value="<?php echo $tap->get_fg() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Keg*
				</td>
				<td>
					<?php echo $htmlHelper->ToSelectList("kegId", $kegList, "label", "id", $tap->get_kegId(), "Select One"); ?>
				</td>
			</tr>
			<tr>
				<td>
					Start Amount*
				</td>
				<td>
					<input type="text" id="startAmount" class="mediumbox" name="startAmount" value="<?php echo $tap->get_startAmount() ?>" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input name="saveTap" type="submit" class="btn" value="Save" />
					<input name="cancel" type="button" class="btn" value="Cancel" onclick="window.location='tap_list.php'"/>
				</td>
			</tr>
											
			</tbody>
		</table>
		<br />
		<div align="right">			
			&nbsp &nbsp 
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


	<!-- End Js -->
	<!--[if IE 6]>
	<script type='text/javascript' src='scripts/png_fix.js'></script>
	<script type='text/javascript'>
	DD_belatedPNG.fix('img, .notifycount, .selected');
	</script>
	<![endif]--> 
	
<script>
	$(function() {
		var beerList = { 
			<?php foreach($beerList as $beerItem){ 
				echo $beerItem->get_id() . ": " . $beerItem->toJson() . ", "; 
			} ?>
		};
		
		var kegList = { 
			<?php foreach($kegList as $keg){ 
				echo $keg->get_id() . ": { " . 
					"maxAmount: '" . $kegTypeManager->GetById($keg->get_kegTypeId())->get_maxAmount() , "'" .
				"}, "; 
			} ?>
		};
		
		$('#tap-form')	
			.on('change', '#beerId', function(){
				var $this = $(this);
				
				if( $this.val() ){
					var $form = $('#tap-form'),
						beer = beerList[$this.val()];
						
					$form
						.find('#srm').val(beer['srm']).end()
						.find('#ibu').val(beer['ibu']).end()
						.find('#og').val(beer['og']).end()
						.find('#fg').val(beer['fg']).end();
				}
			})
			.on('change', '#kegId', function(){
				var $this = $(this);
				
				if( $this.val() ){
					var $form = $('#tap-form'),
						keg = kegList[$this.val()];
						
					$form
						.find('#startAmount').val(keg['maxAmount']).end();
				}
			});
		
		$('#tap-form').validate({
		rules: {
			beerId: { required: true },
			srm: { required: true, number: true },
			ibu: { required: true, number: true },
			og: { required: true, number: true },
			fg: { required: true, number: true },
			kegId: { required: true },
			startAmount: { required: true, number: true }
		}
		});
		
	});
</script>

</body>
</html>
