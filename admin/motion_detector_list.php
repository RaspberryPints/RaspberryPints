<?php
require_once __DIR__.'/header.php';
$htmlHelper = new HtmlHelper();
$mdManager = new MotionDetectorManager();

$config = getAllConfigs();

$reconfig = false;
$activeReadersIds = $mdManager->GetAllActiveIDs();
if (isset ( $_POST ['save'] )) {
	$error = false;
	foreach($activeReadersIds as $id){
		if(!isset($_POST ['id']) || !in_array($id, $_POST ['id'])){
		    if(!$mdManager->Inactivate($id))$error=true;
		    $reconfig = true;
		}
	}
	$ii = 0;
	while(isset($_POST ['name'][$ii]))
	{
	    $newReader = false;
	    if(isset($_POST ['id'][$ii]) && $_POST ['id'][$ii] != "")
	    {
	        $id = $_POST ['id'][$ii];
	        $reader = $mdManager->GetById($id);
	    }else{
	        $reader = new MotionDetector();
	        $newReader = true;
	    }
	    $reader->set_name($_POST['name'][$ii]);
	    $reader->set_type($_POST['type'][$ii]);
	    $reader->set_pin($_POST['pin'][$ii]);
	    $reader->set_priority($_POST['priority'][$ii]);
	    $reader->set_ledPin($_POST['ledPin'][$ii]);
	    $reader->set_soundFile($_POST['soundFile'][$ii]);
	    $reader->set_mqttCommand($_POST['mqttCommand'][$ii]);
	    $reader->set_mqttEvent($_POST['mqttEvent'][$ii]);
	    $reader->set_mqttUser($_POST['mqttUser'][$ii]);
	    $reader->set_mqttPass($_POST['mqttPass'][$ii]);
	    $reader->set_mqttHost($_POST['mqttHost'][$ii]);
	    $reader->set_mqttPort($_POST['mqttPort'][$ii]);
	    $reader->set_mqttInterval($_POST['mqttInterval'][$ii]);
	    if(!$newReader || ($newReader && $reader->get_name() != '')) if(!$mdManager->save($reader))$error=true;
	    $ii++;
	    $reconfig = true;
	}
	if(!$error){
		$_SESSION['successMessage'] = "Success";
	}else{
		$_SESSION['successMessage'] = "Changes Could Not Be Saved";	
	}
	if($error)$reconfig = false;
} 

if (isset ( $_POST ['saveSettings'] ) || isset ( $_POST ['configuration'] )) {
    setConfigurationsFromArray($_POST, $config);
    if (isset ( $_POST ['saveSettings'] ) )$reconfig = true;
}
if($reconfig){
    triggerPythonAction();
}
$readers = $mdManager->GetAllActive();
$numberOfReaders=count($readers);
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
			<li class="current">Motion Detectors</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End -->

	<!-- Right Side/Main Content Start -->
