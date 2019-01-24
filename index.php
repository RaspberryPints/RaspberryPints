<?php
	if (!file_exists(__DIR__.'/includes/config.php')) {
		header('Location: install/index.php', true, 303);
		die();
	}
?>
<?php
	require_once __DIR__.'/admin/includes/managers/config_manager.php';
	require_once __DIR__.'/includes/config.php';
	require_once __DIR__.'/includes/common.php';

	require_once __DIR__.'/admin/includes/managers/tap_manager.php';
	require_once __DIR__.'/admin/includes/managers/tempProbe_manager.php';
	require_once __DIR__.'/admin/includes/managers/bottle_manager.php';
	require_once __DIR__.'/admin/includes/managers/pour_manager.php'; 
		
	//This can be used to choose between CSV or MYSQL DB
	$db = true;
	
	// Setup array for all the beers that will be contained in the list
	$taps = array();
	$bottles = array();
	
	if($db){
		// Connect to the database
		$mysqli = db();		
		$config = getAllConfigs();
		
		$sql =  "SELECT * FROM vwGetActiveTaps";
		$qry = $mysqli->query($sql);
		while($b = mysqli_fetch_array($qry))
		{
			$beeritem = array(
				"id" => $b['id'],
				"beername" => $b['name'],
				"untID" => $b['untID'],
				"style" => $b['style'],
		        "brewery" => $b['breweryName'],
		        "breweryImage" => $b['breweryImageUrl'],
				"notes" => $b['notes'],
				"abv" => $b['abv'],
				"og" => $b['og'],
				"fg" => $b['fg'],
				"srm" => $b['srm'],
				"ibu" => $b['ibu'],
				"startAmount" => $b['startAmount'],
				"amountPoured" => $b['amountPoured'],
				"remainAmount" => $b['remainAmount'],
				"tapRgba" => $b['tapRgba'],
				"tapNumber" => $b['tapNumber'],
				"rating" => $b['rating'],
				"srmRgb" => $b['srmRgb'],
				"valvePinState" => $b['valvePinState']
			);
			$taps[$b['id']] = $beeritem;
		}
		
		$tapManager = new TapManager();
		$numberOfTaps = $tapManager->getNumberOfTaps();

		$sql =  "SELECT * FROM vwGetFilledBottles";
    	$rowNumber = 1;
		$qry = $mysqli->query($sql);
		while($b = mysqli_fetch_array($qry))
		{
			$beeritem = array(
				"id" => $b['id'],
				"beername" => $b['name'],
				"untID" => $b['untID'],
				"style" => $b['style'],
		        "brewery" => $b['breweryName'],
		        "breweryImage" => $b['breweryImageUrl'],
				"notes" => $b['notes'],
				"abv" => $b['abv'],
				"og" => $b['og'],
				"fg" => $b['fg'],
				"srm" => $b['srm'],
				"ibu" => $b['ibu'],
				"volume" => $b['volume'],
				"startAmount" => $b['startAmount'],
				"amountPoured" => $b['amountPoured'],
				"remainAmount" => $b['remainAmount'],
				"capRgba" => $b['capRgba'],
				"capNumber" => $b['capNumber'],
				"rating" => $b['rating'],
				"srmRgb" => $b['srmRgb'],
				"valvePinState" => $b['valvePinState']
			);
			$bottles[$rowNumber] = $beeritem;
      		$rowNumber = $rowNumber+1;
		}
		$bottleManager = new BottleManager();
    	//$bottleManager->UpdateCounts();
		$numberOfBottles = $bottleManager->getCount();
		
		
		$poursManager = new PourManager();
		$limit = $config[ConfigNames::NumberOfDisplayPours];
		$poursList = $poursManager->getLastPours($limit);
		$numberOfPours = count($poursList);
	}
		
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">

<html>
	<head>
		<title>RaspberryPints</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<!-- Set location of Cascading Style Sheet -->
		<link rel="stylesheet" type="text/css" href="style.css">
		
		<?php if($config[ConfigNames::UseHighResolution]) { ?>
			<link rel="stylesheet" type="text/css" href="style-high-res.css">
		<?php } ?>
		
		<?php	
		if(! empty($_SERVER['HTTP_USER_AGENT'])){
    		$useragent = $_SERVER['HTTP_USER_AGENT'];
    		if( preg_match('@(Android)@', $useragent) ){ ?>
			<link rel="stylesheet" type="text/css" href="style-aftv.css">
    	<?php	    
    		}
		} ?>
		
		<link rel="shortcut icon" href="img/pint.ico">
