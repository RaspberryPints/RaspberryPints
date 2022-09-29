<?php
require_once __DIR__.'/header.php';
$htmlHelper = new HtmlHelper();
$manager = new YeastManager();

$config = getAllConfigs();

$activeIds = $manager->GetAllActiveIDs();
if (isset ( $_POST ['save'] )) {
	$error = false;
	foreach($activeIds as $id){
		if(!isset($_POST ['id']) || !in_array($id, $_POST ['id'])){
			if(!$manager->Inactivate($id))$error=true;
		}
	}
	$ii = 0;
	while(isset($_POST ['name'][$ii]))
	{
	    $newItem = false;
	    if(isset($_POST ['id'][$ii]) && $_POST ['id'][$ii] != "")
	    {
	        $id = $_POST ['id'][$ii];
	        $item = $manager->GetById($id);
	    }else{
	        $item = new Yeast();
	        $newItem = true;
	    }
	    $item->set_name($_POST['name'][$ii]);
	    $item->set_strand($_POST['strand'][$ii]);
	    $item->set_format($_POST['format'][$ii]);
	    if($_POST['minTemp'][$ii] != $_POST['minTempOriginal'][$ii]){
	       $item->set_minTemp($_POST['minTemp'][$ii]);
	       $item->set_minTempUnit($config[ConfigNames::DisplayUnitTemperature]);
	    }
	    if($_POST['maxTemp'][$ii] != $_POST['maxTempOriginal'][$ii]){
    	    $item->set_maxTemp($_POST['maxTemp'][$ii]);
    	    $item->set_maxTempUnit($config[ConfigNames::DisplayUnitTemperature]);
	    }
	    $item->set_minAttenuation($_POST['minAttenuation'][$ii]);
	    $item->set_maxAttenuation($_POST['maxAttenuation'][$ii]);
	    $item->set_flocculation($_POST['flocculation'][$ii]);
	    $item->set_notes($_POST['notes'][$ii]);
	    if(!$newItem || ($newItem && $item->get_name() != '')) if(!$manager->save($item))$error=true;
	    $ii++;
	}
	if(!$error){
		$_SESSION['successMessage'] = "Success";
	}else{
		$_SESSION['successMessage'] = "Changes Could Not Be Saved";	
	}
	
} 

$items = $manager->GetAllActive();
$numItems=count($items);

//$srmManager = new SrmManager();
//$srmList = $srmManager->getAll();
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
			<li class="current">Yeasts</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End -->

	<!-- Right Side/Main Content Start -->
