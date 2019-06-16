<?php
require_once __DIR__.'/header.php';
$htmlHelper = new HtmlHelper();
$tapManager = new TapManager();

$config = getAllConfigs();

$reconfig = false;
if (isset ( $_POST ['tare'] )) {
    $tapManager->set_tapTareRequested($_POST ['tare'], TRUE);
    file_get_contents('http://' . $_SERVER['SERVER_NAME'] . '/admin/trigger.php?value=tare');
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
	    if(!$tapManager->saveTapLoadCellInfo($_POST ['id'][$ii], $_POST['loadCellCmdPin'][$ii], $_POST['loadCellRspPin'][$ii], $_POST['loadCellUnit'][$ii]))$error=true;
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
    file_get_contents ( 'http://' . $_SERVER ['SERVER_NAME'] . '/admin/trigger.php?value=all' );
}

$taps = $tapManager->GetAllActive();
$numberOfTaps=count($taps);
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
            <h1><strong>
            This is a place holder for anyone who wants to use load cells. (assuming 2 pin communication)<br/>
            python/FlowMonitor.py:LoadCellCheckThread:getWeight needs to be updated<br/></strong></h1>
            Originally designed for hx711 load cells.<br/>            

			<form method="POST" id="loadCells-form">
                <table style="width:500px" id="tableList">
                	<thead>
                        <tr>
                            <th style="vertical-align: middle;">Tap</th>
                            <th style="vertical-align: middle;">Command Pin</th>
                            <th style="vertical-align: middle;">Response Pin</th>
                            <th style="width:200px;vertical-align: middle;">Unit</th>
                            <th style="width:50px; vertical-align: middle;">Tare Date</th>
                            <th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if( $numberOfTaps == 0 ){
                        ?>
                                <tr><td class="no-results" colspan="99">No Taps to configure load cells for :(</td></tr>
                        <?php
                            }
                            foreach ($taps as $tap){
                        ?>
                                <tr>
                                    <td style="vertical-align: middle;">
            							<input type="hidden" name="id[]" value="<?php echo $tap->get_id()?>" />
                                        <span id="tapName" class="smallbox"><?php echo $tap->get_tapNumber() ?></span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <input type="text" id="loadCellCmdPin<?php echo $tap->get_id();?>" class="smallbox" name="loadCellCmdPin[]" value="<?php echo $tap->get_loadCellCmdPin() ?>" />
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <input type="text" id="loadCellRspPin<?php echo $tap->get_id();?>" class="smallbox" name="loadCellRspPin[]" value="<?php echo $tap->get_loadCellRspPin() ?>" />
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
                                        <?php if( $tap->get_loadCellCmdPin() != '' ) { ?>
                                            <button name="tare[]" id="tare echo $tap->get_id();?>" type="button" class="btn" style="white-space:nowrap;" value="1" onClick="tare( <?php echo $tap->get_id()?>)">Tare</button>
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
			     <?php } ?> 
				}
			});		
		});

		function tare(tapId){
			var data
			data = { "tare" : tapId }
			
			$.ajax(
	            {
	                   type: "POST",
	                   url: "load_cell_list.php",
	                   data: data,// data to send to above script page if any
	                   cache: false
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
