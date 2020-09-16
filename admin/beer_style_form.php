<?php
require_once __DIR__.'/header.php';
require_once __DIR__.'/../includes/functions.php';

$htmlHelper = new HtmlHelper();
$beerStyleManager = new BeerStyleManager();
$srmManager = new SrmManager();
$beerStyle = null;
$config = getAllConfigs();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $beerStyle = new BeerStyle();
    $beerStyle->setFromArray($_POST);
    if($beerStyleManager->Save($beerStyle)){
	    redirect('beer_style_list.php');
	}
}

if( null === $beerStyle ){
    if( isset($_GET['id'])){
        $beerStyle = $beerStyleManager->GetById($_GET['id']);
    }else{
        $beerStyle = new BeerStyle();
        $beerStyle->setFromArray($_POST);
        if(null === $beerStyle->get_srmMin())$beerStyle->set_srmMin(0);
        if(null === $beerStyle->get_srmMax())$beerStyle->set_srmMax(0);
        if(null === $beerStyle->get_abvMin())$beerStyle->set_abvMin(0);
        if(null === $beerStyle->get_abvMax())$beerStyle->set_abvMax(0);
        if(null === $beerStyle->get_ibuMin())$beerStyle->set_ibuMin(0);
        if(null === $beerStyle->get_ibuMax())$beerStyle->set_ibuMax(0);
        if(null === $beerStyle->get_ogMin())$beerStyle->set_ogMin(0);
        if(null === $beerStyle->get_ogMax())$beerStyle->set_ogMax(0);
        if(null === $beerStyle->get_fgMin())$beerStyle->set_fgMin(0);
        if(null === $beerStyle->get_fgMax())$beerStyle->set_fgMax(0);
    }
}

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
			<li><a href="beer_style_list.php">Beer Style List</a></li>
			<li>/</li>
			<li class="current">Beer Style Form</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End --> 
	
	<!-- Right Side/Main Content Start -->
	<div id="rightside">
		<div class="contentcontainer med left">
			<p>Fields marked with <b><font color="red">*</font></b> are required.<br><br>
			<?php $htmlHelper->ShowMessage(); ?>

	<form id="beer-style-form" method="POST">
		<input type="hidden" name="id" value="<?php echo $beerStyle->get_id() ?>" />
		<input type="hidden" name="active" value="<?php echo $beerStyle->get_active() ?>" />

		<table style="width:800;border:0;cellspacing:1;cellpadding:0;">
			<tr>
				<td width="100">
					<b>Name:<font color="red">*</font></b>
				</td>
				<td>
					<input type="text" id="name" class="largebox" name="name" value="<?php echo $beerStyle->get_name() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<b>Category:<font color="red">*</font></b>
				</td>
				<td>
					<input type="text" id="category" class="largebox" name="category" value="<?php echo $beerStyle->get_category() ?>" />					
				</td>
			</tr>
			<tr>
				<td>
					<b>Category Number:<font color="red">*</font></b>
				</td>
				<td>
					<input type="text" id="catNum" class="smallbox" name="catNum" value="<?php echo $beerStyle->get_catNum() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<b>Beer Style List:<font color="red">*</font></b>
				</td>
				<td>
					<input type="text" id="beerStyleList" class="largebox" name="beerStyleList" value="<?php echo $beerStyle->get_beerStyleList() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<b>Min SRM:<font color="red">*</font></b>
				</td>
				<td>
                    <?php
                    echo $htmlHelper->ToColorSelectList("srmMin", "srmMin", $srmList, "srm", "srm", $beerStyle->get_srmMin(), "Select SRM", "", "rgb"); 
					?>							
				</td>
			</tr>
			<tr>
				<td>
					<b>Max SRM:<font color="red">*</font></b>
				</td>
				<td>
                    <?php
                    echo $htmlHelper->ToColorSelectList("srmMax", "srmMax", $srmList, "srm", "srm", $beerStyle->get_srmMax(), "Select SRM", "", "rgb"); 
					?>							
				</td>
			</tr>
            <tr>
                <td>
                    <b>Min IBU:<font color="red">*</font></b>
                </td>
                <td>
                    <input type="text" id="ibuMin" class="smallbox" name="ibuMin" value="<?php echo $beerStyle->get_ibuMin() ?>" />
                </td>
            </tr>
            <tr>
                <td>
                    <b>Max IBU:<font color="red">*</font></b>
                </td>
                <td>
                    <input type="text" id="ibuMax" class="smallbox" name="ibuMax" value="<?php echo $beerStyle->get_ibuMax() ?>" />
                </td>
            </tr>
            <tr>
                <td>
                    <b>Min ABV:<font color="red">*</font></b>
                </td>
                <td>
                    <input type="text" id="abvMin" class="smallbox" name="abvMin" value="<?php echo $beerStyle->get_abvMin() ?>" />
                </td>
            </tr>
            <tr>
                <td>
                    <b>Max ABV:<font color="red">*</font></b>
                </td>
                <td>
                    <input type="text" id="abvMax" class="smallbox" name="abvMax" value="<?php echo $beerStyle->get_abvMax() ?>" />
                </td>
            </tr>
			<tr>
				<td>
					<b>Min OG:<font color="red">*</font></b>
				</td>
				<td>
					<input type="text" id="ogMin" class="smallbox" name="ogMin" value="<?php echo convert_gravity($beerStyle->get_ogMin(), $beerStyle->get_ogMinUnit(), $config[ConfigNames::DisplayUnitGravity]); ?>" /> <?php echo $config[ConfigNames::DisplayUnitGravity]; ?>
					<input type="hidden" name="ogMinUnit" value="<?php echo $config[ConfigNames::DisplayUnitGravity]; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<b>Max OG:<font color="red">*</font></b>
				</td>
				<td>
					<input type="text" id="ogMax" class="smallbox" name="ogMax" value="<?php echo convert_gravity($beerStyle->get_ogMax(), $beerStyle->get_ogMaxUnit(), $config[ConfigNames::DisplayUnitGravity]); ?>" /> <?php echo $config[ConfigNames::DisplayUnitGravity]; ?>
					<input type="hidden" name="ogMaxUnit" value="<?php echo $config[ConfigNames::DisplayUnitGravity]; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<b>Min FG:<font color="red">*</font></b>
				</td>
				<td>
					<input type="text" id="fgMin" class="smallbox" name="fgMin" value="<?php echo convert_gravity($beerStyle->get_fgMin(), $beerStyle->get_fgMinUnit(), $config[ConfigNames::DisplayUnitGravity]); ?>" /> <?php echo $config[ConfigNames::DisplayUnitGravity]; ?>
					<input type="hidden" name="fgMinUnit" value="<?php echo $config[ConfigNames::DisplayUnitGravity]; ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<b>Max FG:<font color="red">*</font></b>
				</td>
				<td>
					<input type="text" id="fgMax" class="smallbox" name="fgMax" value="<?php echo convert_gravity($beerStyle->get_fgMax(), $beerStyle->get_fgMaxUnit(), $config[ConfigNames::DisplayUnitGravity]); ?>" /> <?php echo $config[ConfigNames::DisplayUnitGravity]; ?>
					<input type="hidden" name="fgMaxUnit" value="<?php echo $config[ConfigNames::DisplayUnitGravity]; ?>" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input name="save" type="submit" class="btn" value="Save" />
					<input type="button" class="btn" value="Cancel" onClick="window.location='beer_style_list.php'" />
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
		
		$('#beer-style-form').validate({
		rules: {
			name: { required: true },
			catNum: { required: true },
			category: { required: true },
			beerStyleList: { required: true },	
			srmMin: { required: true, number: true },
			srmMax: { required: true, number: true },
			ibuMin: { required: true, number: true },
			ibuMax: { required: true, number: true },
			abvMin: { required: true, number: true },
			abvMax: { required: true, number: true },
			ogMin: { required: true, number: true },
			ogMax: { required: true, number: true },
			fgMin: { required: true, number: true },
			fgMax: { required: true, number: true },
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
