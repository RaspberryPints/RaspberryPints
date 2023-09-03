<?php
	if (!file_exists(__DIR__.'/includes/config.php')) {
		header('Location: install/index.php', true, 303);
		die();
	}
	//Start a session for the first headerRight call because session needs to be started before HTML is sent
	if (session_status() === PHP_SESSION_NONE) {
	    session_start();
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
			    "beerBatchId" => $b['beerBatchId'],
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
    			                $tempInfo["temp"] = substr($plaatoValue, 0, strpos($plaatoValue, '�'));
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
			    "beerBatchId" => $b['beerBatchId'],
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
			    "startAmountUnit" => 'Bottle',
				"amountPoured" => $b['amountPoured'],
				"remainAmount" => $b['remainAmount'],
				"remainAmountUnit" => 'Bottle',
				"capRgba" => $b['capRgba'],
				"capNumber" => $b['capNumber'],
				"rating" => $b['rating'],
				"srmRgb" => $b['srmRgb'],
			    "valvePinState" => $b['valvePinState'],
			    "plaatoAuthToken" => '',
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
<body onload="wsconnect(); <?php if($config[ConfigNames::RefreshTapList])echo "setTimeout(function(){window.location.reload(1);}, 60000);"; ?>">
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
					if( $config[ConfigNames::ShowUntappdBreweryFeed] &&
					    !empty($config[ConfigNames::BreweryID]) ){
					        try{
    						    require_once __DIR__.'/includes/functions.php';
    						    utBreweryFeed($config, $config[ConfigNames::BreweryID]);
					        }catch(Exception $e){
					        //do nothing
					        }
						}
// 					    if (strlen($config[ConfigNames::HeaderText]) > ($config[ConfigNames::HeaderTextTruncLen])) {
// 							echo htmlentities(substr($config[ConfigNames::HeaderText],0,$config[ConfigNames::HeaderTextTruncLen]) . "...");
// 						} else {
							echo htmlentities($config[ConfigNames::HeaderText]);
//						}
						
					?>
				</div>
          		<div class="HeaderRight" id="HeaderRight" style="vertical-align:top">
          		<?php include_once 'includes/headerRight.php';?>
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
	<script type="text/javascript" src="admin/js/enhance.js"></script>	
	<script type='text/javascript' src='admin/js/excanvas.js'></script>
	<script type='text/javascript' src='admin/js/jquery-1.11.0.min.js'></script>
	<script type='text/javascript' src='admin/js/jquery-ui.js'></script>
	<script type='text/javascript' src='admin/js/jquery.validate.js'></script>
	<script type='text/javascript' src='admin/scripts/jquery.wysiwyg.js'></script>
	<script type='text/javascript' src='admin/scripts/visualize.jQuery.js'></script>
	<script type="text/javascript" src='admin/scripts/functions.js'></script>	
	<script type="text/javascript" src='admin/scripts/jscolor.js'></script>	
		<script type="text/javascript">
		
		function loadHeaderRight()
		{
			$.ajax(
	            {
	                   type: "GET",
	                   url: "includes/headerRight.php",
	                   data: null,
	                   cache: false,
	    
	                   success: function(response)
	                   {
	                    $('#HeaderRight')[0].innerHTML = response;
	                    if (typeof displayTime == 'function') { 
	                    	displayTime(); 
	                    	}
	                   }
	             });
			setTimeout(loadHeaderRight, <?php echo $config[ConfigNames::InfoTime]*1000?>); 
		}
		setTimeout(loadHeaderRight, <?php echo $config[ConfigNames::InfoTime]*1000?>); 
		<?php if($config[ConfigNames::DisplayRowsSameHeight]) { ?>
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
		}

		<?php } ?>

