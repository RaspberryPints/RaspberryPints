<?php
require_once __DIR__.'/header.php';
$htmlHelper = new HtmlHelper();
$beerManager = new BeerManager();
$beerStyleManager = new BeerStyleManager();
$breweryManager = new BreweryManager();
$srmManager = new SrmManager();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$beer = new Beer();
	$beer->setFromArray($_POST);
	if($beerManager->Save($beer))
		redirect('beer_list.php');
}

if( isset($_GET['id'])){
	$beer = $beerManager->GetById($_GET['id']);
}else{
	$beer = new Beer();
	$beer->setFromArray($_POST);
}

$breweryList = $breweryManager->GetAllActive();
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
			<li><a href="beer_list.php">My Beers</a></li>
			<li>/</li>
			<li class="current">Beer Form</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End --> 
	
	<!-- Right Side/Main Content Start -->
	<div id="rightside">
		<div class="contentcontainer med left">
			<p>Fields marked with <b><font color="red">*</font></b> are required.<br><br>
			<?php $htmlHelper->ShowMessage(); ?>

	<form id="beer-form" method="POST">
		<input type="hidden" name="id" value="<?php echo $beer->get_id() ?>" />
		<input type="hidden" name="active" value="<?php echo $beer->get_active() ?>" />

		<table width="800" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="100">
					<b>Name:<font color="red">*</font></b>
				</td>
				<td>
					<input type="text" id="name" class="largebox" name="name" value="<?php echo $beer->get_name() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<b>UnTappd Beer ID:</b>
				</td>
				<td>
					<input type="text" id="untID" class="smallbox" name="untID" value="<?php echo $beer->get_untID() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<b>Brewery:</b>
				</td>
				<td>
					<?php echo $htmlHelper->ToSelectList("breweryId", "breweryId", $breweryList, "name", "id", $beer->get_breweryId(), "Select One"); ?>
				</td>
			</tr>
			<tr>
				<td rowspan=2>
					<b>Style:</b>
				</td>
				<td>
		          Beer style list: <br>
		          <?php 
						$beerStyleLists = $beerStyleManager->GetBeerStyleList();
						$beersStyle = $beerStyleManager->GetById($beer->get_beerStyleId());
						$beersStyleList=""; 
						foreach($beerStyleLists as $styleList)
						{ 
							$selected = "";
							$styleId = preg_replace('/\s+/', '', $styleList);
							if($beersStyle && $styleList == $beersStyle->get_beerStyleList())
							{
								$selected = "checked";
								$beersStyleList = $styleId;
							}
							echo "$styleList<input type=\"radio\" name=\"beerStyleList\" id='styleListBtn$styleId' value=\"$styleId\" $selected onclick=\"changeVisibleStyleList(this, 'styleListDiv$styleId');\" />&nbsp;\n";
						}
		         ?>
                 
		         </td>
			</tr>
			<tr>
				<td>
				  	<div id="styleListsDiv">
		          	<?php 
						echo "<input type=\"hidden\" name=\"beerStyleId\" id=\"beerStyleId\" value=\"".$beer->get_beerStyleId()."\" />";
						foreach($beerStyleLists as $styleList)
						{ 	
							$styleId = preg_replace('/\s+/', '', $styleList);
				  			echo "<div id=\"styleListDiv$styleId\" ".($beersStyleList!=$styleId?"style=\"display:none\"":""). " >";
							$beerStyleList = $beerStyleManager->GetAllByList($styleList); 
							echo $htmlHelper->ToCombinedSelectList("beerStyleId$styleId", $beerStyleList, "catNum", "name", "id", 
																	$beer->get_beerStyleId(), "Select One", "", "setInputValue('beerStyleId', this)"); 
							
		          			echo "</div>";
						}
					?>
                    </div>
				</td>
			</tr>
			<tr>
				<td>
					<b>SRM:</b>
				</td>
				<td>
                    <?php
					   	echo $htmlHelper->ToColorSelectList("srm", "srm", $srmList, "srm", "srm", $beer->get_srm(), "Select SRM", "", "rgb"); 
					?>							
				</td>
			</tr>
			<tr>
				<td>
					<b>IBU:</b>
				</td>
				<td>
					<input type="text" id="ibu" class="xsmallbox" name="ibu" value="<?php echo $beer->get_ibu() ?>" />
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
                    <input type="text" id="abv" class="smallbox" name="abv" value="<?php echo $beer->get_abv() ?>" />
                </td>
            </tr>
			<tr>
				<td>
					<b>OG:</b>
				</td>
				<td>
					<input type="text" id="og" class="smallbox" name="og" value="<?php echo $beer->get_og() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<b>FG:</b>
				</td>
				<td>
					<input type="text" id="fg" class="smallbox" name="fg" value="<?php echo $beer->get_fg() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<b>Rating:</b>
				</td>
				<td>
					<input type="text" id="fg" class="smallbox" name="rating" value="<?php echo $beer->get_rating() ?>" />
				</td>
            </tr>
            <tr>
				<td>
					<b>Tasting<br>Notes:</b>
				</td>
				<td>
					<textarea type="text" id="notes" class="text-input textarea" style="width:320px;height:80px" name="notes"><?php echo $beer->get_notes() ?></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<h3><center>Fermentables</center></h3>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<table width = "100%">
						<tr width="100%">
							<td><strong>Name</strong></td>
							<td><strong>Type</strong></td>
							<td><strong>Amount</strong></td>
							<td><strong>SRM</strong></td>
						</tr>
					<?php 
						if( !isset($beerFermentables) || count($beerFermentables) == 0 ){  
					?>
							<tr><td class="no-results" colspan="99">No Fermentables :( Add some?</td></tr>
					<?php 
						}else{
							foreach ($beerFermentables as $beerFermentable){
							?>
							<tr width="100%">
							<td><?php echo $beerFermentable->get_name() ?></td>
							<td><?php echo $beerFermentable->get_type() ?></td>
							<td><?php echo $beerFermentable->get_amount() ?></td>
							<td><?php echo $beerFermentable->get_srm() ?></td>
						</tr>
						<?php
							}
						}
					?>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<h3><center>Hops</center></h3>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<table width="100%">
						<tr width="100%">
							<td><strong>Name</strong></td>
							<td><strong>Alpha</strong></td>
							<td><strong>Amount</strong></td>
							<td><strong>Time</strong></td>
						</tr>
					<?php 
						if( !isset($beerHops) || count($beerHops) == 0 ){  
					?>
							<tr><td class="no-results" colspan="99">No Hops :( Add some?</td></tr>
					<?php 
						}else{
							foreach ($beerHops as $beerHop){
							?>
							<tr width="100%">
							<td><?php echo $beerHop->get_name() ?></td>
							<td><?php echo $beerHop->get_alpha() ?></td>
							<td><?php echo $beerHop->get_amount() ?></td>
							<td><?php echo $beerHop->get_time() ?></td>
						</tr>
						<?php
							}
						}
					?>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<h3><center>Misc</center></h3>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<table>
						<tr width="100%">
							<td><strong>Name</strong></td>
							<td><strong>Type</strong></td>
							<td><strong>Use</strong></td>
							<td><strong>Time</strong></td>
						</tr>
                        <?php 
						if( !isset($beerMiscs) || count($beerMiscs) == 0 ){  
						?>
							<!--<tr><td class="no-results" colspan="99">No Misc :( Add some?</td></tr>-->
						<?php 
						}else{
							foreach ($beerMiscs as $beerMisc){
							?>
							<tr width="100%">
							<td><?php echo $beerMisc->get_name() ?></td>
							<td><?php echo $beerMisc->get_type() ?></td>
							<td><?php echo $beerMisc->get_use() ?></td>
							<td><?php echo $beerMisc->get_time() ?></td>
						</tr>
						<?php
							}
						}
						?>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<h3><center>Yeast</center></h3>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<table>
						<tr width="100%">
							<td><strong>Name</strong></td>
							<td><strong>Type</strong></td>
							<td><strong>Form</strong></td>
							<td><strong>Code</strong></td>
						</tr>
                        <?php 
						if( !isset($beerYeasts) || count($beerYeasts) == 0 ){  
						?>
							<!--<tr><td class="no-results" colspan="99">No Misc :( Add some?</td></tr>-->
						<?php 
						}else{
							foreach ($beerYeasts as $beerYeast){
							?>
							<tr width="100%">
							<td><?php echo $beerYeast->get_name() ?></td>
							<td><?php echo $beerYeast->get_type() ?></td>
							<td><?php echo $beerYeast->get_form() ?></td>
							<td><?php echo $beerYeast->get_code() ?></td>
						</tr>
						<?php
							}
						}
						?>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input name="save" type="submit" class="btn" value="Save" />
					<input type="button" class="btn" value="Cancel" onClick="window.location='beer_list.php'" />
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
		
		$('#beer-form').validate({
		rules: {
			name: { required: true },
			style: { required: false },			
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
