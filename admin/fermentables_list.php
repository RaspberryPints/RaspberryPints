<?php
require_once __DIR__.'/header.php';
$htmlHelper = new HtmlHelper();
$manager = new FermentableManager();

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
	        $item = new Fermentable();
	        $newItem = true;
	    }
	    $item->set_name($_POST['name'][$ii]);
	    $item->set_srm($_POST['srm'][$ii]);
	    $item->set_type($_POST['type'][$ii]);
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

$srmManager = new SrmManager();
$srmList = $srmManager->getAll();
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
			<li class="current">Fermentables</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End -->

	<!-- Right Side/Main Content Start -->
<div id="rightside">
	<div class="contentcontainer left">
		<div class="headings alt">
			<h2>Fermentables</h2>
		</div>
		<div class="contentbox">
			<?php $htmlHelper->ShowMessage(); ?>
   			 <input type="button" id="newRow1" name="newRow2" class="btn" value="Add Fermentable" />
			<br>
            <?php
                if($numItems == 0){
                    $items[] = new Fermentable();
            ?>
            <br>
            <strong>No Active Fermentables Found</strong>
            <br>
            <?php } ?>

			<form method="POST" id="editForm" novalidate="novalidate">
                <table style="width:800px" id="tableList">
                	<thead>
                        <tr>
                            <th style="width:35%; vertical-align: middle;">Name</th>
                            <th style="width:10%; vertical-align: middle;">Type</th>
                            <th style="width:10%; vertical-align: middle;">SRM</th>
                            <th style="width:35%; vertical-align: middle;">Notes</th>
                            <th style="width:10%; vertical-align: middle;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if( count($items) == 0 ){
                        ?>
                                <tr><td class="no-results" colspan="99">No Fermentables :( Add some?</td></tr>
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
                                        <input type="text" id="type<?php echo $item->get_id() ?>" class="smallbox" name="type[]" value="<?php echo $item->get_type() ?>" />
                                    </td>
                                    <td style="width:10%;vertical-align: middle;">
                                    <?php
                					   	echo $htmlHelper->ToColorSelectList("srm[]", "srm".$item->get_id(), $srmList, "srm", "srm", $item->get_srm(), "Select SRM", "", "rgb"); 
                					?>	
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
   			 <input type="button" id="newRow2" name="newRow2" class="btn" value="Add Fermentable" />
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
		$(function() {		
			$('#editForm').validate({
			rules: {		
				<?php 
				$comma = "";
				foreach($items as $item){ 
				    if(null == $item)continue; 
				?>
					<?php echo $comma; ?>name<?php echo $item->get_id(); ?>: { required: true }
					<?php $comma = ","; ?>
					<?php echo $comma; ?>alpha<?php echo $item->get_id(); ?>: { required: true, number: true }
					<?php echo $comma; ?>beta<?php echo $item->get_id(); ?>: { required: true, number: true }
				<?php } ?> 
				}
			});		
		});
</script>
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
