<?php
require_once __DIR__.'/header.php';

$htmlHelper = new HtmlHelper();
$bottleManager = new BottleManager();
$bottleTypeManager = new BottleTypeManager();
$beerManager = new BeerManager();
//$srmManager = new SrmManager();

$beerList = $beerManager->GetAllActiveWithBatches();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Change the beerId value from beerId~beerBatchId~fg to just beerId
    if(isset($_POST['beerId'])){
        $beerExloded = explode("~", $_POST['beerId']);
        $_POST['beerId'] = $beerExloded[0];
        $_POST['beerBatchId'] = $beerExloded[1];
    }
  $bottle = new Bottle();
  $bottle->setFromArray($_POST);
  $bottleManager->Save($bottle);
	redirect('bottle_list.php');
}

if( isset($_GET['id'])){
	$bottle = $bottleManager->GetById($_GET['id']);
}else{
	$bottle = new Bottle();
}

$bottleTypeList = $bottleTypeManager->GetAll();
$colorList = $bottleManager->getCapColors();
?>
	<!-- End Header -->
		
	<!-- Top Breadcrumb Start -->
	<div id="breadcrumb">
		<ul>	
			<li><img src="img/icons/icon_breadcrumb.png" alt="Location" /></li>
			<li><strong>Location:</strong></li>
			<li><a href="bottle_list.php">Bottle List</a></li>
			<li>/</li>
			<li class="current">Bottle Form</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End --> 
	
	<!-- Right Side/Main Content Start -->
	<div id="rightside">
		<div class="contentcontainer med left">
	<p>
		Fields marked with <b><font color="red">*</font></b> are required.<br><br>

	<form id="bottle-form" method="POST">
		<input type="hidden" name="id" value="<?php echo $bottle->get_id() ?>" />
		
		<table style="width:800;border:0;cellspacing:1;cellpadding:0;">
			<tr>
				<td style="vertical-align:middle;">
					<b>Bottle type: <font color="red">*</font></b>
				</td>
				<td>
					<?php echo $htmlHelper->ToSelectList("bottleTypeId", "bottleTypeId", $bottleTypeList, "name", "id", $bottle->get_bottleTypeId(), "Select One"); ?>
				</td>
			</tr>
			<tr>
				<td>
					 <b>Beer Name: <font color="red">*</font></b>
				</td>
				<td>
					<?php 
					$str = "<select id='beerId' name='beerId' class=''>\n";
						$str .= "<option value=''>Select One</option>\n";
						foreach($beerList as $item){
						    if( !$item ) continue;
						    $sel = "";
						    if( isset($bottle) && $bottle->get_beerId() == ($item->get_beerBatchId()<=0?$item->get_id():$item->get_beerId()) && (($bottle->get_beerBatchId() <= 0 && $item->get_beerBatchId()<=0)  || $bottle->get_beerBatchId() == $item->get_beerBatchId()) )  $sel .= "selected ";
						    $desc = $item->get_displayName();
						    $str .= "<option value='".($item->get_beerBatchId()<=0?$item->get_id():$item->get_beerId())."~".$item->get_beerBatchId()."~".$item->get_fg()."~".$item->get_fgUnit()."' ".$sel.">".$desc."</option>\n";
						}
						$str .= "</select>\n";
						
						echo $str;
						
						//echo $htmlHelper->ToSelectList("beerId", "beerId", $beerList, "name", "id", $bottle->get_beerId(), "Select One"); 
					?>
				</td>
			</tr>
			<tr>
				<td style="vertical-align:middle;">
					<b>Cap RGBa: <font color="red">*</font></b>
				</td>
				<td>
                    <?php
					   	echo $htmlHelper->ToColorSelectList("capRgba", "capRgba", $colorList, "srm", "rgb", $bottle->get_capRgba(), "Select Color", "", "rgb"); 
					?>
				</td>
			</tr>
			<tr>
				<td style="vertical-align:middle;">
					<b>Cap Number: <font color="red">*</font></b>
				</td>
				<td>
					<input type="text" id="capNumber" class="mediumbox" name="capNumber" value="<?php echo $bottle->get_capNumber() ?>" />
				</td>
			</tr>
			<tr>
				<td style="vertical-align:middle;">
					<b>Start Amount</b> (bottles): <b><font color="red">*</font></b>
				</td>
				<td>
					<input type="text" id="startAmount" class="mediumbox" name="startAmount" value="<?php echo $bottle->get_startAmount() ?>" />
				</td>
			</tr>
			<tr>
				<td style="vertical-align:middle;">
					<b>Current Amount</b> (bottles): <b><font color="red">*</font></b>
				</td>
				<td>
					<input type="text" id="currentAmount" class="mediumbox" name="currentAmount" value="<?php echo $bottle->get_currentAmount() ?>" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input name="save" type="submit" class="btn" value="Save" />
					<input name="cancel" type="button" class="btn" value="Cancel" onclick="window.location='bottle_list.php'"/>
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


	<!-- End Js -->
	<!--[if IE 6]>
	<script type='text/javascript' src='scripts/png_fix.js'></script>
	<script type='text/javascript'>
	DD_belatedPNG.fix('img, .notifycount, .selected');
	</script>
	<![endif]--> 
	
<script>
	$(function() {
		
		$('#bottle-form').validate({
      rules: {
        bottleTypeId: { required: true },
        beerId: { required: true },
        capRgba: { required: true },
        capNumber: { required: true },
        startAmount: { required: true },
        currentAmount: { required: true }
      }
		});
		
	});
</script>

</body>
</html>
