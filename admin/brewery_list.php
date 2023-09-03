<?php
require_once __DIR__.'/header.php';
$htmlHelper = new HtmlHelper();
$breweryManager = new BreweryManager();

$activeBreweryIds = $breweryManager->GetAllActiveIDs();
if (isset ( $_POST ['saveBreweries'] )) {
	$error = false;
	foreach($activeBreweryIds as $id){
		if(!isset($_POST ['id']) || !in_array($id, $_POST ['id'])){
			if(!$breweryManager->Inactivate($id))$error=true;
		}
	}
	$ii = 0;
	while(isset($_POST ['name'][$ii]))
	{
	    $newBrewery = false;
	    if(isset($_POST ['id'][$ii]) && $_POST ['id'][$ii] != "")
	    {
	        $id = $_POST ['id'][$ii];
	        $brewery = $breweryManager->GetById($id);
	    }else{
	        $brewery = new Brewery();
	        $newBrewery = true;
	    }
	    $brewery->set_name($_POST['name'][$ii]);
	    $brewery->set_imageUrl($_POST['imageUrl'][$ii]);
	    if(!$newBrewery || ($newBrewery && $brewery->get_name() != '')) if(!$breweryManager->save($brewery))$error=true;
	    $ii++;
	}
	if(!$error){
		$_SESSION['successMessage'] = "Success";
	}else{
		$_SESSION['successMessage'] = "Changes Could Not Be Saved";	
	}
	
} 

$breweries = $breweryManager->GetAllActive();
$numberofBreweries=count($breweries);
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
			<li class="current">Breweries</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End -->

	<!-- Right Side/Main Content Start -->
<div id="rightside">
	<div class="contentcontainer left">
		<div class="headings alt">
			<h2>Breweries</h2>
		</div>
		<div class="contentbox">
			<?php $htmlHelper->ShowMessage(); ?>
   			 <input type="button" id="newRow1" name="newRow2" class="btn" value="Add Brewery" />
			<br>
            <?php
                if($numberofBreweries == 0){
                    $breweries[] = new Brewery();
            ?>
            <br>
            <strong>No Active Breweries Found</strong>
            <br>
            <?php } ?>

			<form method="POST" id="brewery-form">
                <table style="width:800px" id="tableList">
                	<thead>
                        <tr>
                            <th style="width:40%; vertical-align: middle;">Name</th>
                            <th style="width:40%; vertical-align: middle;">Image URL</th>
                            <th style="width:10%; vertical-align: middle;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if( count($breweries) == 0 ){
                        ?>
                                <tr><td class="no-results" colspan="99">No Breweries :( Add some?</td></tr>
                        <?php
                            }
                            foreach ($breweries as $brewery){
                        ?>
                                <tr>
                                    <td style="width:45%; vertical-align: middle;">
            							<input type="hidden" name="id[]" value="<?php echo $brewery->get_id()?>" />
                                        <input type="text" id="name" class="largebox" name="name[]" value="<?php echo $brewery->get_name() ?>" />
                                    </td>
                                    <td style="width:45%;vertical-align: middle;">
                                        <input type="text" id="imageUrl" class="largebox" name="imageUrl[]" value="<?php echo $brewery->get_imageUrl() ?>" />
                                    </td>
                                    <td style="width:10%;vertical-align: middle;">
                                        <button name="delete" type="button" class="btn" style="white-space:nowrap" value="<?php echo $brewery->get_id()?>" onClick="removeRow(this)">Delete</button>
                                    </td>
                                </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
                <table>
                    <tr>
                        <td><input type="submit" name="saveBreweries" class="btn" value="Save" /></td>
                        <td id="pendingChangesDiv" style="display:none"><strong>Pending Changes</strong></td>
                    </tr>
                </table>
            </form>
   			 <input type="button" id="newRow2" name="newRow2" class="btn" value="Add Brewery" />
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
