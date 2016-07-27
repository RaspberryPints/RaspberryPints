<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
	header("location:index.php");
}
require_once __DIR__.'/includes/conn.php';
require_once __DIR__.'/../includes/config_names.php';
require_once __DIR__.'/includes/html_helper.php';
require_once __DIR__.'/includes/functions.php';

require_once __DIR__.'/includes/models/beer.php';

require_once __DIR__.'/includes/managers/beer_manager.php';
require_once __DIR__.'/includes/managers/beerStyle_manager.php';

$htmlHelper = new HtmlHelper();
$beerManager = new BeerManager();
$beerStyleManager = new BeerStyleManager();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$beer = new Beer();
	$beer->setFromArray($_POST);
	$beerManager->Save($beer);
	redirect('beer_list.php');
}

if( isset($_GET['id'])){
	$beer = $beerManager->GetById($_GET['id']);
}else{
	$beer = new Beer();
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>RaspberryPints</title>
<link href="styles/layout.css" rel="stylesheet" type="text/css" />
<link href="styles/wysiwyg.css" rel="stylesheet" type="text/css" />
	<!-- Theme Start -->
<link href="styles.css" rel="stylesheet" type="text/css" />
	<!-- Theme End -->
<link href='http://fonts.googleapis.com/css?family=Fredoka+One' rel='stylesheet' type='text/css'>
</head>
	<!-- Start Header  -->
<?php
require __DIR__.'/header.php';
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
	<p>
		Fields marked with <b><font color="red">*</font></b> are required.<br><br>

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
				<td rowspan=2>
					<b>Style:<font color="red">*</font></b>
				</td>
				<td>
          Beer style list: <br>
          <?php 
          if(empty($beer->get_beerStyleId())) 
            $beerStyleList="bjcp2015"; 
          else 
          {
            $beerStyle = $beerStyleManager->GetById($beer->get_beerStyleId());
            if ($beerStyle->get_beerStyleList() == 'BJCP 2015')
              $beerStyleList="bjcp2015"; 
            elseif ($beerStyle->get_beerStyleList() == 'BJCP pre 2015')
              $beerStyleList="bjcpPre2015"; 
            elseif ($beerStyle->get_beerStyleList() == 'Other')
              $beerStyleList="other"; 
            else 
              $beerStyleList=""; 
          }
          ?>
          BJCP 2015<input type="radio" name="beerStyleList" id='styleListBtn2015'
            <?php if (isset($beerStyleList) && $beerStyleList=="bjcp2015") echo "checked"; ?>
            value="bjcp2015">&nbsp;
					BJCP pre 2015<input type="radio" name="beerStyleList" id='styleListBtnPre2015'
            <?php if (isset($beerStyleList) && $beerStyleList=="bjcpPre2015") echo "checked"; ?>
            value="bjcpPre2015">&nbsp;
					Other<input type="radio" name="beerStyleList" id='styleListBtnOther'
            <?php if (isset($beerStyleList) && $beerStyleList=="other") echo "checked"; ?>
            value="other">&nbsp;
          
				</td>
			</tr>
			<tr>
				<td>
          <?php echo "<div id='style-select-div' class='";
            if ($beerStyleList == "bjcpPre2015") 
              echo "beerStyleListPre2015";
            elseif ($beerStyleList == "other") 
              echo "beerStyleListOther";
            else 
              echo "beerStyleList2015";
            echo "'>";
          ?>
            <?php $beerStyleList = $beerStyleManager->GetAll("BJCP 2015"); ?>
            <?php echo $htmlHelper->ToCombinedSelectList("beerStyleId2015", $beerStyleList, "catNum", "name", "id", $beer->get_beerStyleId(), "Select One", "beerStyleList2015"); ?>
            <?php $beerStyleList = $beerStyleManager->GetAll("BJCP pre 2015"); ?>
            <?php echo $htmlHelper->ToCombinedSelectList("beerStyleIdPre2015", $beerStyleList, "catNum", "name", "id", $beer->get_beerStyleId(), "Select One", "beerStyleListPre2015"); ?>
            <?php $beerStyleList = $beerStyleManager->GetAll("Other"); ?>
            <?php echo $htmlHelper->ToCombinedSelectList("beerStyleIdOther", $beerStyleList, "catNum", "name", "id", $beer->get_beerStyleId(), "Select One", "beerStyleListOther"); ?>
          </div>
				</td>
			</tr>
			<tr>
				<td>
					<b>SRM:<font color="red">*</font></b>
				</td>
				<td>
					<input type="text" id="srm" class="xsmallbox" name="srm" value="<?php echo $beer->get_srm() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<b>IBU:<font color="red">*</font></b>
				</td>
				<td>
					<input type="text" id="ibu" class="xsmallbox" name="ibu" value="<?php echo $beer->get_ibu() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<b>OG:<font color="red">*</font></b>
				</td>
				<td>
					<input type="text" id="og" class="smallbox" name="og" value="<?php echo $beer->get_og() ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<b>FG:<font color="red">*</font></b>
				</td>
				<td>
					<input type="text" id="fg" class="smallbox" name="fg" value="<?php echo $beer->get_fg() ?>" />
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
				<td colspan="2">
					<input name="save" type="submit" class="btn" value="Save" />
					<input type="button" class="btn" value="Cancel" onclick="window.location='beer_list.php'" />
				</td>
			</tr>								
		</table>
		<br />
		<div align="right">			
			&nbsp &nbsp 
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
			style: { required: true },			
			srm: { required: true, number: true },
			ibu: { required: true, number: true },
			og: { required: true, number: true },
			fg: { required: true, number: true }
		}
		});
		
	});
</script>

<script type='text/javascript'>
  document.getElementById('styleListBtn2015').onclick = function() {
    document.getElementById('style-select-div').className = 'beerStyleList2015';
  }
  document.getElementById('styleListBtnPre2015').onclick = function() {
    document.getElementById('style-select-div').className = 'beerStyleListPre2015';
  }
  document.getElementById('styleListBtnOther').onclick = function() {
    document.getElementById('style-select-div').className = 'beerStyleListOther';
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