<!-- <meta name="viewport" content="initial-scale=0.7,width=device-width,height=device-height,target-densitydpi=device-dpi,user-scalable=yes" />  -->		
		<script type="text/javascript" src="admin/scripts/ws.js"></script>	
	</head> 

<!--<body> -->
<body onload="wsconnect(); ">
		<div class="bodywrapper" id="mainTable">
			<!-- Header with Brewery Logo and Project Name -->
			<div class="header clearfix">
				<div class="HeaderLeft">
					<?php if($config[ConfigNames::UseHighResolution]) { ?>			
						<a href="admin/admin.php"><img src="<?php echo $config[ConfigNames::LogoUrl] . "?" . time(); ?>" height="200" alt=""></a>
					<?php } else { ?>
						<a href="admin/admin.php"><img src="<?php echo $config[ConfigNames::LogoUrl] . "?" . time(); ?>" height="100" alt=""></a>
					<?php } ?>
				</div>
				<div class="HeaderCenter">
					<h1 id="HeaderTitle">
						<?php
							if (mb_strlen($config[ConfigNames::HeaderText], 'UTF-8') > ($config[ConfigNames::HeaderTextTruncLen])) {
								echo htmlentities(substr($config[ConfigNames::HeaderText],0,$config[ConfigNames::HeaderTextTruncLen]) . "...");
							} else {
								echo htmlentities($config[ConfigNames::HeaderText]);
							}
						?>
					</h1>
				</div>
          		<?php 
          		    $temp = null;
          		    if($config[ConfigNames::ShowTempOnMainPage]) { 
          		       $tempProbeManager = new TempProbeManager();
          		       $tempInfo = $tempProbeManager->get_lastAvgTemp();
          		       if($tempInfo){
              		       $temp = $tempInfo[0];
              		       $date = $tempInfo[1];
              		       $tempDisplay = sprintf('%0.1fF &#64;<br/> %s', $temp, str_replace(' ', "<br/>", $date));
          		       }
          		    }
          		    echo '<div class="HeaderRight" style="width:15%;text-align:right;vertical-align:middle">'.$tempDisplay.'</div>';           		    
          	     ?>
				<div class="HeaderRight">
          		<?php 
          		    if(null !== $temp) { 
          	     ?>
          			   <div class="temp-container">
          			   <div class="temp-indicator">
          			   		<div class="temp-full" style="height:<?php echo $temp; ?>%; padding-right: 50px"></div>
          			   </div>
          		        </div>
          		<?php }elseif($config[ConfigNames::ShowRPLogo]) { ?>
					<?php if($config[ConfigNames::UseHighResolution]) { ?>			
						<a href="http://www.raspberrypints.com"><img src="img/RaspberryPints-4k.png" height="200" alt=""></a>
					<?php } else { ?>
						<a href="http://www.raspberrypints.com"><img src="img/RaspberryPints.png" height="100" alt=""></a>
					<?php } ?>
				<?php } ?>
				</div>
			</div>
			<!-- End Header Bar -->
			
			<?php 
			    if($numberOfTaps > 0 && $numberOfBottles > 0) echo "<h1 style=\"text-align: center;\">Taps</h1>";
				if($numberOfTaps > 0)printBeerList($taps, $numberOfTaps, ConfigNames::CONTAINER_TYPE_KEG);
			    if($numberOfTaps > 0 && $numberOfBottles > 0) echo "<h1 style=\"text-align: center;\">Bottles</h1>";
				if($numberOfBottles > 0) printBeerList($bottles, $numberOfBottles, ConfigNames::CONTAINER_TYPE_BOTTLE);
			    if($numberOfPours > 0 ) echo "<h1 style=\"text-align: center;\">Pours</h1>";
				if($numberOfPours > 0) printPoursList($poursList);
			?>
		</div>
		<div class="copyright">Data provided by <a href="http://untappd.com">Untappd</a></div>
		
		<?php if($config[ConfigNames::DisplayRowsSameHeight]) { ?>
		<script>
		window.onload = function(){
			tables = document.getElementsByTagName("table")
			for (var i = 0; i < tables.length; i++) {
			    var table = tables[i];		
				maxHeight = -1;
				//Start at 1 to avoid header row
				for (var j = 1; j < table.rows.length; j++) {
				    var row = table.rows[j];		
					if( row.offsetHeight > maxHeight ) maxHeight = row.offsetHeight;
				}
				if( maxHeight > 0 ){
    				for (var j = 1; j < table.rows.length; j++) {
    				    var row = table.rows[j];	
    					row.style.height = maxHeight + 'px';
    				}
				}
			}
		}
		</script>
		<?php } ?>
	</body>
</html>
