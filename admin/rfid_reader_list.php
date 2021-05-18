<?php
require_once __DIR__.'/header.php';
$htmlHelper = new HtmlHelper();
$rfidManager = new RFIDReaderManager();

$config = getAllConfigs();

$reconfig = false;
$activeReadersIds = $rfidManager->GetAllActiveIDs();
if (isset ( $_POST ['save'] )) {
	$error = false;
	foreach($activeReadersIds as $id){
		if(!isset($_POST ['id']) || !in_array($id, $_POST ['id'])){
		    if(!$rfidManager->Inactivate($id))$error=true;
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
	        $reader = $rfidManager->GetById($id);
	    }else{
	        $reader = new RFIDReader();
	        $newReader = true;
	    }
	    $reader->set_name($_POST['name'][$ii]);
	    $reader->set_type($_POST['type'][$ii]);
	    $reader->set_pin($_POST['pin'][$ii]);
	    $reader->set_priority($_POST['priority'][$ii]);
	    if(!$newReader || ($newReader && $reader->get_name() != '')) if(!$rfidManager->save($reader))$error=true;
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
$readers = $rfidManager->GetAllActive();
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
			<li class="current">RFID Readers</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End -->

	<!-- Right Side/Main Content Start -->
<div id="rightside">
	<div class="contentcontainer left">
		<div class="headings alt">
			<h2>RFID Readers</h2>
		</div>
		<div class="contentbox">
			<?php $htmlHelper->ShowMessage(); ?>
   			 <input type="button" id="newRow1" name="newRow2" class="btn" value="Add Reader" />
			<br>
            <?php
                if($numberOfReaders == 0){
                    $readers[] = new RFIDReader();
            ?>
            <br>
            <strong>No Active RFID Readers Found</strong>
            <br>
            <?php } ?>

			<form method="POST" id="readers-form">
                <table style="width:800px" id="tableList">
                	<thead>
                        <tr>
                            <th style="width:30%; vertical-align: middle;">Name</th>
                            <th style="width:30%; vertical-align: middle;">Type</th>
                            <th style="width:30%; vertical-align: middle;">Pi Pin</th>
                            <th style="width:30%; vertical-align: middle;">Priority</th>
                            <th style="width:10%; vertical-align: middle;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if( count($readers) == 0 ){
                        ?>
                                <tr><td class="no-results" colspan="99">No Readers :( Add some?</td></tr>
                        <?php
                            }
                            foreach ($readers as $reader){
                        ?>
                                <tr>
                                    <td style="width:40%; vertical-align: middle;">
            							<input type="hidden" name="id[]" value="<?php echo $reader->get_id()?>" />
                                        <input type="text" id="name" class="largebox" name="name[]" value="<?php echo $reader->get_name() ?>" />
                                    </td>
                                    <td style="width:25%;vertical-align: middle;">
                                    	<select id="<?php echo $reader->get_id() ?>" name='type[]' class=''>
                                        	<option value='0'>SPI - MFRC522</option>
<!--                                         	<option value='1'>Serial</option> --><!-- Not Implemented -->
                                        </select>
                                    </td>
                                    <td style="width:25%; vertical-align: middle;">
                                        <input type="text" id="pin" class="smallbox" name="pin[]" value="<?php echo $reader->get_pin() ?>" />
                                    </td>
                                    <td style="width:25%; vertical-align: middle;">
                                        <input type="text" id="priority" class="smallbox" name="priority[]" value="<?php echo $reader->get_priority() ?>" />
                                    </td>
                                    <td style="width:10%;vertical-align: middle;">
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
   			 <input type="button" id="newRow2" name="newRow2" class="btn" value="Add Reader" />
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
				    if(null == $reader)continue; 
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
