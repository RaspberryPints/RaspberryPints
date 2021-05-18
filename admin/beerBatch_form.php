<?php
require_once __DIR__.'/header.php';
require_once __DIR__.'/../includes/Pintlabs/Service/Untappd.php';
require_once __DIR__.'/../includes/functions.php';
require_once __DIR__.'/includes/managers/accolade_manager.php';
require_once __DIR__.'/includes/managers/beerBatchYeast_manager.php';
//require_once __DIR__.'/includes/managers/beerBatchAccolade_manager.php';
require_once __DIR__.'/includes/managers/beer_manager.php';

$htmlHelper = new HtmlHelper();
$beerBatchManager = new BeerBatchManager();
$beerManager = new BeerManager();
$YeastManager = new YeastManager();
$AccoladeManager = new AccoladeManager();
//$beerBatchAccoladeManager = new BeerBatchAccoladeManager();
$beerBatchYeastManager = new BeerBatchYeastManager();
$srmManager = new SrmManager();
$beerBatch = null;
$config = getAllConfigs();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $beerBatch = new BeerBatch();
    if(isset($_POST['beerId']))$_POST['beerId'] = explode("~", $_POST['beerId'])[0];
	$beerBatch->setFromArray($_POST);
	if($beerBatchManager->Save($beerBatch)){
	    $beerBatchYeastManager->DeleteAllByBeerBatchId($beerBatch->get_id());
	    //$beerAccoladeManager->DeleteAllByBeerBatchId($beerBatch->get_id());
	    
	    if(isset($_POST['yeastId'])){
	        $ii = 0;
	        while(isset($_POST['yeastId'][$ii])){
	            if($_POST['yeastId'][$ii] != ''){
    	            $id = explode("~", $_POST['yeastId'][$ii])[0];
    	            $item = new BeerBatchYeast();
    	           // $item->set_id($_POST['beerBatchYeastId'][$ii]);
    	            $item->set_beerBatchID($beerBatch->get_id());
    	            $item->set_yeastsID($id);
    	            $item->set_amount($_POST['yeastAmount'][$ii]);
    	            $beerBatchYeastManager->Save($item);
	            }
	            $ii++;
	        }
	    }
/* 	    if(isset($_POST['accoladeId'])){
	        $ii = 0;
	        while(isset($_POST['accoladeId'][$ii])){
	            if($_POST['accoladeId'][$ii] != ''){
    	            $id = explode("~", $_POST['accoladeId'][$ii])[0];
    	            $item = new BeerBatchAccolade();
    	           // $item->set_id($_POST['beerBatchYeastId'][$ii]);
    	            $item->set_beerBatchID($beerBatch->get_id());
    	            $item->set_accoladeID($id);
    	            $item->set_amount($_POST['accoladeAmount'][$ii]);
    	            $beerBatchAccoladeManager->Save($item);
	            }
	            $ii++;
	        }
	    } */
	    redirect('beerBatch_list.php');
	
	}
}
$newBatch = true;
if( null === $beerBatch ){
    if( isset($_GET['id'])){
        $beerBatch = $beerBatchManager->GetById($_GET['id']);
        if(null !== $beerBatch)$newBatch = false;
    }else{
    	$beerBatch = new BeerBatch();
    	$beerBatch->setFromArray($_POST);
    }
}else{
    $newBatch = false;
}

$yeastList = $YeastManager->GetAllActive();
$accoladeList = $AccoladeManager->GetAllActive();

$beerList = $beerManager->GetAllActiveWithLastBatchId();
$beerBatchYeasts  = $beerBatchYeastManager->GetAllByBeerBatchId($beerBatch->get_id());
$beerBatchAccolades = array();
//$beerBatchAccolades  = $beerBatchAccoladeManager->GetAllByBeerBatchId($beerBatch->get_id());

$srmList = $srmManager->getAll();
?>
	<!-- Start Header  -->
