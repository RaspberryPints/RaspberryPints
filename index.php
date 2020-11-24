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
		
	$plaatoPins = array(
	    "style" => 'v64',
	    "abv" => 'v68',
	    "og" => 'v65',
	    "fg" => 'v66',
	    "remainAmount" => 'v51',
	    "lastPour" => 'v47',
	    "temp" => 'v69'
	);
	$plaatoTemps = array();
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
				"beerId" => $b['beerId'],
				"beername" => $b['name'],
				"untID" => $b['untID'],
				"style" => $b['style'],
		        "brewery" => $b['breweryName'],
		        "breweryImage" => $b['breweryImageUrl'],
				"notes" => $b['notes'],
				"abv" => $b['abv'],
				"og" => $b['og'],
				"ogUnit" => $b['ogUnit'],
				"fg" => $b['fg'],
				"fgUnit" => $b['fgUnit'],
				"srm" => $b['srm'],
				"ibu" => $b['ibu'],
			    "startAmount" => $b['startAmount'],
			    "startAmountUnit" => $b['startAmountUnit'],
			    "remainAmount" => $b['remainAmount'],
				"remainAmountUnit" => $b['remainAmountUnit'],
				"tapRgba" => $b['tapRgba'],
				"tapNumber" => $b['tapNumber'],
				"rating" => $b['rating'],
				"srmRgb" => $b['srmRgb'],
				"valvePinState" => $b['valvePinState'],
			    "plaatoAuthToken" => $b['plaatoAuthToken'],
			    "containerType" => $b['containerType'],
			    "kegType" => $b['kegType'],
			    "accolades" => $b['accolades']
			);
			if($config[ConfigNames::UsePlaato]) {
    			if(isset($b['plaatoAuthToken']) && $b['plaatoAuthToken'] !== NULL && $b['plaatoAuthToken'] != '')
    			{
    			    foreach( $plaatoPins as $value => $pin)
    			    {
    			        $plaatoValue = file_get_contents("http://plaato.blynk.cc/".$b['plaatoAuthToken']."/get/".$pin);
    			        $plaatoValue = substr($plaatoValue, 2, strlen($plaatoValue)-4);
    			        if( $value == 'fg' || $value == 'og' ) $plaatoValue = $plaatoValue/1000;
    			        if( $value == "temp"){
    			            if($config[ConfigNames::UsePlaatoTemp])
    			            {
    			                $tempInfo["tempUnit"] = (strpos($plaatoValue,"C")?UnitsOfMeasure::TemperatureCelsius:UnitsOfMeasure::TemperatureFahrenheight);
    			                $tempInfo["temp"] = substr($plaatoValue, 0, strpos($plaatoValue, '°'));
    			                $tempInfo["probe"] = $b['id'];
    			                $tempInfo["takenDate"] = date('Y-m-d H:i:s');
    			                array_push($plaatoTemps, $tempInfo);
    			            }
    			            //echo $value."=http://plaato.blynk.cc/".$b['plaatoAuthToken']."/get/".$pin."-".$plaatoTemp.'-'.$plaatoValue.'<br/>';
        			    }else{
        			        if( $plaatoValue !== NULL && $plaatoValue != '') $beeritem[$value] = $plaatoValue;
    			            //echo $value."=http://plaato.blynk.cc/".$b['plaatoAuthToken']."/get/".$pin."-".$beeritem[$value].'-'.$plaatoValue.'<br/>';
        			    }
    			        
    			    }
    			}
			}
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
				"beerId" => $b['beerId'],
				"beername" => $b['name'],
				"untID" => $b['untID'],
				"style" => $b['style'],
		        "brewery" => $b['breweryName'],
		        "breweryImage" => $b['breweryImageUrl'],
				"notes" => $b['notes'],
			    "abv" => $b['abv'],
			    "og" => $b['og'],
			    "ogUnit" => $b['ogUnit'],
			    "fg" => $b['fg'],
			    "fgUnit" => $b['fgUnit'],
				"srm" => $b['srm'],
				"ibu" => $b['ibu'],
			    "volume" => $b['volume'],
			    "volumeUnit" => $b['volumeUnit'],
				"startAmount" => $b['startAmount'],
				"amountPoured" => $b['amountPoured'],
				"remainAmount" => $b['remainAmount'],
				"capRgba" => $b['capRgba'],
				"capNumber" => $b['capNumber'],
				"rating" => $b['rating'],
				"srmRgb" => $b['srmRgb'],
			    "valvePinState" => $b['valvePinState'],
			    "plaatoAuthToken" => $b['plaatoAuthToken'],
			    "containerType" => $b['containerType'],
			    "kegType" => $b['kegType'],
				"accolades" => $b['accolades']
			);
			$bottles[$rowNumber] = $beeritem;
      		$rowNumber = $rowNumber+1;
		}
		$bottleManager = new BottleManager();
    	//$bottleManager->UpdateCounts();
		$numberOfBottles = $bottleManager->getCount();
		
		$numberOfPours = 0;
		if($config[ConfigNames::ShowPourListOnHome]){
    		$poursManager = new PourManager();
    		$page = 1;
    		$limit = $config[ConfigNames::NumberOfDisplayPours];
    		$totalRows = 0;
    		$poursList = $poursManager->getLastPours($page, $limit, $totalRows);
    		$numberOfPours = count($poursList);
		}
	}
		
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
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
		<script type="text/javascript">
			function toggleFullScreen() {
        	  var doc = window.document;
        	  var docEl = doc.documentElement;

        	  var requestFullScreen = docEl.requestFullscreen || docEl.mozRequestFullScreen || docEl.webkitRequestFullScreen || docEl.msRequestFullscreen;
        	  var cancelFullScreen = doc.exitFullscreen || doc.mozCancelFullScreen || doc.webkitExitFullscreen || doc.msExitFullscreen;

        	  if(!doc.fullscreenElement && !doc.mozFullScreenElement && !doc.webkitFullscreenElement && !doc.msFullscreenElement) {
        	    requestFullScreen.call(docEl);
        	  }
        	  else {
        	    cancelFullScreen.call(doc);
        	  }
        	}
        </script>
	</head> 

