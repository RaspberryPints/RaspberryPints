<?php
require_once __DIR__.'/header.php';
$htmlHelper = new HtmlHelper();
$beerStyleManager = new BeerStyleManager();
//$config = getAllConfigs();
if (isset($_POST['inactivateBeerStyle'])) {
    $beerStyleManager->Inactivate($_POST['id']);		
}

$beerStyles = $beerStyleManager->GetAllActive();
?>
	<!-- Start Header  -->
<body>
<script >

function filterBeer(searchTextElement){
	$("p:not(:contains('"+searchTextElement.value+"'))").parent().map(function() {
	    if(!$(this).is("th")) return 
	    $(this).parent().hide();
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
			<li class="current">Beer Styles</li>            
		</ul>
	</div>
	<!-- Top Breadcrumb End --> 
	
	<!-- Right Side/Main Content Start -->
<div id="rightside">
	<div class="contentcontainer lg left">
    	<div class="headings alt">
			<h2>Beer Styles</h2>
		</div>
		<div class="contentbox" style="width:770px;">
		
			<!-- Start On Tap Section -->
			
			<?php $htmlHelper->ShowMessage(); ?>
			
			<input type="submit" class="btn" value="Add a Beer Style" onClick="window.location='beer_style_form.php'" />
			<input type="submit" class="btn" value="Add with BeerStyleXML" onClick="window.location='beer_style_form_xml.php'" />
			<br/><br/>
			<?php if( count($beerStyles) != 0 ){	?>
        		Search:<input type="text" id="search" class="largebox" name="search" value="" onkeyup="filterBeer(this);" />
        	<?php } ?>
			<table style="width:770px; padding:0px" class="outerborder" id="beersTable">
<!--				<thead>
					<tr>
						<th style="width:30%">Name</th>
						<th style="width:10%">Category</th>
						<th style="width:10%">Catelog Number</th>
						<th style="width:30%">Beer Style List</th>
						<th style="width:10%"></th>
						<th style="width:10%"></th>
					</tr>
				</thead>-->
				<tbody>
					<?php 
					if( count($beerStyles) == 0 ){  
					?>
							<tr><td class="no-results" colspan="99">No Beer Styles :( Add some?</td></tr>
					<?php 
						}else{
						    foreach ($beerStyles as $beerStyle){
					?>
								<tr class="intborder" >
									<th style="width:30%; vertical-align:middle;">
										<p style="font-size:24px; font-weight:bold; width:300px; overflow:hidden"><?php echo $beerStyle->get_name() ?></p>
									</th>
									<th style="width:10%; vertical-align: middle;">
										<?php echo $beerStyle->get_category() ?>
									</th>
									<th style="width:10%; vertical-align: middle;">
										<?php echo $beerStyle->get_catNum() ?>
									</th>
									<th style="width:30%; vertical-align: middle;">
										<?php echo $beerStyle->get_beerStyleList() ?>
									</th>
									<th style="width:10%; text-align: center; vertical-align: middle; margin: 0; padding: 0;">
										<input name="editBeerStyle" type="button" class="btn" value="Edit" style="text-align: center; margin: 0;" onClick="window.location='beer_style_form.php?id=<?php echo $beerStyle->get_id()?>'" />
									</th>
									<th style="width:10%; text-align: center; vertical-align: middle; margin: 0; padding: 0">
										<form method="POST">
											<input type='hidden' name='id' value='<?php echo $beerStyle->get_id()?> '/>
											<input class="inactivateBeer btn" style="text-align: center; margin: 0;" name="inactivateBeerStyle" type="submit" value="Delete" />
										</form>
									</th>
								</tr>
					<?php 
							}
						}
					?>
				</tbody>
			</table><br>
			<input type="submit" class="btn" value="Add a Beer Style" onClick="window.location='beer_style_form.php'" />
			<input type="submit" class="btn" value="Add with BeerStyleXML" onClick="window.location='beer_style_form_xml.php'" />
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
include 'scripts.php';
?>
<script>
	$(function(){
		$('.inactivateBeer').on('click', function(){
			if(!confirm('Are you sure you want to delete this beer?')){
				return false;
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
