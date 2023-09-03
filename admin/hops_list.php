<?php
require_once __DIR__.'/header.php';
$htmlHelper = new HtmlHelper();
$manager = new HopManager();

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
	        $item = new Hop();
	        $newItem = true;
	    }
	    $item->set_name($_POST['name'][$ii]);
	    $item->set_alpha($_POST['alpha'][$ii]);
	    $item->set_beta($_POST['beta'][$ii]);
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
			<li class="current">Hops</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End -->

	<!-- Right Side/Main Content Start -->
<div id="rightside">
	<div class="contentcontainer left">
		<div class="headings alt">
			<h2>Hops</h2>
		</div>
		<div class="contentbox">
			<?php $htmlHelper->ShowMessage(); ?>
   			 <input type="button" id="newRow1" name="newRow2" class="btn" value="Add Hop" />
			<br>
            <?php
                if($numItems == 0){
                    $items[] = new Hop();
            ?>
            <br>
            <strong>No Active Hops Found</strong>
            <br>
            <?php } ?>

			<form method="POST" id="editForm" onsubmit="return validate(this);">
                <table style="width:800px" id="tableList">
                	<thead>
                        <tr>
                            <th style="width:35%; vertical-align: middle;">Name</th>
                            <th style="width:10%; vertical-align: middle;">Alpha<br/>Acid</th>
                            <th style="width:10%; vertical-align: middle;">Beta<br/>Acid</th>
                            <th style="width:35%; vertical-align: middle;">Notes</th>
                            <th style="width:10%; vertical-align: middle;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if( count($items) == 0 ){
                        ?>
                                <tr><td class="no-results" colspan="99">No Hops :( Add some?</td></tr>
                        <?php
                            }
                            foreach ($items as $item){
                        ?>
                                <tr>
                                    <td style="width:35%; vertical-align: middle;">
            							<input type="hidden" name="id[]" value="<?php echo $item->get_id()?>" />
                                        <input type="text" id="name<?php echo $item->get_id() ?>" class="largebox" name="name[]" value="<?php echo $item->get_name() ?>" />
                                    </td>
                                    <td style="width:10%;vertical-align: middle;">
                                        <input type="text" id="alpha<?php echo $item->get_id() ?>" class="smallbox" name="alpha[]" value="<?php echo $item->get_alpha() ?>" />
                                    </td>
                                    <td style="width:10%;vertical-align: middle;">
                                        <input type="text" id="beta<?php echo $item->get_id() ?>" class="smallbox" name="beta[]" value="<?php echo $item->get_beta() ?>" />
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
   			 <input type="button" id="newRow2" name="newRow2" class="btn" value="Add Hop" />
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
    		 	if( input.name.match("alpha.*") ||
    	 			input.name.match("beta.*") ){
            		if(!isNumeric(input.value)){
            			addInputError(input);
            			valid = false;
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