<body>
<?php
include 'top_menu.php';
?>
	<!-- End Header -->
		
	<!-- Top Breadcrumb Start -->
	<div id="breadcrumb">
		<ul>	
			<li><img src="img/icons/icon_breadcrumb.png" alt="Location" /></li>
			<li><strong>Location:</strong></li>
			<li><a href="beerBatch_list.php">My Beer Batches</a></li>
			<li>/</li>
			<li class="current">Beer Batch Form</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End --> 
	
	<!-- Right Side/Main Content Start -->
	<div id="rightside">
		<div class="contentcontainer med left">
			<p>Fields marked with <b><font color="red">*</font></b> are required.<br><br>
			<?php $htmlHelper->ShowMessage(); ?>

	<form id="beerBatchImg-form" method="POST" action="image_prompt.php?id=<?php echo $beerBatch->get_id();?>">
		<input type="hidden" name="id" value="<?php echo $beerBatch->get_id() ?>" />	
        <input type="hidden" name="targetDir" value="beerBatch/beerBatch"/>
        <input type="hidden" name="redirect" value="../beerBatch_form.php?id=<?php echo $beerBatch->get_id() ?>"/>
		<table style="width:800;border:0;cellspacing:1;cellpadding:0;">	
			<tr>
				<td style="vertical-align: middle">
					<b>Image:</b>
				</td>
				<td style="vertical-align: middle">
                   <?php 
                        $hasImg = false;
                        if(isset($beerBatch))
						{
						    $imgs = glob ( '../img/beerBatch/beerBatch'.$beerBatch->get_id().'.*' );
							if(count($imgs) > 0)
							{
							    echo '<img src="'.$imgs[0].'"></img>';
							    $hasImg = true;
							}
						}
					?> 
                	<?php if($hasImg) {?>
                		<a onclick="removeImage(<?php echo $beerBatch->get_id();?>)"><span class="tooltip"><img src="img/icons/icon_missing.png" /><span class="tooltiptext">Remove BeerBatch Image</span></span></a>
                	<?php }?>
                	<input name="save" type="submit" class="btn" value="Upload" />
				</td>
			</tr>
		</table>
	</form>
	<form id="beerBatch-form" method="POST">
		<input type="hidden" name="id" value="<?php echo $beerBatch->get_id() ?>" />

		<table style="width:800;border:0;cellspacing:1;cellpadding:0;">
			<tr>
				<td>
					<b>Beer:<font color="red">*</font></b>
				</td>
				<td>
					<?php 
					    $str = "<select id='beerId' name='beerId' class='' onchange=\"updateBatchNumber(this);\" ".(!$newBatch?"disabled":"").">\n";
						$str .= "<option value=''>Select One</option>\n";
						foreach($beerList as $item){
						    if( !$item ) continue;
						    $sel = "";
						    if( isset($beerBatch) && $beerBatch->get_beerId() == $item->get_id())  $sel .= "selected ";
						    $desc = $item->get_name();
						    $str .= "<option value='".$item->get_id()."~".($item->get_lastBatchNumber()+1)."' ".$sel.">".$desc."</option>\n";
						}
						$str .= "</select>\n";
						
						echo $str;
						// echo $htmlHelper->ToSelectList("beerId", "beerId", $beerList, "name", "id", $keg->get_beerId(), ($keg->get_onTapId()?null:"Select One"));
						
						if(!$newBatch) echo "<input type=\"hidden\" id='beerId' name='beerId' value=\"".$beerBatch->get_beerId()."\"/>";
					?>
				</td>
			</tr>
			<tr>
				<td width="100">
					Batch Number:
				</td>
				<td>
					<input type="text" id="batchNumber" class="largebox" name="batchNumber" readonly="readonly" value="<?php echo $beerBatch->get_batchNumber() ?>" />
				</td>
			</tr>
			<tr>
				<td width="100">Name:</td>
				<td>
					<input type="text" id="name" class="largebox" name="name" value="<?php echo $beerBatch->get_name() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Start Amount (<?php echo (is_unit_imperial($config[ConfigNames::DisplayUnitVolume])?"Gal":"L"); ?>): 
				</td>
				<td>
					<input type="text" id="startAmount" class="mediumbox" name="startAmount" value="<?php echo convert_Volume($beerBatch->get_startAmount(), $beerBatch->get_startAmountUnit(), $config[ConfigNames::DisplayUnitVolume], TRUE); ?>" />
					<input type="hidden" id="startAmountUnit" name="startAmountUnit" value="<?php echo $config[ConfigNames::DisplayUnitVolume]; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Current Amount (<?php echo (is_unit_imperial($config[ConfigNames::DisplayUnitVolume])?"Gal":"L"); ?>): 
				</td>
				<td>
					<input type="text" id="currentAmount" class="mediumbox" name="currentAmount" value="<?php echo convert_Volume($beerBatch->get_currentAmount(), $beerBatch->get_currentAmountUnit(), $config[ConfigNames::DisplayUnitVolume], TRUE) ?>" />
        			<input type="hidden" id="currentAmountUnit" name="currentAmountUnit" value="<?php echo $config[ConfigNames::DisplayUnitVolume]; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					Set Fermentation Temp (<?php echo $config[ConfigNames::DisplayUnitTemperature]; ?>): 
				</td>
				<td>
					<input type="text" id="fermentationTempSet" class="mediumbox" name="fermentationTempSet" value="<?php echo convert_temperature($beerBatch->get_fermentationTempSet(), $beerBatch->get_fermentationTempSetUnit(), $config[ConfigNames::DisplayUnitTemperature]) ?>" />
        			<input type="hidden" id="fermentationTempSetUnit" name="fermentationTempSetUnit" value="<?php echo $config[ConfigNames::DisplayUnitTemperature]; ?>" />
				</td>
			</tr>
			<?php if($beerBatch && ($beerBatch->get_fermentationTempMin() || $beerBatch->get_fermentationTempMax())){?>
			<tr>
				<td>
					Min Fermentation Temp (<?php echo $config[ConfigNames::DisplayUnitTemperature]; ?>): <br/>
					<?php echo convert_temperature($beerBatch->get_fermentationTempMin(), $beerBatch->get_fermentationTempMinUnit(), $config[ConfigNames::DisplayUnitTemperature]); ?>
				</td>
				<td>
					Max Fermentation Temp (<?php echo $config[ConfigNames::DisplayUnitTemperature]; ?>): <br/>
					<?php echo convert_temperature($beerBatch->get_fermentationTempMax(), $beerBatch->get_fermentationTempMaxUnit(), $config[ConfigNames::DisplayUnitTemperature]); ?>
				</td>
			</tr>
			<?php }?>
			<tr>
				<td>
					<b>SRM:</b>
				</td>
				<td>
                    <?php
					   	echo $htmlHelper->ToColorSelectList("srm", "srm", $srmList, "srm", "srm", $beerBatch->get_srm(), "Select SRM", "", "rgb"); 
					?>							
				</td>
			</tr>
			<tr>
				<td>
					<b>IBU:</b>
				</td>
				<td>
					<input type="text" id="ibu" class="xsmallbox" name="ibu" value="<?php echo $beerBatch->get_ibu() ?>" />
				</td>
			</tr>
            <tr >
            	<td colspan="2">
                ABV is fixed value and overrides OG/FG.
                If ABV not filled in and OG/FG are, ABV will be calculated
                </td>
            </tr>
            <tr>
                <td>
                    <b>ABV:</b>
                </td>
                <td>
                    <input type="text" id="abv" class="smallbox" name="abv" value="<?php echo $beerBatch->get_abv() ?>" />
                </td>
            </tr>
			<tr>
				<td>
					<b>OG:</b>
				</td>
				<td>
					<input type="text" id="og" class="smallbox" name="og" value="<?php echo convert_gravity($beerBatch->get_og(), $beerBatch->get_ogUnit(), $config[ConfigNames::DisplayUnitGravity]); ?>" /> <?php echo $config[ConfigNames::DisplayUnitGravity]; ?>
					<input type="hidden" name="ogUnit" value="<?php echo $config[ConfigNames::DisplayUnitGravity]; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<b>FG:</b>
				</td>
				<td>
					<input type="text" id="fg" class="smallbox" name="fg" value="<?php echo convert_gravity($beerBatch->get_fg(), $beerBatch->get_fgUnit(), $config[ConfigNames::DisplayUnitGravity]); ?>" /> <?php echo $config[ConfigNames::DisplayUnitGravity]; ?>
					<input type="hidden" name="fgUnit" value="<?php echo $config[ConfigNames::DisplayUnitGravity]; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<b>Rating:</b>
				</td>
				<td>
					<input type="text" id="fg" class="smallbox" name="rating" value="<?php echo $beerBatch->get_rating() ?>" />
				</td>
            </tr>
            <tr>
				<td>
					<b>Tasting<br>Notes:</b>
				</td>
				<td>
					<textarea id="notes" class="text-input textarea" style="width:320px;height:80px" name="notes"><?php echo $beerBatch->get_notes() ?></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<h3 style="align-content:center">Yeast</h3>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<table id="yeastList">
						<tr style="width:100%">
							<td><strong>Name</strong></td>
							<td><strong>Amount</strong></td>
							<td><strong>Strand</strong></td>
							<td><strong>Format</strong></td>
						</tr>
                        <?php 
						if( count($beerBatchYeasts) == 0 ){  
						  $beerBatchYeasts[] = new BeerBatchYeast();
						}
						$ii = 0;
						foreach ($beerBatchYeasts as $beerBatchYeast){
						?>
    						<tr style="width:100%">
    						<td>
							<input type="hidden" id="beerBatchYeastId" name="beerBatchYeastId[]" value="<?php echo $beerBatchYeast->get_id(); ?>"/>                     
							<?php 					
							    $str = "<select id='yeastId".$ii++."' name='yeastId[]' class='' onChange='toggleDisplay(this, 2)'>\n";
                                $str .= "<option value=''>Select One</option>\n";
                                foreach($yeastList as $item){
                                    if( !$item ) continue;
                                    $sel = "";
                                    if( $beerBatchYeast && $beerBatchYeast->get_yeastsID() == $item->get_id() ){
                                        $sel .= "selected ";
                                        $beerBatchYeast->set_yeast($item);
                                    }
                                    $desc = $item->get_name();
									$str .= "<option value='".$item->get_id()."~".$item->get_name()."~".$item->get_strand()."~".$item->get_format()."' ".$sel.">".$desc."</option>\n";
                                }					
                                $str .= "</select>\n";
                                                        
                                echo $str;
                            ?>
                            </td>
    						<td><input type="text" id="yeastAmount" class="meddiumbox" name="yeastAmount[]" value="<?php echo $beerBatchYeast->get_amount() ?>"/></td>
    						<td><input type="text" disabled id="yeastStrand" class="meddiumbox" name="yeastStrand[]" value="<?php echo $beerBatchYeast->get_yeast()->get_strand() ?>"/></td>
    						<td><input type="text" disabled id="yeastFormat" class="meddiumbox" name="yeastFormat[]" value="<?php echo $beerBatchYeast->get_yeast()->get_format() ?>"/></td>
    						<td style="width:10%;vertical-align: middle;">
                                <button name="delete" type="button" class="btn" style="white-space:nowrap" value="<?php echo $beerBatch->get_id()?>" onClick="removeRow(this)">Delete</button>
                            </td>
    					</tr>
					<?php
						}
					?>
					</table>
				</td>
			</tr>
			<tr> 
				<td>	
	 				<input type="button" id="newRow1" name="newRow2" class="btn" value="Add Yeast" onclick="addRow('yeastList')" />
				</td>
			</tr>
			<?php if(false){?>
			<tr>
				<td colspan="4">
					<h3 style="align-content:center">Accolades</h3>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<table id="accoladeList">
						<tr style="width:100%">
							<td><strong>Name</strong></td>
							<td><strong>Amount</strong></td>
						</tr>
                        <?php 
                        if( count($beerBatchAccolades) == 0 ){  
						  $beerBatchAccolades[] = new BeerAccolade();
						}
						foreach ($beerBatchAccolades as $beerBatchAccolade){
						?>
    						<tr style="width:100%">
    						<td>
							<input type="hidden" id="beerBatchAccoladeId" name="beerBatchAccoladeId[]" value="<?php echo $beerBatchAccolade->get_id(); ?>"/>                     
							<?php 	
							   $selStyle = '';
							   $str = '';
							   $str .= "<option value=''>Select One</option>\n";
                                foreach($accoladeList as $item){
                                    if( !$item ) continue;
                                    $sel = "";
                                    if( $beerBatchAccolade && $beerBatchAccolade->get_accoladeID() == $item->get_id() ){
                                        $sel .= "selected ";
                                        $beerBatchAccolade->set_accolade($item);
                                        $selStyle = "style=\"background-color:rgb(".$item->get_rgb().")\"";
                                    }
                                    $desc = $item->get_name();
                                    $str .= "<option value='".$item->get_id()."~".$item->get_name()."' ".$sel." style=\"background-color:rgb(".$item->get_rgb().")\">".$desc."</option>\n";
                                }					
                                $str .= "</select>\n";
                                $selStr = "<select id='accoladeId".$ii."' $selStyle name='accoladeId[]' class='' onChange='toggleDisplay(this, 2); this.style.backgroundColor=this.children[this.selectedIndex].style.backgroundColor;'>\n".$str;
                                                        
                                echo $selStr;
                            ?>
                            </td>
    						<td><input type="text" id="accoladeAmount" class="meddiumbox" name="accoladeAmount[]" value="<?php echo $beerBatchAccolade->get_amount() ?>"/></td>
    						<td style="width:10%;vertical-align: middle;">
                                <button name="delete" type="button" class="btn" style="white-space:nowrap" value="<?php echo $beerBatch->get_id()?>" onClick="removeRow(this)">Delete</button>
                            </td>
    					</tr>
					<?php
						}
					?>
					</table>
				</td>
			</tr>
			<tr> 
				<td>	
	 				<input type="button" id="newRow1" name="newRow2" class="btn" value="Add Accolade" onclick="addRow('accoladeList')" />
				</td>
			</tr>
			<?php }?>
			<tr>
				<td colspan="2">
					<input name="save" type="submit" class="btn" value="Save" />
					<input type="button" class="btn" value="Cancel" onClick="window.location='beerBatch_list.php'" />
				</td>
			</tr>								
		</table>
		<br />
		<div align="right">			
			&nbsp; &nbsp; 
		</div>

	</form>
	</div>
	<!-- End On Tap Section -->

	<!-- Start Footer -->   
