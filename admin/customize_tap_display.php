<?php
$noHeadEnd = True;
require_once __DIR__.'/header.php';
require_once __DIR__.'/../includes/common.php';
?>
<link rel="stylesheet" type="text/css" href="../style.css">
<style>
html, body {
	background-image: url(img/background.jpg);
	background-color: #000000;
	background-size: cover;
	background-repeat:no-repeat;
	overflow: visible;
	color: #FFFFFF;
	font: 1em Georgia, arial, verdana, sans-serif;
	margin:0px;
	height:100%;
}
ul, li {list-style: none; padding: 0; margin: 0;}
tr { border:thick; border-color: #FF0000; }
</style>
</head>
<?php

$htmlHelper = new HtmlHelper();
$config = getAllConfigs();
//Force to verticle until horizontal is working
$config[ConfigNames::ShowVerticleTapList] == "1";
if (isset ( $_POST ['save'] )) {
    foreach( $_POST as $key => $value )
    {
        //if the showColumn is set then multiple the current value by the show value
        //this will result in a positive or negative value which will determine if the column is shown on the screen
        if( isset($_POST["show".$key]) ){
            $_POST[$key] = $_POST["show".$key] * $_POST[$key];
        }
    }
    setConfigurationsFromArray($_POST, $config);
    if(!$error){
        $_SESSION['successMessage'] = "Success";
    }else{
        $_SESSION['successMessage'] = "Changes Could Not Be Saved";
    }
} 
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
			<li class="current">Customize Tap Display</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End -->

	<!-- Right Side/Main Content Start -->
	<div id="rightside">
	<div class="contentcontainer left">
		<div class="headings alt">
			<h2>Customize Tap Displays</h2>
		</div>
		<div class="contentbox" style="background: none">
			<?php $htmlHelper->ShowMessage(); ?>
			<?php if(isset($_POST['edit'])) {?>
			<!-- <a style="color:#FFF" onClick="toggleSettings(this, 'settingsDiv')" class="collapsed heading">New Shield</a> -->
    		<?php }?>    		
			<br>
        
			<form method="POST" id="customizeTapDisplay">
			<div>
            	<input name="save" type="submit" class="btn" value="Save" />
            </div>
            <div>
    			<?php
//     			$result = array(getConfig(ConfigNames::ShowVerticleTapList));
// 				foreach($result as $row) {
// 					$options = array();
// 					$options[0] = 'On';
// 					$options[1] = 'Off';
// 					$validation = $row['validation'];
// 					if( $validation !== NULL && $validation != ''){
// 					    $valids = explode('|', $validation);
// 					    for( $i = 0; $i < count($valids); $i++ ){
// 					        $options[$i] = $valids[$i];
// 					    }
// 					}
// 					echo '<h3>' . $row['displayName'] . ":"  ./* '<span id="' . $row['configName'] . 'Success" style="display:none; color: #8EA534;"> (Updated)</span>'.  */'</h3>'.
//     					$options[0].'<input type="radio" ' . ($row['configValue']?'checked':'') . ' name="' . $row['configName'] . '" value="1">' .
//     					$options[1].'<input type="radio" ' . (!$row['configValue']?'checked':'') . ' name="' . $row['configName'] . '" value="0">'.
//     					'<br><br>';
//     				}
    			?>        
            </div>
	        
            <div>
            <?php 
                $taps = array();
                $beeritem = array(
                    "id" => 1,
                    "beername" => "BeerName",
                    "untID" => 0,
                    "style" => 1,
                    "brewery" => "BreweryName",
                    "breweryImage" => $b['breweryImageUrl'],
                    "notes" => "Beer Notes",
                    "abv" => 5.0,
                    "og" => 1.065,
                    "ogUnit" => UnitsOfMeasure::GravitySG,
                    "fg" => 1.010,
                    "fgUnit" => UnitsOfMeasure::GravitySG,
                    "srm" => 10,
                    "ibu" => 43,
                    "startAmount" => 5,
                    "startAmountUnit" => UnitsOfMeasure::VolumeOunce,
                    "remainAmount" => 4,
                    "remainAmountUnit" => UnitsOfMeasure::VolumeOunce,
                    "tapRgba" => "000,000,000",
                    "tapNumber" => 1,
                    "rating" => 4.5,
                    "srmRgb" => 2,
                    "valvePinState" => 0
                );
                $taps[1] = $beeritem;
                $numberOfTaps = 1;
                $numberOfBeers = 1;
                printBeerList($taps, $numberOfTaps, ConfigNames::CONTAINER_TYPE_KEG, TRUE);
            ?>
            </div>
			<div>
        		<input name="save" type="submit" class="btn" value="Save" />
        	</div>
            </form>
		</div>
	</div>
	<!-- Start Footer -->
	<?php
	include 'footer.php';
	?>
	<!-- End Footer -->
</div>
<script>
<?php if($config[ConfigNames::ShowVerticleTapList] == "0"){?>
//Sortable column heads
var oldIndex;
/* $('tr').custSortable({
  containerSelector: 'tr',
  itemSelector: 'th',
  placeholder: '<th class="placeholder"/>',
  vertical: false,
    stop: function( event, ui ) {
    	 allInputs = $('form').find('input[type=hidden]');
    	 for( i = 0; i < allInputs.length; i++ ){
    	 	allInputs[i].value = (i+1);
    	 }
    	}
}); */
$('tbody').sortableColumn({
	axis:"x",
	stop: function( event, ui ) {
		 allInputs = $('form').find('input[type=hidden]');
		 for( i = 0; i < allInputs.length; i++ ){
		 	allInputs[i].value = (i+1);
		 }
		},
	items: function( element, event ) {
			return $('td,th');
		}
	}); 
<?php }else{?>
$('tbody').sortable({
	axis:"y",
	stop: function( event, ui ) {
		 allInputs = $('form').find('input[type=hidden]');
		 for( i = 0; i < allInputs.length; i++ ){
		 	allInputs[i].value = (i+1);
		 }
		}
	}); 
<?php }?>
$('.table').disableSelection();

function setTextColor(picker, valueInput) {
	valueInput.style.backgroundColor = '#' + picker.toString()
}
function toggleSettings(callingAnchor, settingsDiv) {
	var div = document.getElementById(settingsDiv);
	if(div != null){
		if(div.style.display == ""){
			div.style.display = "none";
			callingAnchor.style.background = "url(img/bg_navigation.png) no-repeat top;";				
		}else{
			div.style.display = "";
			callingAnchor.style.background = "url(img/bg_navigation.png) 0 -76px;";				
		}
		if(document.getElementById("settingsExpanded")!= null)document.getElementById("settingsExpanded").value = div.style.display;
	}
}
</script>
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
	<!--[if IE 6]>
	<script type='text/javascript' src='scripts/png_fix.js'></script>
	<script type='text/javascript'>
	DD_belatedPNG.fix('img, .notifycount, .selected');
	</script>
	<![endif]-->
</body>
</html>