<div id="rightside">
	<div class="contentcontainer left">
		<div class="headings alt">
			<h2>Motion Detectors</h2>
		</div>
			
		<div class="contentbox">
			<?php $htmlHelper->ShowMessage(); ?>
   			 <input type="button" id="newRow1" name="newRow2" class="btn" value="Add Motion Detector" />
			<br>
            <?php
                if($numberOfReaders == 0){
                    $readers[] = new MotionDetector();
            ?>
            <br>
            <strong>No Active Motion Detectors Found</strong>
            <br>
            <?php } ?>

			<form method="POST" id="readers-form">
                <table style="width:800px" id="tableList">
                	<thead>
                        <tr>
                            <th style="width:15%; vertical-align: middle;">Name</th>
                            <!--<th style="width:5%; vertical-align: middle;">Type</th>-->
                            <th style="width:5%; vertical-align: middle;">Pi Pin</th>
                            <th style="width:5%; vertical-align: middle;">Priority</th>
                            <th style="width:5%; vertical-align: middle;">LED Pin</th>
                            <th style="width:10%; vertical-align: middle;">Sound File</th>
                            <th style="width:10%; vertical-align: middle;">MQTT<br/>Command</th>
                            <th style="width:10%; vertical-align: middle;">MQTT<br/>Event</th>
                            <th style="width:5%; vertical-align: middle;">MQTT<br/>User</th>
                            <th style="width:5%; vertical-align: middle;">MQTT<br/>Password</th>
                            <th style="width:10%; vertical-align: middle;">MQTT<br/>Host</th>
                            <th style="width:5%; vertical-align: middle;">MQTT<br/>Port</th>
                            <th style="width:5%; vertical-align: middle;">MQTT<br/>Interval</th>
                            <th style="width:5%; vertical-align: middle;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if( count($readers) == 0 ){
                        ?>
                                <tr><td class="no-results" colspan="99">No Motion Detectors :( Add some?</td></tr>
                        <?php
                            }
                            foreach ($readers as $reader){
                        ?>
                                <tr>
                                    <td style="width:15%; vertical-align: middle;">
            							<input type="hidden" name="id[]" value="<?php echo $reader->get_id()?>" />
                                        <input type="text" id="name" class="largebox" name="name[]" value="<?php echo $reader->get_name() ?>" />
            							<input type="hidden" name="type[]" value="0" />
                                    </td>
                                    <?php if(false) {?>
                                    <td style="width:5%;vertical-align: middle;">
                                    	<select id="<?php echo $reader->get_id() ?>" name='type[]' class=''>
                                        	<option value='0'>PIR</option>
<!--                                         	<option value='1'>????</option> --><!-- Not Implemented -->
                                        </select>
                                    </td>
                                    <?php }?>
                                    <td style="width:5%; vertical-align: middle;">
                                        <input type="text" id="pin" class="smallbox" name="pin[]" value="<?php echo $reader->get_pin() ?>" />
                                    </td>
                                    <td style="width:5%; vertical-align: middle;">
                                        <input type="text" id="priority" class="smallbox" name="priority[]" value="<?php echo $reader->get_priority() ?>" />
                                    </td>
                                    <td style="width:5%; vertical-align: middle;">
                                        <input type="text" id="ledPin" class="smallbox" name="ledPin[]" value="<?php echo $reader->get_ledPin() ?>" />
                                    </td>
                                    <td style="width:10%; vertical-align: middle;">
                                        <input type="text" id="soundFile" class="smallbox" name="soundFile[]" value="<?php echo $reader->get_soundFile() ?>" />
                                    </td>
                                    <td style="width:10%; vertical-align: middle;">
                                        <input type="text" id="mqttCommand" class="smallbox" name="mqttCommand[]" value="<?php echo $reader->get_mqttCommand() ?>" />
                                    </td>
                                    <td style="width:10%; vertical-align: middle;">
                                        <input type="text" id="mqttEvent" class="smallbox" name="mqttEvent[]" value="<?php echo $reader->get_mqttEvent() ?>" />
                                    </td>
                                    <td style="width:5%; vertical-align: middle;">
                                        <input type="text" id="mqttUser" class="smallbox" name="mqttUser[]" value="<?php echo $reader->get_mqttUser() ?>" />
                                    </td>
                                    <td style="width:5%; vertical-align: middle;">
                                        <input type="text" id="mqttPass" class="smallbox" name="mqttPass[]" value="<?php echo $reader->get_mqttPass() ?>" />
                                    </td>
                                    <td style="width:10%; vertical-align: middle;">
                                        <input type="text" id="mqttHost" class="smallbox" name="mqttHost[]" value="<?php echo $reader->get_mqttHost() ?>" />
                                    </td>
                                    <td style="width:5%; vertical-align: middle;">
                                        <input type="text" id="mqttPort" class="smallbox" name="mqttPort[]" value="<?php echo $reader->get_mqttPort() ?>" />
                                    </td>
                                    <td style="width:5%; vertical-align: middle;">
                                        <input type="text" id="mqttInterval" class="smallbox" name="mqttInterval[]" value="<?php echo $reader->get_mqttInterval() ?>" />
                                    </td>
                                    <td style="width:5%;vertical-align: middle;">
                                        <button name="delete" type="button" class="btn" style="white-space:nowrap" value="<?php echo $reader->get_id()?>" onClick="removeRow(this)">Delete</button>
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
   			 <input type="button" id="newRow2" name="newRow2" class="btn" value="Add Motion Detector" />
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
include 'scripts.php';
?>
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

		function toggleSettings(callingAnchor, settingsDiv) {
			var div = document.getElementById(settingsDiv);
			if(div != null){
				if(div.style.display == ""){
					div.style.display = "none";
					callingAnchor.style.background = "url(img/bg_navigation.png) no-repeat top;";				
				}else{
					div.style.display = "";
					callingAnchor.style.background = "url(img/bg_navigation.png) 0 -76px;";				
				}
				if(document.getElementById("settingsExpanded")!= null)document.getElementById("settingsExpanded").value = div.style.display;
			}
		}


		$(function() {		
			$('#readers-form').validate({
			rules: {		
				<?php 
				$comma = "";
				foreach ($readers as $reader){
				    if(null == $readers)continue; 
				?>
					<?php echo $comma; ?>type<?php echo $reader->get_id(); ?>: { required: true }
					<?php $comma = ","; ?>
					<?php echo $comma; ?>pin<?php echo $reader->get_id(); ?>: { required: true, number: true }
					<?php echo $comma; ?>priority<?php echo $reader->get_id(); ?>: { required: true, number: true }
			     <?php } ?> 
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