<?php 
require __DIR__.'/footer.php';
?>

	<!-- End Footer -->
		
	</div>
	<!-- Right Side/Main Content End -->
	<!-- Start Left Bar Menu -->   
<?php 
require __DIR__.'/left_bar.php';
?>
	<!-- End Left Bar Menu -->  
	<!-- Start Js  -->
<?php
require __DIR__.'/scripts.php';
?>

<script>
	$(function() {		
		
		$('#beerBatch-form').validate({
		rules: {
			batchNumber: { required: true },		
			name: { required: false },		
			srm: { required: false, number: true },
			ibu: { required: false, number: true },
			abv: { required: false, number: true },
			og: { required: false, number: true },
			fg: { required: false, number: true },
			rating: { required: false, number: true }
		}
		});
		
	});
</script>

<script type='text/javascript'>
	function changeVisibleStyleList(radioBtn, divId)
	{
		var sytleListDiv = document.getElementById("styleListsDiv");
		var allDivs = sytleListDiv.getElementsByTagName('div');
		for(i = 0; i < allDivs.length; i++)
		{
			allDivs[i].style.display = "none";
		}
		document.getElementById(divId).style.display = (radioBtn.checked==true?"":"none");
	}
	function setInputValue(inputId, selectElem)
	{
		document.getElementById(inputId).value = selectElem.value;
	}

	function toggleDisplay(selectObject, numConfigs) {
		var selArr = selectObject.value.split("~");
		var curTD = $(selectObject).parent().get(0);
		for(ii = 0; ii < numConfigs; ii++){
			curTD = $(curTD).next('td');
			if(curTD == null) break;
		}
		//Select array is id~name~data1~data2...
		for(ii = 2; ii < selArr.length; ii++){
			var inputs = $(curTD).find("input");
			if(inputs.length == 0)break;
			$(inputs).each(function() {
		        var valArr = selArr[ii].split("|");
		        this.value = valArr[0];
		        if(valArr.length > 1){
					this.style.backgroundColor = "rgb("+valArr[1]+")";
		        }
		    });

			curTD = $(curTD).next('td');
			if(curTD == null) break;
		}
	}

	function getRowStructure(tableName){
        	var rowStructure = $('#'+tableName).find('tr:eq(1)').clone();
        	rowStructure.find('input, select').each(function(){this.value="";});
        	rowStructure.find('select').each(function(){this.value=-1; this.style.backgroundColor=""});
        	return rowStructure;
	}
	function addRow(tableName){		
		var $table = $('#'+tableName)
		$table.append(getRowStructure(tableName).clone());
		if($("#pendingChangesDiv")[0] != null)$("#pendingChangesDiv")[0].style.display="";
	}
	function removeRow(btn){		
		$(btn).closest('tr').remove();
		if($("#pendingChangesDiv")[0] != null)$("#pendingChangesDiv")[0].style.display="";
	}
	function removeImage(id){
	    var form = document.createElement("form");
	    var element2 = document.createElement("input"); 
	    form.method = "POST";
	    form.action = "image_remove.php?id="+id+"&type=beerBatch";   
	    element2.value="beerBatch_form.php?id="+id;
	    element2.name="redirect";
	    form.appendChild(element2);  
	    document.body.appendChild(form);

	    form.submit();
  	}
	function updateBatchNumber(select){
		var beerArr = select.value.split("~");
		document.getElementById("batchNumber").value = parseFloat(beerArr[1])
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
