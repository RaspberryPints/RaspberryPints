<?php
require_once __DIR__.'/header.php';
require_once __DIR__.'/includes/managers/iSpindelConnector_manager.php';
$htmlHelper = new HtmlHelper();
$iSpindelConnectorManager = new iSpindelConnectorManager();

$config = getAllConfigs();

$reconfig = false;
$activeiSpindelConnectorsIds = $iSpindelConnectorManager->GetAllActiveIDs();
if (isset ( $_POST ['save'] )) {
	$error = false;
	foreach($activeiSpindelConnectorsIds as $id){
		if(!isset($_POST ['id']) || !in_array($id, $_POST ['id'])){
		    if(!$iSpindelConnectorManager->Inactivate($id))$error=true;
		    $reconfig = true;
		}
	}
	$ii = 0;
	while(isset($_POST ['address'][$ii]))
	{
	    $newConnector = false;
	    if(isset($_POST ['id'][$ii]) && $_POST ['id'][$ii] != "")
	    {
	        $id = $_POST ['id'][$ii];
	        $connector = $iSpindelConnectorManager->GetById($id);
	    }else{
	        $connector = new iSpindelConnector();
	        $newConnector = true;
	    }
	    $connector->set_address($_POST['address'][$ii]);
	    $connector->set_port($_POST['port'][$ii]);
	    $connector->set_allowedConnections($_POST['allowedConnections'][$ii]);
	    if(!$newConnector || ($newConnector && $connector->get_address() != '')) if(!$iSpindelConnectorManager->save($connector))$error=true;
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
    include('triggerAll.php');
}
$iSpindelConnectors = $iSpindelConnectorManager->GetAllActive();
$numberOfiSpindelConnectors=count($iSpindelConnectors);
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
			<li class="current">iSpindel Connectors</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End -->

	<!-- Right Side/Main Content Start -->
<div id="rightside">
	<div class="contentcontainer left">
		<div class="headings alt">
			<h2>iSpindel Connectors</h2>
		</div>
		<div class="contentbox">
			<?php $htmlHelper->ShowMessage(); ?>
   			 <input type="button" id="newRow1" name="newRow2" class="btn" value="Add Connector" />
			<br>
            <?php
                if($numberOfiSpindelConnectors == 0){
                    $iSpindelConnectors[] = new iSpindelConnector();
            ?>
            <br>
            <strong>No Active iSpindel Connectors Found</strong>
            <br>
            <?php } ?>

			<form method="POST" id="iSpindelConnectors-form">
                <table style="width:800px" id="tableList">
                	<thead>
                        <tr>
                            <th style="width:30%; vertical-align: middle;">Address</th>
                            <th style="width:30%; vertical-align: middle;">Port</th>
                            <th style="width:30%; vertical-align: middle;">AllowedConnections</th>
                            <th style="width:10%; vertical-align: middle;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if( count($iSpindelConnectors) == 0 ){
                        ?>
                                <tr><td class="no-results" colspan="99">No iSpindel Connectors :( Add some?</td></tr>
                        <?php
                            }
                            foreach ($iSpindelConnectors as $connector){
                        ?>
                                <tr>
                                    <td style="width:40%; vertical-align: middle;">
            							<input type="hidden" name="id[]" value="<?php echo $connector->get_id()?>" />
                                        <input type="text" id="address" class="largebox" name="address[]" value="<?php echo $connector->get_address() ?>" />
                                    </td>
                                    <td style="width:25%; vertical-align: middle;">
                                        <input type="text" id="port" class="smallbox" name="port[]" value="<?php echo $connector->get_port() ?>" />
                                    </td>
                                    <td style="width:25%; vertical-align: middle;">
                                        <input type="text" id="allowedConnections" class="smallbox" name="allowedConnections[]" value="<?php echo $connector->get_allowedConnections() ?>" />
                                    </td>
                                    <td style="width:10%;vertical-align: middle;">
                                        <button name="delete" type="button" class="btn" style="white-space:nowrap" value="<?php echo $connector->get_id()?>" onClick="removeRow(this)">Delete</button>
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
   			 <input type="button" id="newRow2" name="newRow2" class="btn" value="Add Connector" />
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
			$('#iSpindelConnectors-form').validate({
			rules: {		
				<?php 
				$comma = "";
				foreach ($iSpindelConnectors as $connector){
				    if(null == $connector)continue; 
				?>
					<?php echo $comma; ?>address<?php echo $connector->get_id(); ?>: { required: true }
					<?php $comma = ","; ?>
					<?php echo $comma; ?>port<?php echo $connector->get_id(); ?>: { required: true, number: true }
					<?php echo $comma; ?>allowedConnections<?php echo $connector->get_id(); ?>: { required: true, number: true }
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
