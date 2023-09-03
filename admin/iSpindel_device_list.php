<?php
require_once __DIR__.'/header.php';
$htmlHelper=new HtmlHelper();
$iSpindelDeviceManager=new iSpindelDeviceManager();

$activeiSpindelDevicesIds=$iSpindelDeviceManager->GetAllActiveIDs();
$config=getAllConfigs();

if (isset($_POST['inactivateiSpindel'])) {
    $iSpindelDeviceManager->Inactivate($_POST['inactivateiSpindel']);
}
else if (isset($_POST['editiSpindel'])) {
    $id = $_POST ['editiSpindel'];
    $ii = 0;
    while(isset($_POST ['id'][$ii]))
    {
        if($_POST ['id'][$ii]==$id)break;
        $ii++;
    }
    //save any changes made to this device so far
    if(isset($_POST['id'][$ii]))
    {
        $iSpindelDevice = $iSpindelDeviceManager->GetById($id);
        $beerExloded = explode("~", $_POST['beerId'][$ii]);
        $selectedBeerId = $beerExloded[0];
        $selectedBatchId = $beerExloded[1];
        if($iSpindelDevice){
            if($iSpindelDevice->get_beerId() != $selectedBeerId ||
                $iSpindelDevice->get_beerBatchId() != $selectedBatchId){
                $iSpindelDevice->set_beerId($selectedBeerId);
                $iSpindelDevice->set_beerBatchId($selectedBatchId);
                $iSpindelDeviceManager->save($iSpindelDevice);
            }
        }
    }
    redirect("iSpindel_device_form.php?id=$id");
}
else if (isset ( $_POST ['save'] )) {
    $error=false;
    foreach($activeiSpindelDevicesIds as $id){
        if(!isset($_POST ['id']) || !in_array($id, $_POST ['id'])){
            if(!$iSpindelDeviceManager->Inactivate($id))$error=true;
        }
    }
    $ii=0;
    while(isset($_POST ['id'][$ii]))
    {
        $newiSpindelDevice=false;
        if(isset($_POST ['id'][$ii]) && $_POST ['id'][$ii] != "")
        {
            $id=$_POST ['id'][$ii];
            $iSpindelDevice=$iSpindelDeviceManager->GetById($id);
        }else{
            $iSpindelDevice=new iSpindelDevice();
            $newiSpindelDevice=true;
        }
        if($_POST['beerId'][$ii] && $_POST['beerId'][$ii] != ''){
            $beerExloded = explode("~", $_POST['beerId'][$ii]);
            $selectedBeerId = $beerExloded[0];
            $selectedBatchId = $beerExloded[1];
            $iSpindelDevice->set_beerId($selectedBeerId);
            $iSpindelDevice->set_beerBatchId($selectedBatchId);
            if(!$newiSpindelDevice || ($newiSpindelDevice && $iSpindelDevice->get_name() != '')) if(!$iSpindelDeviceManager->save($iSpindelDevice))$error=true;
        }
        $ii++;
    }
    if(!$error){
        $_SESSION['successMessage']="Success";
    }else{
        $_SESSION['successMessage']="Changes Could Not Be Saved";
    }
}

$iSpindelDevices=$iSpindelDeviceManager->GetAllActive();
$numberOfReaders=count($iSpindelDevices);

$beerList=(new BeerManager())->GetAllActiveWithBatches();
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
			<li class="current">iSpindel Devices</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End -->

	<!-- Right Side/Main Content Start -->