<!--<body> -->
<body onload="wsconnect(); <?php if($config[ConfigNames::ShowTempOnMainPage])echo "setTimeout(function(){window.location.reload(1);}, 60000);"; ?>">
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
				<div class="HeaderCenter" onClick="toggleFullScreen()">
					<?php
					    if( $config[ConfigNames::ShowUntappdBreweryFeed] ){
						    require_once __DIR__.'/includes/functions.php';
						    utBreweryFeed($config, $config[ConfigNames::BreweryID]);
						}
					    if (strlen($config[ConfigNames::HeaderText]) > ($config[ConfigNames::HeaderTextTruncLen])) {
							echo htmlentities(substr($config[ConfigNames::HeaderText],0,$config[ConfigNames::HeaderTextTruncLen]) . "...");
						} else {
							echo htmlentities($config[ConfigNames::HeaderText]);
						}
						
					?>
				</div>
          		<?php 
      		        $temp = null;
      		        if(!$config[ConfigNames::ShowLastPour]){ 
      		    ?>
              		<?php 
              		    $tempDisplay = "";
              		    $date = null;
              		    if($config[ConfigNames::ShowTempOnMainPage]) {
              		        if(!isset($plaatoTemps) || count($plaatoTemps) == 0)
              		        {
                  		       $tempProbeManager = new TempProbeManager();
                  		       $tempInfos = $tempProbeManager->get_lastTemp();
              		        }else{
              		            $tempInfos = $plaatoTemps;
              		        }
              		        foreach($tempInfos as $tempInfo){
              		            $temp = $tempInfo["temp"];
              		            $tempUnit = $tempInfo["tempUnit"];
              		            $probe = $tempInfo["probe"];
              		            $date = MAX($tempInfo["takenDate"], $date);
              		            $tempDisplay .= sprintf('%s:%0.1f%s<br/>', $probe, convert_temperature($temp, $tempUnit, $config[ConfigNames::DisplayUnitTemperature]), $config[ConfigNames::DisplayUnitTemperature] );
              		        }
              		        if( isset($date) && isset($tempDisplay) )$tempDisplay .= sprintf('%s', str_replace(' ', "<br/>", $date));
              		    }
              		    echo '<div class="HeaderRight" style="width:15%;text-align:right;vertical-align:middle">'.$tempDisplay.'</div>';     
              		    
              		    
              	     ?>
				<?php }?>
          	     
				<div class="HeaderRight">
          		<?php 
          		    if(null !== $temp) { 
          	     ?>
          			   <div class="temp-container">
          			   <div class="temp-indicator">
          			   		<div class="temp-full" style="height:<?php echo convert_temperature($temp, $tempUnit, UnitsOfMeasure::TemperatureFahrenheight); ?>%; padding-right: 50px"></div>
          			   </div>
          		        </div>
          		<?php }elseif($config[ConfigNames::ShowLastPour]) { ?>
				<table>
    				<tr>
    					<td class="poursbeername">	
    						<h1 style="text-align: right">Last Pour</h1>
    					</td>
					<?php 
					if(!$config[ConfigNames::ShowPourListOnHome]){
					    $poursManager = new PourManager();
					    $page = 1;
					    $limit = 1;
					    $totalRows = 0;
					    $poursList = $poursManager->getLastPours($page, $limit, $totalRows);
					    $numberOfPours = 0;//count($poursList);
            		}
            		?>
    				<?php $pour = count($poursList)>0?array_values($poursList)[0]:null;?>
    				<?php if(null !== $pour) {?>
    					<td class="poursbeername">	
    						<h1 style="font-size: 1em"><?php echo $pour->get_beerName(); ?></h1>
    					</td>
                        <td class="poursamount">
                            <h1><?php echo $pour->get_amountPouredDisplay(); ?></h1>
                        </td>
    				<?php } ?>
                    </tr>
                </table>
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
			    if($numberOfPours > 0) echo "<h1 style=\"text-align: center;\">Pours</h1>";
				if($numberOfPours > 0) printPoursList($poursList);
			?>
		</div>
		<div class="copyright">Data provided by <a href="http://untappd.com">Untappd</a></div>
		
		<?php if($config[ConfigNames::DisplayRowsSameHeight]) { ?>
		<script type="text/javascript">
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

			wsconnect();

			<?php if($config[ConfigNames::ShowTempOnMainPage])echo "setTimeout(function(){window.location.reload(1);}, 60000);"; ?>
		}
		</script>
		<?php } ?>
	</body>
</html>
