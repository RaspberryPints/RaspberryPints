<?php
require_once __DIR__.'/header.php';

$htmlHelper = new HtmlHelper();
$tapManager = new TapManager();
$beerManager = new BeerManager();
$kegManager = new KegManager();
$kegTypeManager = new KegTypeManager();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if( isset($_POST['saveTap']) ){
		$tap = $tapManager->GetById($_POST['tapId']);
		$arr = explode("~", $_POST['kegId']);
		if(isset($arr[0]))
		{ 
			$kegId = $arr[0];
		}
		$tap->set_kegId($kegId);
		$tap->set_startAmount($_POST['startAmount']);
		$tap->set_currentAmount($_POST['currentAmount']);
		$tapManager->Save($tap);
		//if(!isset($keg) || $keg == null) echo 'No Keg Found for id '.$kegId;
		$keg = $kegManager->getById($kegId);
		$keg->set_onTapId($tap->get_id());
		if( (isset($arr[1]) && $arr[1] != "") ||
		    (isset($arr[2]) && $arr[2] != "") )
		{
			$keg->set_beerId( $_POST['beerId']);
		}
		$kegManager->Save($keg);
		
		file_get_contents('http://' . $_SERVER['SERVER_NAME'] . '/admin/trigger.php?value=config');
	}
	redirect('tap_list.php');
}


$beerList = $beerManager->GetAllActive();
$kegList = $kegManager->GetAllActive();

$tapId = $_GET['tapId'];
if( isset($tapId) ){
	$tap = $tapManager->GetById($tapId);
	
	if( !array_key_exists($tap->get_kegId(), $kegList) ){
		$kegList[$tap->get_kegId()] = $kegManager->GetById($tap->get_kegId());
	}
	
}else{
	$tap = new Tap();
	$tap->set_id($tapId);
	$tap->set_active(true);
}

// Code to set config values
$config = getAllConfigs();

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
		Fields marked with <b><font color="red">*</font></b> are required.<br><br>
	
    <div id="messageDiv" class="error status" style="display:none;"><span id="messageSpan"></span></div>
	<form id="tap-form" method="POST">
		<input type="hidden" name="tapId" value="<?php echo $tap->get_id() ?>" />
		<input type="hidden" name="active" value="<?php echo $tap->get_active() ?>" />
		
		<table style="width:800;border:0;cellspacing:1;cellpadding:0;">
			<tr>
				<td width="25%" style="vertical-align:middle;">
					<b>Keg Number: <font color="red">*</font></b>
				</td>
				<td>
					<?php 					
						$str = "<select id='kegId' name='kegId' class='' onChange='toggleDisplay(this, \"BeerListRow\", \"beerId\")'>\n";
						$str .= "<option value=''>Select One</option>\n";
						foreach($kegList as $item){
							if( !$item ) continue;
							$sel = "";
							if( $tap && $tap->get_kegId() == $item->get_id() ) $sel .= "selected ";
							$desc = $item->get_id();
							if($item->get_label() && $item->get_label() != "" && $item->get_label() != $item->get_id())$desc.="-".$item->get_label();
							$str .= "<option value='".$item->get_id()."~".$item->get_beerId()."~".$item->get_ontapId()."' ".$sel.">".$desc."</option>\n";
						}					
						$str .= "</select>\n";
												
						echo $str;
					?>
				</td>
			</tr>
			<?php 
                $selectedBeer = "";
                if($tap->get_kegId() && array_key_exists($tap->get_kegId(), $kegList))$selectedBeer = $kegList[$tap->get_kegId()]->get_beerId();
			?>
			<tr id="BeerListRow" <?php if($selectedBeer == ""){?>style="display:none;"<?php } ?>>
			
				<td width="25%" style="vertical-align:middle;">
					<b>Beer Name: <font color="red">*</font></b>
				</td>
				<td>
					<?php 
						echo $htmlHelper->ToSelectList("beerId", $beerList, "name", "id", $selectedBeer, "Select One"); 
					?>
				</td>
			</tr>
			<tr>
				<td width="25%" style="vertical-align:middle;">
					<b>Start Amount</b> (gal): <b><font color="red">*</font></b>
				</td>
				<td>
					<input type="text" id="startAmount" class="mediumbox" name="startAmount" value="<?php echo $tap->get_startAmount() ?>" />
				</td>
			</tr>
			<tr>
				<td width="25%" style="vertical-align:middle;">
					<b>Current Amount</b> (gal): <b><font color="red">*</font></b>
				</td>
				<td>
					<input type="text" id="currentAmount" class="mediumbox" name="currentAmount" value="<?php echo $tap->get_currentAmount() ?>" />
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


	<!-- End Js -->
	<!--[if IE 6]>
	<script type='text/javascript' src='scripts/png_fix.js'></script>
	<script type='text/javascript'>
	DD_belatedPNG.fix('img, .notifycount, .selected');
	</script>
	<![endif]--> 
	
<script>
	$(function() {
		
		
		$('#tap-form').validate({
		rules: {
			kegId: { required: true },
			startAmount: { required: true, number: false },
			currentAmount: { required: true, number: false }
		}
		});
		
	});
	
	function toggleDisplay(selectObject, divId, secSelectId) {
		var x = document.getElementById(divId);
		var msgDiv = document.getElementById("messageDiv");
		if(msgDiv != null) msgDiv.style.display = "none"
		var display = true;
		var arr = selectObject.value.split("~");
		var beerId = null;
		if(arr.length > 1 && arr[1] != "")
		{
			beerId = arr[1];
		}
		else
		{
			var secSelect = document.getElementById(secSelectId);
			secSelect.selectedIndex = 0;
		}
		if(arr.length > 2 && arr[2] != "") 
		{
			if(msgDiv != null)msgDiv.style.display = "";
			var msgSpan = document.getElementById("messageSpan");
			if(msgSpan != null) msgDiv.innerHTML = "Keg currently on Tap "+arr[2]+" and will be moved to tap <?php echo $tap->get_id()?> and update to contain selected beer"
		}
		if (display) {
			x.style.display = "";
		} else {
			x.style.display = "none";
		}
		if(beerId != null)
		{
			var secSelect = document.getElementById(secSelectId);
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
</script>

</body>
</html>
