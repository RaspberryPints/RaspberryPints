<?php
require_once __DIR__.'/header.php';
$htmlHelper = new HtmlHelper();
$tempProbeManager = new TempProbeManager();

$config = getAllConfigs();

$reconfig = false;
$activeProbesIds = $tempProbeManager->GetAllActiveIDs();
if (isset ( $_POST ['save'] )) {
	$error = false;
	foreach($activeProbesIds as $id){
		if(!isset($_POST ['id']) || !in_array($id, $_POST ['id'])){
		    if(!$tempProbeManager->Inactivate($id))$error=true;
		}
	}
	$ii = 0;
	while(isset($_POST ['name'][$ii]))
	{
	    $newProbe = false;
	    if(isset($_POST ['id'][$ii]) && $_POST ['id'][$ii] != "")
	    {
	        $id = $_POST ['id'][$ii];
	        $probe = $tempProbeManager->GetById($id);
	    }else{
	        $probe = new TempProbe();
	        $newProbe = true;
	    }
	    $probe->set_type($_POST['type'][$ii]);
	    $probe->set_pin($_POST['pin'][$ii]);
	    $probe->set_manualAdj($_POST['Adjustment'][$ii]);
	    $probe->set_notes($_POST['notes'][$ii]);
	    $probe->set_active(1);
	    if(!$newProbe || ($newProbe && $probe->get_name() != '')) if(!$tempProbeManager->save($probe))$error=true;
	    $ii++;
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
    $reconfig = true;
}
if($reconfig){
    file_get_contents ( 'http://' . $_SERVER ['SERVER_NAME'] . '/admin/trigger.php?value=tempProbe' );
}
$probes = $tempProbeManager->GetAllActive();
$numberOfReaders=count($probes);
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
			<li class="current">Temperature Probes</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End -->

	<!-- Right Side/Main Content Start -->
<div id="rightside">
	<div class="contentcontainer left">
		<div class="headings alt">
			<h2>Temperature Probes</h2>
		</div>
		<div class="contentbox">
			<?php $htmlHelper->ShowMessage(); ?>
			
            <a style="color:#FFF" onClick="toggleSettings(this, 'settingsDiv')" class="collapsed heading">Settings</a>
    		
    	<!-- Start Tap Config Form -->
    		<div id="settingsDiv" style="<?php echo (isset($_POST['settingsExpanded'])?$_POST['settingsExpanded']:'display:none'); ?>">
            
            <form id="configuration" method="post">
            	<input type="hidden" name="configuration" id="configuration" />
            	<input type="hidden" name="settingsExpanded" id="settingsExpanded" value="<?php echo (isset($_POST['settingsExpanded'])?$_POST['settingsExpanded']:'display:none'); ?>" />
                <table class="contentbox" style="width:100%; border:0;" >
                	<tr>
    			<?php
    			    $row = getConfig(ConfigNames::UseTempProbes);
					echo '<td>';
					echo '	<input type="hidden" name="' . $row['configName'] . '" value="0"/>';
					echo '	<input type="checkbox" ' . ($row['configValue']?'checked':'') . ' name="' . $row['configName'] . '" value="1" onClick="this.form.submit()">'.$row['displayName']."&nbsp;\n";
					echo '</td>';
    			?>     
                	</tr>
                	<tr>
    						<td><b>Temperature Probes:</b></td>
    						<td><b>Check Delay:</b><br/>The seconds between the checking temperature probes</td>
    						<td><input type="text" name="tempProbeDelay" class="smallbox" value="<?php echo ($config[ConfigNames::TempProbeDelay]) ?>"></td>
    				</tr>
                	<tr>
    						<td><b>Temperature Probes:</b></td>
    						<td><b>Lowest Temperature:</b><br/>The lowest temperature possible</td>
    						<td><input type="text" name="tempProbeBoundLow" class="smallbox" value="<?php echo ($config[ConfigNames::TempProbeBoundLow]) ?>"></td>
    				</tr>
                	<tr>
    						<td><b>Temperature Probes:</b></td>
    						<td><b>Check Delay:</b><br/>The seconds between the checking temperature probes</td>
    						<td><input type="text" name="tempProbeBoundHigh" class="smallbox" value="<?php echo ($config[ConfigNames::TempProbeBoundHigh]) ?>"></td>
    				</tr>
				    <tr>
						<td colspan="3">
                        	<input type="submit" name="saveSettings" class="btn" value="Save" />
                        </td>
					</tr>
                </table>
            </form>
            </div>
            
   			<!--  <input type="button" id="newRow1" name="newRow2" class="btn" value="Add Reader" />
			<br> -->
            <?php
                if($numberOfReaders == 0){
            ?>
            <br>
            <strong>No Active Temperature Probes Found</strong>
            <br>
            Connect probes to pi according to <a target="_blank" href="https://cdn-learn.adafruit.com/downloads/pdf/adafruits-raspberry-pi-lesson-11-ds18b20-temperature-sensing.pdf">this</a> If correct probes will automatically populate
            <?php } ?>

			<form method="POST" id="tempProbes-form">
                <table style="width:800px" id="tableList">
                	<thead>
                        <tr>
                            <th style="width:30%; vertical-align: middle;">Name</th>
                            <!--<th style="width:30%; vertical-align: middle;">Type</th>-->
                            <!--<th style="width:30%; vertical-align: middle;">Pi Pin</th>-->
                            <th style="width:20%; vertical-align: middle;">Adjustment</th>
                            <th style="width:50%; vertical-align: middle;">Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($probes as $probe){
                        ?>
                                <tr>
                                    <td style="width:30%; vertical-align: middle;">
            							<input type="hidden" name="id[]" value="<?php echo $probe->get_id()?>" />
                                        <input type="text" id="name<?php echo $probe->get_id()?>" class="mediumbox" name="name[]" value="<?php echo $probe->get_name() ?>" readonly/>
                                        <input type="hidden" name="type[]" value="<?php echo $probe->get_type()?>" />
                                    	<input type="hidden" name="pin[]" value="<?php echo $probe->get_pin()?>" />
                                    </td>                                    	
                                    <!-- Unneeded until other type of probe is implemented (remove hidden type from above)
                                    <td style="width:25%;vertical-align: middle;">
                                    	<select id="<?php //echo $probe->get_id() ?>" name='type[]' class=''>
                                        	<option value='0'>1 Wire</option>
                                         	<option value='1'>DHT22 - Not Implemented</option>
                                        </select>
                                    </td>-->
                                    <!-- unneeded until other type of probe is implemented (remove hidden pin from above)
                                    <td style="width:25%; vertical-align: middle;">
                                        <input type="text" id="pin" class="smallbox" name="pin[]" value="<?php echo $probe->get_pin() ?>" />
                                    </td>-->
                                    <td style="width:20%; vertical-align: middle;">
                                        <input type="text" id="adjustment<?php echo $probe->get_id(); ?>" class="smallbox" name="Adjustment[]" value="<?php echo $probe->get_manualAdj() ?>" />
                                    </td>
                                    <td style="width:50%;vertical-align: middle;">
                                        <input type="text" id="notes<?php echo $probe->get_id(); ?>" class="largebox" name="notes[]" value="<?php echo $probe->get_notes() ?>" />
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
				foreach ($probes as $probe){
				    if(null == $probe)continue; 
				?>
					<?php echo $comma; ?>adjustment<?php echo $probe->get_id(); ?>: { required: false, number: true }
					<?php $comma = ","; ?>
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
