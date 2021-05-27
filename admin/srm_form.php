<?php
require_once __DIR__.'/header.php';

$htmlHelper = new HtmlHelper();
$srmManager = new SrmManager();

if(isset($_POST['Add'])){
    if($srmManager->getBySRM($_POST['newSRM'])){
        $_SESSION['errorMessage'] = 'SRM Number already Exists';
    }
    //elseif($srmManager->getByRGB($_POST['newRGB'])){
    //    $_SESSION['errorMessage'] = 'RGB already Exists';
    //}
    else{
        $r = hexdec($_POST['newRGB'][1].$_POST['newRGB'][2]);
        $g = hexdec($_POST['newRGB'][3].$_POST['newRGB'][4]);
        $b = hexdec($_POST['newRGB'][5].$_POST['newRGB'][6]);
        $srm = Srm::fromColors($_POST['newSRM'], $r.','.$g.','.$b);
        if($srmManager->Save($srm, true)){
            unset($_POST);
        }
    }
}

$maxSRM = $srmManager->getMaxSRM();
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
			<li class="current">SRM Form</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End --> 
	
	<!-- Right Side/Main Content Start -->
	<div id="rightside">
		<div class="contentcontainer med left">
	<p>
	<p>
		Fields marked with <b><font color="red">*</font></b> are required.<br><br>
		<?php $htmlHelper->ShowMessage(); ?>

	<form id="srm-form" method="POST">
		<table style="width:950;border:0;cellspacing:1;cellpadding:0;">
			<tr>
				<td>
				</td>
				<td>
				<?php
				    echo $htmlHelper->ToColorSelectList("existingRgba", "existingRgba", $srmManager->GetAllActive(), "rgb", "rgb", "", "Current RGB(s)", "", "rgb");
				?>	
				</td>
			</tr>
			<tr>
				<td>
					<span class="tooltip"><b>New Label<font color="red">*</font></b><span class="tooltiptext">For custom Colors this number<br/>represents where in the SRM list the color is</span></span>:
				</td>
				<td>
					<span class="tooltip"><input type="text" id="newSRM" name="newSRM" value="<?php echo isset($_POST['newSRM'])?$_POST['newSRM']:($maxSRM + 1)?>"><span class="tooltiptext">For custom Colors this number<br/>represents where in the SRM list the color is</span></span>
				</td>
			</tr>	
			<tr>
				<td>
					<b>New SRM Color<font color="red">*</font>:</b>
				</td>
				<td>
					<input type="color" id="newRGB" name="newRGB" value="<?php echo isset($_POST['newRGB'])?$_POST['newRGB']:'#000000'?>">
				</td>
			</tr>	
			<tr>
				<td>
					<input name="Add" type="submit" class="btn" value="addSRM" />
				</td>
				<td>
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
	$(function() {
		
		$('#srm-form').validate({
      rules: {
    	  newSRM: { required: true, number: true },
    	  newRGB: { required: true },
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
