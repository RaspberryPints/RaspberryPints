<?php
require_once __DIR__.'/header.php';
require_once __DIR__.'/includes/managers/gasTank_manager.php';
$htmlHelper = new HtmlHelper();
$tapManager = new TapManager();
$gasTankManager = new GasTankManager();
$kegManager = new KegManager();

//$config = getAllConfigs();

$reconfig = false;
if (isset ( $_POST ['tare'] )) {
    $tapManager->set_tapTareRequested($_POST ['tare'], TRUE);
    triggerPythonAction("tare");
}
if (isset ( $_POST ['tareGT'] )) {
    $gasTankManager->set_GasTankTareRequested($_POST ['tareGT'], TRUE);
    triggerPythonAction("tare");
}
if (isset ( $_POST ['save'] )) {
	$error = false;
	
	$ii = 0;
	while(isset($_POST ['id'][$ii]))
	{
	    if($_POST ['id'][$ii] == "")
	    {
	        $ii++;
	        continue;
	    }
	    if($_POST ['type'][$ii] == 1 && !$tapManager->saveTapLoadCellInfo($_POST ['id'][$ii], $_POST['loadCellCmdPin'][$ii], $_POST['loadCellRspPin'][$ii], $_POST['loadCellScaleRatio'][$ii], $_POST['loadCellTareOffset'][$ii], $_POST['loadCellUnit'][$ii]))$error=true;
	    if($_POST ['type'][$ii] == 2 && !$gasTankManager->saveGasTankLoadCellInfo($_POST ['id'][$ii], $_POST['loadCellCmdPin'][$ii], $_POST['loadCellRspPin'][$ii], $_POST['loadCellScaleRatio'][$ii], $_POST['loadCellTareOffset'][$ii], $_POST['loadCellUnit'][$ii]))$error=true;
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

if($reconfig){
    triggerPythonAction();
}

$taps = $tapManager->GetAllActive();
$gasTanks = $gasTankManager->GetAllActive();
$numberOfTaps=count($taps)+count($gasTanks);
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
			<li class="current">Load Cells</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End -->

	<!-- Right Side/Main Content Start -->
<div id="rightside">
	<div class="contentcontainer left">
		<div class="headings alt">
			<h2>Load Cell</h2>
		</div>
		<div class="contentbox">
			<?php $htmlHelper->ShowMessage(); ?>
			<br>
            <?php
                if($numberOfTaps == 0){
                    $taps[] = new Tap();
            ?>
            <br>
            <strong>No Active Load Cells Found</strong>
            <br>
            <?php } ?>
<!--             <h1><strong>
            This is a place holder for anyone who wants to use load cells. (assuming 2 pin communication)<br/>
            python/FlowMonitor.py:LoadCellCheckThread:getWeight needs to be updated<br/></strong></h1>
            Originally designed for hx711 load cells.<br/>   -->          

			<form method="POST" id="loadCells-form">
                <table style="width:500px" id="tableList">
                	<thead>
                        <tr>
                            <th style="vertical-align: middle;">Tap</th>
                            <th style="vertical-align: middle;">Command Pin</th>
                            <th style="vertical-align: middle;">Response Pin</th>
                            <th style="vertical-align: middle;">Scale Ratio</th>
                            <th style="vertical-align: middle;">Offset</th>
                            <th style="width:200px;vertical-align: middle;">Unit</th>
                            <th style="width:50px; vertical-align: middle;">Tare Date</th>
                            <th style="width:50px; vertical-align: middle;">Current Weight(Raw)</th>
                            <th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if( $numberOfTaps == 0 ){
                        ?>
                                <tr><td class="no-results" colspan="99">No Load Cells configured :(</td></tr>
                        <?php
                            }
                            foreach ($taps as $tap){
                        ?>
                                <tr>
                                    <td style="vertical-align: middle;">
            							<input type="hidden" name="id[]" value="<?php echo $tap->get_id()?>" />
            							<input type="hidden" name="type[]" value="1" />
                                        <span id="tapName" class="mediumbox"><?php echo $tap->get_tapNumber() ?></span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <input type="text" id="loadCellCmdPin<?php echo $tap->get_id();?>" class="smallbox" name="loadCellCmdPin[]" value="<?php echo $tap->get_loadCellCmdPin() ?>" />
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <input type="text" id="loadCellRspPin<?php echo $tap->get_id();?>" class="smallbox" name="loadCellRspPin[]" value="<?php echo $tap->get_loadCellRspPin() ?>" />
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <input type="text" id="loadCellScaleRatio<?php echo $tap->get_id();?>" class="smallbox" name="loadCellScaleRatio[]" value="<?php echo $tap->get_loadCellScaleRatio() ?>" />
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <input type="text" id="loadCellTareOffset<?php echo $tap->get_id();?>" class="smallbox" name="loadCellTareOffset[]" value="<?php echo $tap->get_loadCellTareOffset() ?>" />
                                    </td>
                                    <td style="vertical-align: middle;">
                                    <select name="loadCellUnit[]">
                                    <?php
                                        $result = getConfigByName(ConfigNames::DisplayUnitWeight);
                        				foreach($result as $row) {
                        				    $options = explode('|', $row['validation']);
                        				    foreach($options as $option){
                        				        echo '<option ' . ($tap->get_loadCellUnit()==$option?'selected':'') . ' value="'.$option.'">'.$option.'</option>'; 
                        					}
                        			} ?>
                        			</select>
                        			</td>
                                    <td style="vertical-align: middle;">
                                        <span><?php echo $tap->get_loadCellTareDate() ?></span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                    	<span>
                                    	<?php
                                        	$keg = null;
                                        	if( $tap->get_kegId() > 0 ) $keg = $kegManager->GetByID($tap->get_kegId());
                                    	    if( $keg ){
                                    	        echo $keg->get_weight();
                                    	    }else{
                                    	        echo "No Keg";
                                    	    }
                                    	?>
                                    	</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <?php if( $tap->get_loadCellCmdPin() != '' ) { ?>
                                            <button name="tare[]" id="tare<?php echo $tap->get_id();?>" type="button" class="btn" style="white-space:nowrap;" value="1" 
                                            onClick='tare(this, <?php echo $tap->get_id()?>); $(loadCellTareOffset<?php echo $tap->get_id()?>).attr("disabled", "disabled");'>Tare</button>
                                            <span id="tare<?php echo $tap->get_id();?>Success" style="display:none; color: #8EA534;"> (Success<br>Refresh to see Offset)</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <table style="width:500px" id="tableList">
                	<thead>
                        <tr>
                            <th style="vertical-align: middle;">Gas Tank</th>
                            <th style="vertical-align: middle;">Command Pin</th>
                            <th style="vertical-align: middle;">Response Pin</th>
                            <th style="vertical-align: middle;">Scale Ratio</th>
                            <th style="vertical-align: middle;">Offset</th>
                            <th style="width:200px;vertical-align: middle;">Unit</th>
                            <th style="width:50px; vertical-align: middle;">Tare Date</th>
                            <th style="width:50px; vertical-align: middle;">Current Weight(Raw)</th>
                            <th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($gasTanks as $gt){
                                ?>
                                <tr>
                                    <td style="vertical-align: middle;">
            							<input type="hidden" name="id[]" value="<?php echo $gt->get_id()?>" />
            							<input type="hidden" name="type[]" value="2" />
                                        <span id="gasTankLabel" class="mediumbox"><?php echo $gt->get_label() ?></span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <input type="text" id="loadCellCmdPin<?php echo $gt->get_id();?>" class="smallbox" name="loadCellCmdPin[]" value="<?php echo $gt->get_loadCellCmdPin() ?>" />
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <input type="text" id="loadCellRspPin<?php echo $gt->get_id();?>" class="smallbox" name="loadCellRspPin[]" value="<?php echo $gt->get_loadCellRspPin() ?>" />
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <input type="text" id="loadCellScaleRatio<?php echo $gt->get_id();?>" class="smallbox" name="loadCellScaleRatio[]" value="<?php echo $gt->get_loadCellScaleRatio() ?>" />
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <input type="text" id="loadCellTareOffset<?php echo $gt->get_id();?>" class="smallbox" name="loadCellTareOffset[]" value="<?php echo $gt->get_loadCellTareOffset() ?>" />
                                    </td>
                                    <td style="vertical-align: middle;">
                                    <select name="loadCellUnit[]">
                                    <?php
                                        $result = getConfigByName(ConfigNames::DisplayUnitWeight);
                        				foreach($result as $row) {
                        				    $options = explode('|', $row['validation']);
                        				    foreach($options as $option){
                        				        echo '<option ' . ($gt->get_loadCellUnit()==$option?'selected':'') . ' value="'.$option.'">'.$option.'</option>'; 
                        					}
                        			} ?>
                        			</select>
                        			</td>
                                    <td style="vertical-align: middle;">
                                        <span><?php echo $gt->get_loadCellTareDate() ?></span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                    	<span>
                                    	<?php
                                    	        echo $gt->get_weight();
                                    	?>
                                    	</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <?php if( $gt->get_loadCellCmdPin() != '' ) { ?>
                                            <button name="tareGT[]" id="tareGT<?php echo $gt->get_id();?>" type="button" class="btn" style="white-space:nowrap;" value="1" 
                                            onClick='tareGT(this, <?php echo $gt->get_id()?>); $(loadCellTareOffset<?php echo $gt->get_id()?>).attr("disabled", "disabled");'>Tare</button>
                                            <span id="tareGT<?php echo $gt->get_id();?>Success" style="display:none; color: #8EA534;"> (Success<br>Refresh to see Offset)</span>
                                        <?php } ?>
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
			$('#loadCells-form').validate({
			rules: {		
				<?php 
				$comma = "";
				foreach ($taps as $tap){
				    if(null == $tap)continue; 
				?>
					<?php echo $comma; ?>loadCellCmd<?php echo $tap->get_id(); ?>: { number: true, min: 1, integer: true   }
					<?php $comma = ","; ?>
					<?php echo $comma; ?>loadCellRsp<?php echo $tap->get_id(); ?>: { number: true, min: 1, integer: true  }
					<?php echo $comma; ?>loadScaleRatio<?php echo $tap->get_id(); ?>: { number: true, min: 1, integer: true  }
					<?php echo $comma; ?>loadTareOffset<?php echo $tap->get_id(); ?>: { number: true, min: 1, integer: true  }
			     <?php 
                } 
				foreach ($gasTanks as $gt){
				    if(null == $gt)continue; 
				?>
					<?php echo $comma; ?>loadCellCmd<?php echo $gt->get_id(); ?>: { number: true, min: 1, integer: true   }
					<?php $comma = ","; ?>
					<?php echo $comma; ?>loadCellRsp<?php echo $gt->get_id(); ?>: { number: true, min: 1, integer: true  }
					<?php echo $comma; ?>loadScaleRatio<?php echo $gt->get_id(); ?>: { number: true, min: 1, integer: true  }
					<?php echo $comma; ?>loadTareOffset<?php echo $gt->get_id(); ?>: { number: true, min: 1, integer: true  }
			     <?php } ?> 
				}
			});		
		});

		function tare(button, tapId){
			var data
			data = { "tare" : tapId }
			
			$.ajax(
	            {
	                   type: "POST",
	                   url: "load_cell_list.php",
	                   data: data,// data to send to above script page if any
	                   cache: false,
	                   success: function(response)
	                   {
	                	   document.getElementById(button.id + 'Success').style.display = ""; 
	                   }
	             });
	  	}
		function tareGT(button, GTId){
			var data
			data = { "tareGT" : GTId }
			
			$.ajax(
	            {
	                   type: "POST",
	                   url: "load_cell_list.php",
	                   data: data,// data to send to above script page if any
	                   cache: false,
	                   success: function(response)
	                   {
	                	   document.getElementById(button.id + 'Success').style.display = ""; 
	                   }
	             });
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