<div id="rightside">
	<div class="contentcontainer left">
		<div class="headings alt">
			<h2>iSpindel Devices</h2>
		</div>
		<div class="contentbox">
			<?php $htmlHelper->ShowMessage(); ?>
			
   			<!--  <input type="button" id="newRow1" name="newRow2" class="btn" value="Add Reader" />
			<br> -->
            <?php
                if($numberOfReaders == 0){
            ?>
            <br>
            <strong>No Active iSpindel Devices Found</strong>
            <br>
            Configure a <a href="iSpindel_connector_list.php">connector</a> to listen on your RPints Pi and point your iSpindel to the IP/Port configured. 
            <?php } ?>

			<form method="POST" id="iSpindelDevices-form">
                <table style="width:800px" id="tableList">
                	<thead>
                        <tr>
                            <th style="width:15%; vertical-align: middle; text-align: center;">ID</th>
                            <th style="width:75%; vertical-align: middle; text-align: center;">Name</th>
                            <th style="width:75%; vertical-align: middle; text-align: center;">Beer</th>
                            <th style="width:75%; vertical-align: middle; text-align: center;">Current<br/>Temperature</th>
                            <th style="width:75%; vertical-align: middle; text-align: center;">Current<br/>Gravity</th>
                            <th style="width:75%; vertical-align: middle; text-align: center;"></th>
                            <th style="width:75%; vertical-align: middle; text-align: center;"></th>
                            <th style="width:5%; vertical-align: middle; text-align: center;"></th>
                            <th style="width:5%; vertical-align: middle; text-align: center;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($iSpindelDevices as $iSpindelDevice){
                        ?>
                        <tr> 
                            <td style="vertical-align: middle;">
    							<input type="hidden" name="id[]" value="<?php echo $iSpindelDevice->get_id()?>" />
								<input type="number" disabled class="mediumbox" name="id<?php echo $iSpindelDevice->get_id(); ?>" value="<?php echo $iSpindelDevice->get_id(); ?>" />
                            </td>  
                            <td style="vertical-align: middle;">
								<input type="text" disabled class="mediumbox" name="name<?php echo $iSpindelDevice->get_id(); ?>" value="<?php echo $iSpindelDevice->get_name(); ?>" />
                            </td>  
                            <td style="">	
							<?php 
    							$str = "<select id='beerId' name='beerId[]' class=''>\n";
    							$str .= "<option value=''>Select One</option>\n";
    							foreach($beerList as $item){
    							    if( !$item ) continue;
    							    $sel = "";
    							    if( isset($iSpindelDevice) && $iSpindelDevice->get_beerId() == ($item->get_beerBatchId()<=0?$item->get_id():$item->get_beerId()) && (($iSpindelDevice->get_beerBatchId() <= 0 && $item->get_beerBatchId()<=0) || $iSpindelDevice->get_beerBatchId() == $item->get_beerBatchId()) )  $sel .= "selected ";
    							    $desc = $item->get_displayName();
    							    $str .= "<option value='".($item->get_beerBatchId()<=0?$item->get_id():$item->get_beerId())."~".$item->get_beerBatchId()."~".$item->get_fg()."~".$item->get_fgUnit()."' ".$sel.">".$desc."</option>\n";
    							}
    							$str .= "</select>\n";
    							
    							echo $str;
    							//echo $htmlHelper->ToSelectList("beerId[]", "beerId", $beerList, "name", "id", $fermenter->get_beerId(), "Select One");
							?>
                            </td>   
                            <td style="vertical-align: middle;">
								<input type="text" disabled class="smallbox" name="name<?php echo $iSpindelDevice->get_id(); ?>" value="<?php echo convert_temperature($iSpindelDevice->get_currentTemperature(), $iSpindelDevice->get_currentTemperatureUnit(), $config[ConfigNames::DisplayUnitTemperature]); ?>" />
                            </td>  
                            <td style="vertical-align: middle;">
								<input type="text" disabled class="smallbox" name="name<?php echo $iSpindelDevice->get_id(); ?>" value="<?php echo convert_gravity($iSpindelDevice->get_currentGravity(),$iSpindelDevice->get_currentGravityUnit(), $config[ConfigNames::DisplayUnitGravity]); ?>" />
                            </td>   
                        
    						<td style="vertical-align:middle; align-content:center; font-size:1.2em">
    							<a target="blank" href="iSpindel_log.php?device=<?php echo $iSpindelDevice->get_name()?>" >Graph </a>
                            </td>
    						<td style="vertical-align:middle; align-content:center; font-size:1.2em">
    							<?php if($iSpindelDevice->get_beerId()){?><a target="blank" href="iSpindel_log.php?device=<?php echo $iSpindelDevice->get_name()?>&amp;beerId=<?php echo $iSpindelDevice->get_beerId()?>" >Graph Beer</a><?php }?>
                            </td>
    						<td style="vertical-align:middle; align-content:center; font-size:1.2em">
    							<button class="btn" name="editiSpindel" type="submit" value="<?php echo $iSpindelDevice->get_id()?>" >Edit</button>
                            </td>    
    						<td style="vertical-align:middle; align-content:center; font-size:1.2em; ">
    							<button class="btn" name="inactivateiSpindel" type="submit" value="<?php echo $iSpindelDevice->get_id()?>" >Delete</button>
    						</td>
						</tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
                <table>
                    <tr>
                        <td><input type="submit" name="save" class="btn" value="Save" /></td>
                        <td id="pendingChangesDiv" style="display:none"><strong>Pending Changes</strong></td>
                    </tr>
                </table>
            </form>
<!--    			 <input type="button" id="newRow2" name="newRow2" class="btn" value="Add Reader" />-->		
		</div>
	</div>
	<!-- Start Footer -->
	<?php
	include 'footer.php';
	?>
	<!-- End Footer -->
</div>
	<!-- End On Tap Section -->
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
		var rowStructure=$('#tableList').find('tr:eq(1)').clone();
		rowStructure.find('input, select').each(function(){this.value="";});
		rowStructure.find('select').each(function(){this.value=-1; this.style.backgroundColor=""});
		$("[name^='newRow']").click(function(){addRow();});
		function addRow(){		
			var $table=$('#tableList')
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
