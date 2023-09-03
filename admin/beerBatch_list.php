<?php
require_once __DIR__.'/header.php';
$htmlHelper = new HtmlHelper();
$beerManager = new BeerManager();
$beerBatchManager = new BeerBatchManager();
$config = getAllConfigs();
if (isset($_POST['inactivateBeerBatch'])) {
	$beerBatchManager->Inactivate($_POST['id']);		
}

$beer = null;
if(isset($_GET['id'])) {
    $beerBatches = $beerBatchManager->GetAllActiveByBeerId($_GET['id']);
    $beer = $beerManager->GetByID($_GET['id']);
}else{
    $beerBatches = $beerBatchManager->GetAllActive();
}
?>
	<!-- Start Header  -->
<body>
<script >
function toggleBeerBatchInfo(callingElement, beerBatchId) {
    var imageTh = document.getElementById("beerBatchImg"+beerBatchId);
	toggleElementDisplay(imageTh, "beerBatchInfo"+beerBatchId );
	toggleElementDisplay(imageTh, "beerBatchNotes"+beerBatchId );
}
function toggleElementDisplay(callingElement, elementToToggle) {
	var div = document.getElementById(elementToToggle);
	if(div != null){
		if(div.style.display == ""){
			div.style.display = "none";
			if(callingElement != null)callingElement.style.backgroundImage = "url(img/bg_expander_plus.png)"
		}else{
			div.style.display = "";
			if(callingElement != null)callingElement.style.backgroundImage = "url(img/bg_expander_minus.png)"
		}
	}
}

function filterBeerBatch(searchTextElement){
	$("p:not(:contains('"+searchTextElement.value+"'))").parent().map(function() {
	    if(!$(this).is("th")) return 
	    $(this).siblings("th[id^=beerBatchImg]").css('background-image', 'url(img/bg_expander_plus.png)')
	    $(this).parent().hide();
	    $(this).parent().next("tr").hide();
	    $(this).parent().next("tr").next("tr").hide();
	  });
	$("p:contains('"+searchTextElement.value+"')").parent().map(function() {
	    if(!$(this).is("th")) return 
	    $(this).parent().show();
	  });
}
</script>
<?php
include 'top_menu.php';
?>
	<!-- End Header -->
		
	<!-- Top Breadcrumb Start -->
	<div id="breadcrumb">
		<ul>	
			<li><img src="img/icons/icon_breadcrumb.png" alt="Location" /></li>
			<li><strong>Location:</strong></li>
			<li class="current">My Beer Batches</li>            
		</ul>
	</div>
	<!-- Top Breadcrumb End --> 
	
	<!-- Right Side/Main Content Start -->
<div id="rightside">
	<div class="contentcontainer lg left" <?php if($beer)echo "style=\"width:100%\""; ?>>
    	<div class="headings alt">
			<h2><?php echo ((!isset($_GET['id']) || !$beer)?"Beer":$beer->get_name());?> Batches</h2>
		</div>
		<div class="contentbox">
		
			<!-- Start On Tap Section -->
			
			<?php $htmlHelper->ShowMessage(); ?>
			
			<input type="submit" class="btn" value="Add a Beer Batch" onClick="window.location='beerBatch_form.php<?php if($beer) echo "?beerId=".$beer->get_id();?>'" />
			<?php if($beer) {?>
			<input type="submit" class="btn" value="View All" onClick="window.location='beerBatch_list.php'" />
        	<?php } ?>
			<br/><br/>
			<?php if( count($beerBatches) != 0 && !$beer){	?>
        		Search:<input type="text" id="search" class="largebox" name="search" value="" onkeyup="filterBeerBatch(this);" />
        	<?php } ?>
			<table style="width:770px; padding:0px" class="outerborder" id="beerBatchesTable">
