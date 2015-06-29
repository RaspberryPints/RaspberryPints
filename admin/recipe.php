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

$beerStyleList = $beerStyleManager->GetAll();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Recipe: <?php echo $beer->get_name() ?></title>
<link href="styles/layout.css" rel="stylesheet" type="text/css" />
<link href="styles/wysiwyg.css" rel="stylesheet" type="text/css" />
	<!-- Theme Start -->
<link href="styles.css" rel="stylesheet" type="text/css" />
	<!-- Theme End -->
<link href='http://fonts.googleapis.com/css?family=Fredoka+One' rel='stylesheet' type='text/css'>
</head>

	
	
	
	<div id="rightside">
		<div class="contentcontainer med left">
	<p>
    <table width="99%" border="0" cellspacing="0" cellpadding="0">
               <tr>
      
					<b>Recipe for <?php echo $beer->get_name() ?></b>
	
                </tr>
            </br>
            </br>
				<tr>
					<?php echo nl2br ($beer->get_recipe()); ?>
				</tr>
			
		</table>
        </div>




	<!-- Start Footer -->   
<?php 
require __DIR__.'/footer.php';
?>

	<!-- End Footer -->
		
	</div>
 
	<!-- Start Js  -->
<?php
require __DIR__.'/scripts.php';
?>
	<!-- End Js -->
	<!--[if IE 6]>
	<script type='text/javascript' src='scripts/png_fix.js'></script>
	<script type='text/javascript'>
	DD_belatedPNG.fix('img, .notifycount, .selected');
	</script>
	<![endif]--> 

</body>
</html>