<?php if($config[ConfigNames::ShowAnalogClock] || $config[ConfigNames::ShowDigitalClock] || $config[ConfigNames::ShowDigitalClock24]){?>
		function displayTime() {
			canvas = document.getElementById("canvas");
			if( canvas !== null) {
    		ctx = canvas.getContext("2d");
    		ctx.setTransform(1, 0, 0, 1, 0, 0);
    		ctx.clearRect(0, 0, canvas.width, canvas.height);
    		radius = canvas.height / 2;
    		radius = radius * 0.90
    		ctx.translate(radius, radius);
		
			drawFace(ctx, radius);
			drawNumbers(ctx, radius);
			drawTime(ctx, radius);
			}

        	var clock = document.getElementById("digitalClock");
        	if( clock !== null){
            	var date = new Date();
                var h = date.getHours(); // 0 - 23
                var m = date.getMinutes(); // 0 - 59
                var s = date.getSeconds(); // 0 - 59
                var session = "AM";
                
                if(h == 0){
                    h = 12;
                }
                
                if(h > 12){
                    h = h - 12;
                    session = "PM";
                }
                
                h = (h < 10) ? "0" + h : h;
                m = (m < 10) ? "0" + m : m;
                s = (s < 10) ? "0" + s : s;
                
                var time = h + ":" + m + ":" + s + " " + session;
            	clock.innerHTML = time;
        	}
        	var clock = document.getElementById("digitalClock24");
        	if( clock !== null){
            	var date = new Date();
                var h = date.getHours(); // 0 - 23
                var m = date.getMinutes(); // 0 - 59
                var s = date.getSeconds(); // 0 - 59

                h = (h < 10) ? "0" + h : h;
                m = (m < 10) ? "0" + m : m;
                s = (s < 10) ? "0" + s : s;
                var time = h + ":" + m + ":" + s
            	clock.innerHTML = time;
        	}
        }
        
		function drawTime(ctx, radius){
		  var now = new Date();
		  var hour = now.getHours();
		  var minute = now.getMinutes();
		  var second = now.getSeconds();
		  //hour
		  hour = hour%12;
		  hour = (hour*Math.PI/6)+(minute*Math.PI/(6*60))+(second*Math.PI/(360*60));
		  drawHand(ctx, hour, radius*0.5, radius*0.07);
		  //minute
		  minute = (minute*Math.PI/30)+(second*Math.PI/(30*60));
		  drawHand(ctx, minute, radius*0.8, radius*0.07);
		  // second
		  second = (second*Math.PI/30);
		  drawHand(ctx, second, radius*0.9, radius*0.02);
		}

		function drawHand(ctx, pos, length, width) {
		  ctx.beginPath();
		  ctx.lineWidth = width;
		  ctx.lineCap = "round";
		  ctx.moveTo(0,0);
		  ctx.rotate(pos);
		  ctx.lineTo(0, -length);
		  ctx.stroke();
		  ctx.rotate(-pos);
		}

		function drawNumbers(ctx, radius) {
		  var ang;
		  var num;
		  ctx.font = radius * 0.15 + "px arial";
		  ctx.textBaseline = "middle";
		  ctx.textAlign = "center";
		  for(num = 1; num < 13; num++){
		    ang = num * Math.PI / 6;
		    ctx.rotate(ang);
		    ctx.translate(0, -radius * 0.85);
		    ctx.rotate(-ang);
		    ctx.fillText(num.toString(), 0, 0);
		    ctx.rotate(ang);
		    ctx.translate(0, radius * 0.85);
		    ctx.rotate(-ang);
		  }
		}
		function drawFace(ctx, radius) {
			  var grad;

			  ctx.beginPath();
			  ctx.arc(0, 0, radius, 0, 2 * Math.PI);
			  ctx.fillStyle = 'white';
			  ctx.fill();

			  grad = ctx.createRadialGradient(0, 0 ,radius * 0.95, 0, 0, radius * 1.05);
			  grad.addColorStop(0, '#333');
			  grad.addColorStop(0.5, 'white');
			  grad.addColorStop(1, '#333');
			  ctx.strokeStyle = grad;
			  ctx.lineWidth = radius*0.1;
			  ctx.stroke();

			  ctx.beginPath();
			  ctx.arc(0, 0, radius * 0.1, 0, 2 * Math.PI);
			  ctx.fillStyle = '#333';
			  ctx.fill();
			}

		displayTime();
		setInterval(displayTime, 1000);
		<?php } ?>
		</script>
	</body>
</html>