<!--				<thead>
					<tr>
						<th style="width:28%">Name</th>
						<th style="width:10%">Vitals</th>
						<th style="width:22%">Yeast/Water/etc</th>
						<th style="width:40%" colspan="3">Hop Additions</th>
					</tr>
				</thead>-->
				<tbody>
					<?php 
						if( count($beerBatches) == 0 ){  
					?>
							<tr><td class="no-results" colspan="99">No Beer Batches :( Add some?</td></tr>
					<?php 
						}else{
						    if( !$beer){
						    foreach ($beerBatches as $beerBatch){
					?>
								<tr class="intborder collapsed heading" onClick="toggleBeerBatchInfo(this, '<?php echo $beerBatch->get_id()?>')" >
									<th style="width:70%; vertical-align:middle;">
										<p style="font-size:24px; font-weight:bold; width:400px; overflow:hidden"><?php echo !$beer?$beerBatch->get_displayName():($beerBatch->get_name()?$beerBatch->get_name():$beerBatch->get_batchNumber()) ?></p>
									</th>
									<th style="width:10%; text-align: center; vertical-align: middle; margin: 0; padding: 0;">
										<input name="editBeerBatch" type="button" class="btn" value="Edit" style="text-align: center; margin: 0;" onClick="window.location='beerBatch_form.php?id=<?php echo $beerBatch->get_id()?>'" />
									</th>
									<th style="width:10%; text-align: center; vertical-align: middle; margin: 0; padding: 0">
										<form method="POST">
											<input type='hidden' name='id' value='<?php echo $beerBatch->get_id()?> '/>
											<input class="inactivateBeerBatch btn" style="text-align: center; margin: 0;" name="inactivateBeerBatch" type="submit" value="Delete" />
										</form>
									</th>
									<th id="beerBatchImg<?php echo $beerBatch->get_id()?>" style="width:10%; text-align: center; vertical-align: middle; margin: 0; padding: 0;
									      background: url(img/bg_expander_plus.png) no-repeat center;  background-color: #e0e0e0; background-position: 0 -10px; background-position-y: center; " >
									</th>
								</tr>
								<tr class="intborder thick" id="beerBatchInfo<?php echo $beerBatch->get_id() ?>" style="display:none">
									<td>
                                        <br>
                                        <b>SRM:</b>
										<?php
											if ( $beerBatch->get_srm() != 0 )
												echo  $beerBatch->get_srm();
											else
												echo "N/A";
										?>
                                        <br>
                                        <b>IBU:</b>
										<?php
											if ( $beerBatch->get_ibu() != 0 )
												echo $beerBatch->get_ibu();
											else
												echo "N/A";
										?>
                                        <br>
                                        <b>ABV:</b>
										<?php
											if ( $beerBatch->get_abv() != 1 && $beerBatch->get_abv() != 0 )
												echo $beerBatch->get_abv() ;
											else
												echo "N/A";
										?>
                                        <p>
                                        <b>OG:</b>
										<?php
											if ( $beerBatch->get_og() != 1 && $beerBatch->get_og() != 0 )
											    echo convert_gravity($beerBatch->get_og(), $beerBatch->get_ogUnit(), $config[ConfigNames::DisplayUnitGravity]) ;
											else
												echo "N/A";
										?>
                                        <br>
                                        <b>FG:</b>
										<?php
											if ( $beerBatch->get_fg() != 1 && $beerBatch->get_fg() != 0 )
											    echo  convert_gravity($beerBatch->get_fg(), $beerBatch->get_fgUnit(), $config[ConfigNames::DisplayUnitGravity]);
											else
												echo "N/A";
										?>
                                        </p>
										
									</td>
									<td colspan="3">
										<p style="padding-bottom: 1px"><b style="text-decoration: underline;">Yeast:</b></p><p>
						                    <?php 
						                      $yeasts = $beerBatchManager->GetYeasts($beerBatch->get_id());
						                      foreach($yeasts as $yeast){
						                          echo $yeast->get_name() . "<br>";
						                      }
						                    ?>
										</p>
									</td>
								</tr>
					
								<tr class="intborder" id="beerBatchNotes<?php echo $beerBatch->get_id() ?>" style="display:none">
									<td colspan="2">
										<?php
										if(strlen($beerBatch->get_notes()) < 200){
										  echo $beerBatch->get_notes() ;
										}else{
										    echo substr($beerBatch->get_notes(), 0, 200) .' ...';										      
										}
										?>
									</td>
									
									<td style="width:5%; text-align: center;">
										<input name="editBeerBatch" type="button" class="btn" value="Edit" onClick="window.location='beerBatch_form.php?id=<?php echo $beerBatch->get_id()?>'" />
									</td>
									<td  style="width:5%; text-align: center;">
										<form method="POST">
											<input type='hidden' name='id' value='<?php echo $beerBatch->get_id()?>'/>
											<input class="inactivateBeerBatch btn" name="inactivateBeerBatch" type="submit" value="Delete" />
										</form>
									</td>
								</tr>
					<?php 
							}
					    }else {
					        ?>
					        <tr class="intborder">
					  			<?php foreach ($beerBatches as $beerBatch){ ?>
									<th style="vertical-align:middle;">
										<p style="font-size:24px; font-weight:bold; overflow:hidden"><?php echo !$beer?$beerBatch->get_displayName():($beerBatch->get_name()?$beerBatch->get_name():$beerBatch->get_batchNumber()) ?></p>
									</th>
								<?php } ?>
							</tr>
							<tr class="intborder">
					  			<?php foreach ($beerBatches as $beerBatch){ ?>
									<td>
                                        <b>SRM:</b>
										<?php
											if ( $beerBatch->get_srm() != 0 )
												echo  $beerBatch->get_srm();
											else
												echo "N/A";
										?>
										</td>
								<?php } ?>
							</tr>
							<tr class="intborder">
					  			<?php foreach ($beerBatches as $beerBatch){ ?>
									<td>
                                        <b>IBU:</b>
										<?php
											if ( $beerBatch->get_ibu() != 0 )
												echo $beerBatch->get_ibu();
											else
												echo "N/A";
										?>
										</td>
								<?php } ?>
							</tr>
							<tr class="intborder">
					  			<?php foreach ($beerBatches as $beerBatch){ ?>
									<td>
                                        <b>ABV:</b>
										<?php
											if ( $beerBatch->get_abv() != 1 && $beerBatch->get_abv() != 0 )
												echo $beerBatch->get_abv() ;
											else
												echo "N/A";
										?>
										</td>
								<?php } ?>
							</tr>
							<tr class="intborder">
					  			<?php foreach ($beerBatches as $beerBatch){ ?>
									<td>
                                        <b>OG:</b>
										<?php
											if ( $beerBatch->get_og() != 1 && $beerBatch->get_og() != 0 )
											    echo convert_gravity($beerBatch->get_og(), $beerBatch->get_ogUnit(), $config[ConfigNames::DisplayUnitGravity]) ;
											else
												echo "N/A";
										?>
										</td>
								<?php } ?>
							</tr>
							<tr class="intborder">
					  			<?php foreach ($beerBatches as $beerBatch){ ?>
									<td>
                                        <b>FG:</b>
										<?php
											if ( $beerBatch->get_fg() != 1 && $beerBatch->get_fg() != 0 )
											    echo  convert_gravity($beerBatch->get_fg(), $beerBatch->get_fgUnit(), $config[ConfigNames::DisplayUnitGravity]);
											else
												echo "N/A";
										?>
										</td>
								<?php } ?>
							</tr>
							<tr class="intborder">
					  			<?php foreach ($beerBatches as $beerBatch){ ?>
									<td>
										<p style="padding-bottom: 1px"><b style="text-decoration: underline;">Yeast:</b></p><p>
						                    <?php 
						                      $yeasts = $beerBatchManager->GetYeasts($beerBatch->get_id());
						                      foreach($yeasts as $yeast){
						                          echo $yeast->get_name() . "<br>";
						                      }
						                    ?>
										</p>
										</td>
								<?php } ?>
								</tr>
								<tr class="intborder">
					  			<?php foreach ($beerBatches as $beerBatch){ ?>
									<td>
										<p style="padding-bottom: 1px"><b style="text-decoration: underline;">Notes:</b></p><p>
										<?php
										if(strlen($beerBatch->get_notes()) < 200){
										  echo $beerBatch->get_notes() ;
										}else{
										    echo substr($beerBatch->get_notes(), 0, 200) .' ...';										      
										}
										?>
									</td>
								<?php } ?>
								</tr>
					        
					        <?php 
					    }
					}
					?>
				</tbody>
			</table><br>
			<input type="submit" class="btn" value="Add a Beer Batch" onClick="window.location='beerBatch_form.php<?php if($beer) echo "?beerId=".$beer->get_id();?>'" />
			<?php if($beer) {?>
			<input type="submit" class="btn" value="View All" onClick="window.location='beerBatch_list.php'" />
        	<?php } ?>
		</div>
	</div>
	<!-- Start Footer -->   
	<?php
	include 'footer.php';
	?>
	<!-- End Footer -->
</div>
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
	$(function(){
		$('.inactivateBeerBatch').on('click', function(){
			if(!confirm('Are you sure you want to delete this beer batch?')){
				return false;
			}
		});
	});
	<?php if($beer) { ?>
	window.onload = function(){
		tables = document.getElementsByTagName("table")
		for (var i = 0; i < tables.length; i++) {
		    var table = tables[i];		
			maxWidth = -1;
			//Start at 1 to avoid header row
			for (var j = 1; j < table.rows[0].cells.length; j++) {
			    var col = table.rows[0].cells[j];		
				if( col.offsetWidth > maxWidth ) maxWidth = col.offsetWidth;
			}
			if( maxWidth > 0 ){
				for (var j = 0; j < table.rows[0].cells.length; j++) {
				    var col = table.rows[0].cells[j];	
				    col.width = maxWidth + 'px';
				}
			}
		}

	}

	<?php } ?>
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
