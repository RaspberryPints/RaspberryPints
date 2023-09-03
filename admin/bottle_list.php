<?php
require_once __DIR__.'/header.php';

$htmlHelper = new HtmlHelper();
$bottleManager = new BottleManager();
$bottleTypeManager = new BottleTypeManager();
$beerManager = new BeerManager();
//$srmManager = new SrmManager();

$activeBottleIds = $bottleManager->GetAllActiveIds();
if (isset ( $_POST ['saveBottles'] ) ) {
	$error = false;
	foreach($activeBottleIds as $id){
	    if(!isset($_POST ['id']) || !in_array($id, $_POST ['id'])){
			if(!$bottleManager->Inactivate($id))$error = true;	
		}
	}
	$ii = 0;
	while(isset($_POST ['capNumber'][$ii]))
	{
	    $newBottle = false;
		if(isset($_POST ['id'][$ii]) && $_POST ['id'][$ii] != "")
		{
			$id = $_POST ['id'][$ii];
			$bottle = $bottleManager->GetById($id);		
		}else{
		    $bottle = new Bottle();
		    $newBottle = true;
		}
		$bottle->set_capNumber($_POST['capNumber'][$ii]);
		$bottle->set_capRgba($_POST['capRgba'][$ii]);
		$bottle->set_bottleTypeId($_POST['bottleTypeId'][$ii]);
		$bottle->set_beerId($_POST['beerId'][$ii]);
		$bottle->set_startAmount($_POST['startAmount'][$ii]);
		$bottle->set_currentAmount($_POST['currentAmount'][$ii]);
		if(!$newBottle || ($newBottle && $bottle->get_capNumber() != ''))if(!$bottleManager->save ($bottle))$error = true;
		$ii++;
	}
	if(!$error){
		$_SESSION['successMessage'] = "Success";
	}else{
		$_SESSION['successMessage'] = "Changes Could Not Be Saved";	
	}
} 

$bottleTypeList = $bottleTypeManager->GetAll();
$beerList = $beerManager->GetAllActive();
$colorList = $bottleManager->getCapColors();
$activeBottles = $bottleManager->GetAllActive();
$numberOfBottles = count($activeBottles);
?>
<body>
	<!-- Start Header  -->
<?php include 'top_menu.php'; ?>
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
		<div class="contentcontainer left">
            <div class="headings alt">
                <h2>Bottles</h2>
            </div>
            <div class="contentbox">
            <?php $htmlHelper->ShowMessage(); ?>
            <p>
            <input type="button" id="newRow1" name="newRow1" class="btn" value="Add a Bottle" />
            <br>
            <?php
                if($numberOfBottles == 0){
                    $activeBottles[] = new Bottle();
            ?>
            <br>
            <strong>No Active Bottles Found</strong>
            <br>
            <?php } ?>
                
            </p>
	<!-- Start Bottle Section -->
	
			<form method="POST" id="bottle-form">
				<table style="width:800px" id="tableList">
					<thead>
						<tr>
							<th>Cap<br/>Number</th>
							<th>Cap<br/>Color</th>
							<th>Type</th>
							<th>Beer</th>
							<th>Start Number</th>
							<th>Current Number</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
            <?php foreach ($activeBottles as $bottle) { ?>
                            <tr>
                                <td>
            						<input type="hidden" name="id[]" value="<?php echo $bottle->get_id()?>" />
									<input type="text" id="capNumber" class="smallbox" name="capNumber[]" value="<?php if($bottle->get_capNumber() > 0)echo $bottle->get_capNumber() ?>" />
								</td>	
                                <td>
									<?php
                                        echo $htmlHelper->ToColorSelectList("capRgba[]", "capRgba", $colorList, "srm", "rgb", $bottle->get_capRgba(), "Select Color", "", "rgb"); 
                                    ?>
                                </td>  										
                            	<td>
									<?php echo $htmlHelper->ToSelectList("bottleTypeId[]", "bottleTypeId", $bottleTypeList, "name", "id", $bottle->get_bottleTypeId(), "Select One"); ?>	
                                </td>									
                            	<td>
									<?php echo $htmlHelper->ToSelectList("beerId[]", "beerId", $beerList, "name", "id", $bottle->get_beerId(), "Select One"); ?>	
                                </td>
                                <td>
									<input type="text" id="startAmount" class="smallbox" name="startAmount[]" value="<?php echo $bottle->get_startAmount() ?>" />
                                </td>                                
                                <td>
									<input type="text" id="currentAmount" class="smallbox" name="currentAmount[]" value="<?php echo $bottle->get_currentAmount() ?>" />
                                </td>                                                             
                                <td>
                                   	<button name="delete" type="button" class="btn" style="white-space:nowrap" value="<?php echo $bottle->get_id()?>" onClick="removeRow(this)">Remove Bottle</button>
                                </td>                                
                            </tr>
                    	<?php } ?>				
					</tbody>
				</table>
				<br />
				<div align="right">			
					&nbsp; &nbsp;
				</div>
			    <table>
                	<tr>
                		<td><input type="submit" name="saveBottles" class="btn" value="Save" /></td>
                		<td id="pendingChangesDiv" style="display:none"><strong>Pending Changes</strong></td>
                    </tr>
                </table>
			</form>
    <p>
    <br>
    <input type="button" id="newRow2" name="newRow2" class="btn" value="Add a Bottle" />
    </p>
    <!-- End Tap Number Form -->
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

	<script>
		var rowStructure = $('#tableList').find('tr:eq(1)').clone();
		rowStructure.find('input, select').each(function(){this.value="";});
		rowStructure.find('select').each(function(){this.value=-1; this.style.backgroundColor=""});
		$("[name^='newRow']").click(function(){addRow();});
		function addRow(){		
			var $table = $('#tableList')
			$table.append(rowStructure.clone());
			if($("#pendingChangesDiv")[0] != null)$("#pendingChangesDiv")[0].style.display="";
		}
		function removeRow(btn){		
			$(btn).closest('tr').remove();
			if($("#pendingChangesDiv")[0] != null)$("#pendingChangesDiv")[0].style.display="";
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
