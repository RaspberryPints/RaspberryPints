<?php
require_once __DIR__.'/header.php';
require_once __DIR__.'/includes/managers/accolade_manager.php';
require_once __DIR__.'/includes/models/accolade.php';
$htmlHelper = new HtmlHelper();
$manager = new AccoladeManager();

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
	    //$newItem = false;
	    if(isset($_POST ['id'][$ii]) && $_POST ['id'][$ii] != "")
	    {
	        $id = $_POST ['id'][$ii];
	        $item = $manager->GetById($id);
	    }else{
	        $item = new Accolade();
	       //$newItem = true;
	    }
	    if( $_POST['name'][$ii] == '') $_POST['name'][$ii] = 'new';
	    $item->set_name($_POST['name'][$ii]);
	    $item->set_rank($_POST['rank'][$ii]);
	    $item->set_srm($_POST['srm'][$ii]);
	    $item->set_type($_POST['type'][$ii]);
	    $item->set_notes($_POST['notes'][$ii]);
	    if(!$manager->save($item))$error=true;
	    $ii++;
	}
	if(!$error){
		$_SESSION['successMessage'] = "Success";
	}else{
		$_SESSION['successMessage'] = "Changes Could Not Be Saved";	
	}
	
} 
?>
<script>
function saveAndUploadImage(id){
    var form = $('#editForm')
    var element1 = document.createElement("input");
    element1.value=id;
    element1.name="uploadImage";
    element1.type="hidden";
    form.append(element1);
    var element2 = document.createElement("input");
    element2.value="save";
    element2.name="save";
    element2.type="hidden";
    form.append(element2);
    form.submit();
}
function uploadImage(id){
    var form = document.createElement("form");
    var element1 = document.createElement("input");
    var element2 = document.createElement("input");
    form.method = "POST";
    form.action = "image_prompt.php?id="+id;
    
    element1.value="accolade/accolade";
    element1.name="targetDir";
    element1.type="hidden";
    form.appendChild(element1);
    element2.value="../accolades_list.php";
    element2.name="redirect";
    element2.type="hidden";
    form.appendChild(element2);
    document.body.appendChild(form);
    
    form.submit();
}
function saveAndRemoveImage(id){
    var form = $('#editForm')
    var element1 = document.createElement("input");
    element1.value=id;
    element1.name="removeImage";
    element1.type="hidden";
    form.append(element1);
    var element2 = document.createElement("input");
    element2.value="save";
    element2.name="save";
    element2.type="hidden";
    form.append(element2);
    form.submit();
}
function removeImage(id){
    var form = document.createElement("form");
    var element2 = document.createElement("input");
    form.method = "POST";
    form.action = "image_remove.php?id="+id+"&type=accolade";
    element2.value="accolades_list.php";
    element2.name="redirect";
    element2.type="hidden";
    form.appendChild(element2);
    document.body.appendChild(form);
    
    form.submit();
}
</script>
<body>
<?php
if (isset ( $_POST ['save'] )) {
    if(!$error){
        if(isset($_POST["uploadImage"]) && $_POST["uploadImage"] != '') echo "<script>uploadImage(".$_POST["uploadImage"].")</script>";
        if(isset($_POST["removeImage"]) && $_POST["removeImage"] != '') echo "<script>removeImage(".$_POST["removeImage"].")</script>";
    }
}

$items = $manager->GetAllActive();
$numItems=count($items);

$srmManager = new SrmManager();
$srmList = $srmManager->getAll();
?>
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
			<li class="current">Accolades</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End -->

	<!-- Right Side/Main Content Start -->
<div id="rightside">
	<div class="contentcontainer left">
		<div class="headings alt">
			<h2>Accolades</h2>
		</div>
		<div class="contentbox">
			<?php $htmlHelper->ShowMessage(); ?>
   			 <input type="button" id="newRow1" name="newRow2" class="btn" value="Add Accolade" />
			<br>
            <?php
                if($numItems == 0){
                    $items[] = new Accolade();
            ?>
            <br>
            <strong>No Active Accolades Found</strong>
            <br>
            <?php } ?>

			<form method="POST" id="editForm" novalidate="novalidate">
                <table style="width:800px" id="tableList">
                	<thead>
                        <tr>
                            <th style="width:35%; vertical-align: middle;">Name</th>
                            <th style="vertical-align: middle;"></th>
                            <th style="width:10%; vertical-align: middle;">Type</th>
                            <th style="width:10%; vertical-align: middle;">Rank</th>
                            <th style="width:10%; vertical-align: middle;">Color</th>
                            <th style="width:35%; vertical-align: middle;">Notes</th>
                            <th style="width:10%; vertical-align: middle;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if( count($items) == 0 ){
                        ?>
                                <tr><td class="no-results" colspan="99">No Accolades :( Add some?</td></tr>
                        <?php
                            }
                            foreach ($items as $item){
                        ?>
                                <tr>
                                    <td style="width:35%; vertical-align: middle;">
            							<input type="hidden" name="id[]" value="<?php echo $item->get_id()?>" />
				                         <?php 
                                            $style = "";
                                            $hasImg = false;
                                            if(isset($item))
                							{
                							    $imgs = glob ( '../img/accolade/accolade'.$item->get_id().'.*' );
                    							if(count($imgs) > 0)
                    							{
                    							    $style .= ($style != ""?";":"").'background:url('.$imgs[0].') no-repeat bottom left; background-size:cover; -webkit-border-radius:0px; -mox-border-radius:0px; height:100%; width:50px';
                    							    $hasImg = true;
                    							}
                							}
            							?> 
                                        <input type="text" id="name<?php echo $item->get_id() ?>" class="largebox" name="name[]" value="<?php echo $item->get_name() ?>" <?php echo $style != ""?'style="'.$style.'"':""; ?> />
                                    </td>
                                    <td id="imgs">
            							<div>
                                        <a onclick="saveAndUploadImage(<?php echo $item->get_id();?>)"><span class="tooltip"><img src="img/icons/upload.png" /><span class="tooltiptext">Upload Accolade Image</span></span></a>
                                    	<?php if($hasImg) {?>
                                    		<a onclick="saveAndRemoveImage(<?php echo $item->get_id();?>)"><span class="tooltip"><img id="removeImg" src="img/icons/icon_missing.png" /><span class="tooltiptext">Remove Accolade Image</span></span></a>
                                    	<?php }?>
                                    	</div>
                                    </td>
                                    <td style="width:10%;vertical-align: middle;">
                                        <input type="text" id="type<?php echo $item->get_id() ?>" class="smallbox" name="type[]" value="<?php echo $item->get_type() ?>" />
                                    </td>
                                    <td style="width:10%;vertical-align: middle;">
                                        <input type="text" id="rank<?php echo $item->get_id() ?>" class="smallbox" name="rank[]" value="<?php echo $item->get_rank() ?>" />
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
   			 <input type="button" id="newRow2" name="newRow2" class="btn" value="Add Accolade" />
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
			var $clone = rowStructure.clone()
			$($clone[0].cells).find('input').each(function() {
			    $(this).css("background-image", "none");
			   });
			$($clone[0].cells).find('img').each(function() {
			    $(this).hide();
			   });
			$table.append($clone);
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