<div id="rightside">
	<div class="contentcontainer left">
		<div class="headings alt">
			<h2>Yeasts</h2>
		</div>
		<div class="contentbox">
			<?php $htmlHelper->ShowMessage(); ?>
   			 <input type="button" id="newRow1" name="newRow2" class="btn" value="Add Yeast" />
			<br>
            <?php
                if($numItems == 0){
                    $items[] = new Yeast();
            ?>
            <br>
            <strong>No Active Yeasts Found</strong>
            <br>
            <?php } ?>

			<form method="POST" id="editForm" onsubmit='return validate(this);'>
                <table style="width:800px" id="tableList">
                	<thead>
                        <tr>
                            <th style="width:20%; vertical-align: middle;">Name</th>
                            <th style="width:20%; vertical-align: middle;">Strand</th>
                            <th style="width:10%; vertical-align: middle;">Format</th>
                            <th style="width:5%; vertical-align: middle;">Minimum<br/>Temperature(<?php echo $config[ConfigNames::DisplayUnitTemperature]?>)</th>
                            <th style="width:5%; vertical-align: middle;">Maximum<br/>Temperature(<?php echo $config[ConfigNames::DisplayUnitTemperature]?>)</th>
                            <th style="width:5%; vertical-align: middle;">Minimum<br/>Attenuation</th>
                            <th style="width:5%; vertical-align: middle;">Maximum<br/>Attenuation</th>
                            <th style="width:10%; vertical-align: middle;">Flocculation</th>
                            <th style="width:10%; vertical-align: middle;">Notes</th>
                            <th style="width:10%; vertical-align: middle;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if( count($items) == 0 ){
                        ?>
                                <tr><td class="no-results" colspan="99">No Yeasts :( Add some?</td></tr>
                        <?php
                            }
                            foreach ($items as $item){
                        ?>
                                <tr>
                                    <td style="width:35%; vertical-align: middle;">
            							<input type="hidden" name="id[]" value="<?php echo $item->get_id()?>" />
                                        <input type="text" id="name<?php echo $item->get_id() ?>" class="mediumbox" name="name[]" value="<?php echo $item->get_name() ?>" />
                                    </td>
                                    <td style="width:10%;vertical-align: middle;">
                                        <input type="text" id="strand<?php echo $item->get_id() ?>" class="mediumbox" name="strand[]" value="<?php echo $item->get_strand() ?>" />
                                    </td>
                                    <td style="width:10%;vertical-align: middle;">
										<input type="text" id="format<?php echo $item->get_id() ?>" class="smallbox" name="format[]" value="<?php echo $item->get_format() ?>" />
                                    </td>
                                    <td style="width:10%;vertical-align: middle;">
                                        <input type="text" id="minTemp<?php echo $item->get_id() ?>" class="smallbox" name="minTemp[]" value="<?php echo convert_temperature($item->get_minTemp(), $item->get_minTempUnit(), $config[ConfigNames::DisplayUnitTemperature]); ?>" />
                                    	<input type="hidden" id="minTempOriginal<?php echo $item->get_id() ?>" class="smallbox" name="minTempOriginal[]" value="<?php echo convert_temperature($item->get_minTemp(), $item->get_minTempUnit(), $config[ConfigNames::DisplayUnitTemperature]); ?>" />
                                    </td>
                                    <td style="width:10%;vertical-align: middle;">
										<input type="text" id="maxTemp<?php echo $item->get_id() ?>" class="smallbox" name="maxTemp[]" value="<?php echo convert_temperature($item->get_maxTemp(), $item->get_maxTempUnit(), $config[ConfigNames::DisplayUnitTemperature]) ?>" />
                                    	<input type="hidden" id="maxTempOriginal<?php echo $item->get_id() ?>" class="smallbox" name="maxTempOriginal[]" value="<?php echo convert_temperature($item->get_maxTemp(), $item->get_maxTempUnit(), $config[ConfigNames::DisplayUnitTemperature]) ?>" />
                                    </td>
                                    <td style="width:10%;vertical-align: middle;">
                                        <input type="text" id="minAttenuation<?php echo $item->get_id() ?>" class="smallbox" name="minAttenuation[]" value="<?php echo $item->get_minAttenuation() ?>" />
                                    </td>
                                    <td style="width:10%;vertical-align: middle;">
										<input type="text" id="maxAttenuation<?php echo $item->get_id() ?>" class="smallbox" name="maxAttenuation[]" value="<?php echo $item->get_maxAttenuation() ?>" />
                                    </td>
                                    <td style="width:10%;vertical-align: middle;">
										<input type="text" id="flocculation<?php echo $item->get_id() ?>" class="smallbox" name="flocculation[]" value="<?php echo $item->get_flocculation() ?>" />
                                    </td>
                                    <td style="width:35%;vertical-align: middle;">
                                        <input type="text" id="notes<?php echo $item->get_id() ?>" class="largebox" name="notes[]" value="<?php echo $item->get_notes() ?>" />
                                    </td>
                                    <td style="width:10%;vertical-align: middle;">
                                        <button name="delete" type="button" class="btn" style="white-space:nowrap" value="<?php echo $item->get_id()?>" onClick="removeRow(this)">Delete</button>
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
   			 <input type="button" id="newRow2" name="newRow2" class="btn" value="Add Yeast" />
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
    	function validate (form){
        	var valid = true;
        	$("form#"+form.id+" :input").each(function(){
    		 	var input = $(this)[0];
    		 	if( /minTemp[0-9]+/.test(input.id) ||
		 			/maxTemp[0-9]+/.test(input.id) ||
    	 			/minAttenuation[0-9]+/.test(input.id) ||
    	 			/maxAttenuation[0-9]+/.test(input.id) ||
    	 			/flocculation[0-9]+/.test(input.id) ){
            		if(!isNumeric(input.value)){
            			addInputError(input);
            			valid = false;
            		}
            		else
            		{
            			clearInputError(input);
            		}
    		 	}
    		});

        	return valid;
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
