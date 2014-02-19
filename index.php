<?php
        if (!file_exists(__DIR__.'/includes/config.php')) {
           header('Location: /install', true, 303);
           die();
        }
?>
<?php
	require_once __DIR__.'/includes/config_names.php';

	require_once __DIR__.'/includes/config.php';

	require_once __DIR__.'/admin/includes/managers/tap_manager.php';
	
	//This calls the Untappd Library
	require_once __DIR__.'/includes/Untappd.php';
	
	//This can be used to choose between CSV or MYSQL DB
	$db = true;
	
	// Setup array for all the beers that will be contained in the list
	$beers = array();
	
	if($db){
		// Connect to the database
		db();
		
		
		$config = array();
		$sql = "SELECT * FROM config";
		$qry = mysql_query($sql);
		while($c = mysql_fetch_array($qry)){
			$config[$c['configName']] = $c['configValue'];
		}
		
		$sql =  "SELECT * FROM vwGetActiveTaps";
		$qry = mysql_query($sql);
		while($b = mysql_fetch_array($qry))
		{
			$beeritem = array(
				"id" => $b['id'],
				"beername" => $b['name'],
				"style" => $b['style'],
				"notes" => $b['notes'],
				"og" => $b['ogAct'],
				"fg" => $b['fgAct'],
				"srm" => $b['srmAct'],
				"ibu" => $b['ibuAct'],
				"startAmount" => $b['startAmount'],
				"amountPoured" => $b['amountPoured'],
				"remainAmount" => $b['remainAmount'],
				"tapNumber" => $b['tapNumber'],
				"srmRgb" => $b['srmRgb']
			);
			$beers[$b['tapNumber']] = $beeritem;
		}
		
		$tapManager = new TapManager();
		$numberOfTaps = $tapManager->GetTapNumber();
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
			<link rel="stylesheet" type="text/css" href="high-res.css">
		<?php } ?>
		
		<link rel="shortcut icon" href="img/pint.ico">
	</head> 

	<body>
		<div class="bodywrapper">
			<!-- Header with Brewery Logo and Project Name -->
			<div class="header clearfix">
				<div class="HeaderLeft">
					<?php if($config[ConfigNames::UseHighResolution]) { ?>			
						<a href="admin/admin.php"><img src="<?php echo $config[ConfigNames::LogoUrl]; ?>" height="200" alt=""></a>
					<?php } else { ?>
						<a href="admin/admin.php"><img src="<?php echo $config[ConfigNames::LogoUrl]; ?>" height="100" alt=""></a>
					<?php } ?>
				</div>
				<div class="HeaderCenter">
					<h1 id="HeaderTitle">
						<?php
							if (mb_strlen($config[ConfigNames::HeaderText], 'UTF-8') > ($config[ConfigNames::HeaderTextTruncLen])) {
								$headerTextTrunced = substr($config[ConfigNames::HeaderText],0,$config[ConfigNames::HeaderTextTruncLen]) . "...";
								echo $headerTextTrunced ; }
							else
								echo $config[ConfigNames::HeaderText];
						?>
					</h1>
				</div>
				<div class="HeaderRight">
					<?php if($config[ConfigNames::UseHighResolution]) { ?>			
						<a href="http://www.raspberrypints.com"><img src="img/RaspberryPints-4k.png" height="200" alt=""></a>
					<?php } else { ?>
						<a href="http://www.raspberrypints.com"><img src="img/RaspberryPints.png" height="100" alt=""></a>
					<?php } ?>
				</div>
			</div>
			<!-- End Header Bar -->
			
			<table>
				<thead>
					<tr>
						<?php if($config[ConfigNames::ShowTapNumCol]){ ?>
							<th class="tap-num">
								TAP<br>#
							</th>
						<?php } ?>
						
						<?php if($config[ConfigNames::ShowSrmCol]){ ?>
							<th class="srm">
								GRAVITY<hr>COLOR
							</th>
						<?php } ?>
						
						<?php if($config[ConfigNames::ShowIbuCol]){ ?>
							<th class="ibu">
								BALANCE<hr>BITTERNESS
							</th>
						<?php } ?>
						
						<th class="name">
							BEER NAME &nbsp; & &nbsp; STYLE<hr>TASTING NOTES
						</th>
						
						<?php if($config[ConfigNames::ShowAbvCol]){ ?>
							<th class="abv">
								CALORIES<hr>ALCOHOL
							</th>
						<?php } ?>
						
						<?php if($config[ConfigNames::ShowKegCol]){ ?>
							<th class="keg">
								POURED<hr>REMAINING
							</th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					<?php for($i = 1; $i <= $numberOfTaps; $i++) {
						if( isset($beers[$i]) ) {
							$beer = $beers[$i];
					?>
							<tr class="<?php if($i%2 > 0){ echo 'altrow'; }?>" id="<?php echo $beer['id']; ?>">
								<?php if($config[ConfigNames::ShowTapNumCol]){ ?>
									<td class="tap-num">
										<span class="tapcircle"><?php echo $i; ?></span>
									</td>
								<?php } ?>
							
								<?php if($config[ConfigNames::ShowSrmCol]){ ?>
									<td class="srm">
										<h3><?php echo $beer['og']; ?> OG</h3>
										
										<div class="srm-container">
											<div class="srm-indicator" style="background-color: rgb(<?php echo $beer['srmRgb'] != "" ? $beer['srmRgb'] : "0,0,0" ?>)"></div>
											<div class="srm-stroke"></div> 
										</div>
										
										<h2><?php echo $beer['srm']; ?> SRM</h2>
									</td>
								<?php } ?>
							
								<?php if($config[ConfigNames::ShowIbuCol]){ ?>
									<td class="ibu">
										<h3>
											<?php 
												if( $beer['og'] > 1 ){
													echo number_format((($beer['ibu'])/(($beer['og']-1)*1000)), 2, '.', '');
												}else{
													echo '0.00';
												}
											?> 
											BU:GU
										</h3>
										
										<div class="ibu-container">
											<div class="ibu-indicator"><div class="ibu-full" style="height:<?php echo $beer['ibu'] > 100 ? 100 : $beer['ibu']; ?>%"></div></div>
												
											<?php 
												/*
												if( $remaining > 0 ){
													?><img class="ibu-max" src="img/ibu/offthechart.png" /><?php
												}
												*/
											?>
										</div>								
										<h2><?php echo $beer['ibu']; ?> IBU</h2>
									</td>
								<?php } 
								//Only Display rating if $beer[id] is set


                                                                                         // This section calls for the rating from Untappd
                                                                        $untid = mysql_fetch_array(mysql_query("select `untID` from beers where id=".$beer[id].";"),0) ;
                                                                                $utid = $untid[0];




$utconfig = array(
    'clientId'     => $config[ClientID],
    'clientSecret' => $config[ClientSecret],
    'redirectUri'  => '',
    'accessToken'  => '',
);

$untappd = new Pintlabs_Service_Untappd($utconfig);
try {
    $feed = $untappd->beerInfo($utid);
}  catch (Exception $e) {
    die($e->getMessage());
}


$rs = $feed->response->beer->rating_score;

if ($rs >= '0' && $rs<'.5') {
 $img = "<span class=\"rating small r00\"></span><span class=\"num\">(".round($rs,2).")</span>";
} else if ($rs=='.5') {
$img = "<span class=\"rating small r05\"></span><span class=\"num\">(".round($rs,2).")</span>";
} else if ($rs >'.5' && $rs<'1.5') {
$img = "<span class=\"rating small r10\"></span><span class=\"num\">(".round($rs,2).")</span>";
} else if ($rs=='1.5') {
$img = "<span class=\"rating small r15\"></span><span class=\"num\">(".round($rs,2).")</span>";
} else if ($rs >'1.5' && $rs <'2.5') {
$img = "<span class=\"rating small r20\"></span><span class=\"num\">(".round($rs,2).")</span>";
} else if ($rs =='2.5' ) {
$img = "<span class=\"rating small r25\"></span><span class=\"num\">(".round($rs,2).")</span>";
} else if ($rs >'2.5' && $rs < '3.5') {
$img = "<span class=\"rating small r30\"></span><span class=\"num\">(".round($rs,2).")</span>";
} else if ($rs=='3.5') {
 $img = "<span class=\"rating small r35\"></span><span class=\"num\">(".round($rs,2).")</span>";
}  else if ($rs > '3.5' && $rs< '4.5') {
 $img = "<span class=\"rating small r40\"></span><span class=\"num\">(".round($rs,2).")</span>";
} else if ($rs =='4.5') {
$img = "<span class=\"rating small r45\"></span><span class=\"num\">(".round($rs,2).")</span>";
} else if ($rs>'4.5') {
$img = "<span class=\"rating small r50\"></span><span class=\"num\">(".round($rs,2).")</span>";
} 

// Done with Rating
								?>
							
								<td class="name">
									<h1><?php echo $beer['beername']; ?></h1>
									<h2 class="subhead"><?php echo $beer['style']; ?></h2>
									<p class="rating">
									<?php 
										//Place the Rating
										echo $img;
									 ?>
									</p>
									<p><?php echo $beer['notes']; ?></p>
								</td>
							
								<?php if(($config[ConfigNames::ShowAbvCol]) && ($config[ConfigNames::ShowAbvImg])){ ?>
									<td class="abv">
										<h3><?php
											$calfromalc = (1881.22 * ($beer['fg'] * ($beer['og'] - $beer['fg'])))/(1.775 - $beer['og']);
											$calfromcarbs = 3550.0 * $beer['fg'] * ((0.1808 * $beer['og']) + (0.8192 * $beer['fg']) - 1.0004);
											if ( ($beer['og'] == 1) && ($beer['fg'] == 1 ) ) {
												$calfromalc = 0;
												$calfromcarbs = 0;
												}
											echo number_format($calfromalc + $calfromcarbs), " kCal";
											?>
										</h3>
										<div class="abv-container">
											<?php
												$abv = ($beer['og'] - $beer['fg']) * 131;
												$numCups = 0;
												$remaining = $abv * 20;
												do{
														if( $remaining < 100 ){
																$level = $remaining;
														}else{
																$level = 100;
														}
														?><div class="abv-indicator"><div class="abv-full" style="height:<?php echo $level; ?>%"></div></div><?php
														
														$remaining = $remaining - $level;
														$numCups++;
												}while($remaining > 0 && $numCups < 2);
												
												if( $remaining > 0 ){
													?><div class="abv-offthechart"></div><?php
												}
											?>
										</div>
										<h2><?php echo number_format($abv, 1, '.', ',')."%"; ?> ABV</h2>
									</td>
								<?php } ?>
								
								<?php if(($config[ConfigNames::ShowAbvCol]) && ! ($config[ConfigNames::ShowAbvImg])){ ?>
									<td class="abv">
										<h3><?php
											$calfromalc = (1881.22 * ($beer['fg'] * ($beer['og'] - $beer['fg'])))/(1.775 - $beer['og']);
											$calfromcarbs = 3550.0 * $beer['fg'] * ((0.1808 * $beer['og']) + (0.8192 * $beer['fg']) - 1.0004);
											if ( ($beer['og'] == 1) && ($beer['fg'] == 1 ) ) {
												$calfromalc = 0;
												$calfromcarbs = 0;
												}
											echo number_format($calfromalc + $calfromcarbs), " kCal";
											?>
										</h3>
										<div class="abv">
											<?php
												$abv = ($beer['og'] - $beer['fg']) * 131;
											?>
										</div>
										<h2><?php echo number_format($abv, 1, '.', ',')."%"; ?> ABV</h2>
									</td>
								<?php } ?>
								
								<?php if($config[ConfigNames::ShowKegCol]){ ?>
									<td class="keg">
										<h3><?php echo number_format((($beer['startAmount'] - $beer['remainAmount']) * 128)); ?> fl oz poured</h3>
										<?php 
											$kegImgClass = "";
											$percentRemaining = $beer['remainAmount'] / $beer['startAmount'] * 100;
											if( $beer['remainAmount'] <= 0 ) {
												$kegImgClass = "keg-empty";
												$percentRemaining = 100; }
											else if( $percentRemaining < 15 )
												$kegImgClass = "keg-red";
											else if( $percentRemaining < 25 )
												$kegImgClass = "keg-orange";
											else if( $percentRemaining < 45 )
												$kegImgClass = "keg-yellow";
											else if ( $percentRemaining < 100 )
												$kegImgClass = "keg-green";
											else if( $percentRemaining >= 100 )
												$kegImgClass = "keg-full";
										?>
										<div class="keg-container">
											<div class="keg-indicator"><div class="keg-full <?php echo $kegImgClass ?>" style="height:<?php echo $percentRemaining; ?>%"></div></div>
										</div>
										<h2><?php echo number_format(($beer['remainAmount'] * 128)); ?> fl oz left</h2>
									</td>
								<?php } ?>
							</tr>
						<?php }else{ ?>
							<tr class="<?php if($i%2 > 0){ echo 'altrow'; }?>">
								<?php if($config[ConfigNames::ShowTapNumCol]){ ?>
									<td class="tap-num">
										<span class="tapcircle"><?php echo $i; ?></span>
									</td>
								<?php } ?>
							
								<?php if($config[ConfigNames::ShowSrmCol]){ ?>
									<td class="srm">
										<h3></h3>										
										<div class="srm-container">
											<div class="srm-indicator"></div>
											<div class="srm-stroke"></div> 
										</div>
										
										<h2></h2>
									</td>
								<?php } ?>
							
								<?php if($config[ConfigNames::ShowIbuCol]){ ?>
									<td class="ibu">
										<h3></h3>										
										<div class="ibu-container">
											<div class="ibu-indicator"><div class="ibu-full" style="height:0%"></div></div>
										</div>								
										<h2></h2>
									</td>
								<?php } ?>
							
								<td class="name">
									<h1>Nothing on tap</h1>
									<h2 class="subhead"></h2>
									<p></p>
								</td>
								
								<?php if(($config[ConfigNames::ShowAbvCol]) && ($config[ConfigNames::ShowAbvImg])){ ?>
									<td class="abv">
										<h3></h3>
										<div class="abv-container">
											<div class="abv-indicator"><div class="abv-full" style="height:0%"></div></div>
										</div>
										<h2></h2>
									</td>
								<?php } ?>

								<?php if(($config[ConfigNames::ShowAbvCol]) && ! ($config[ConfigNames::ShowAbvImg])){ ?>
									<td class="abv">
										<h3></h3>

										<h2></h2>
									</td>
								<?php } ?>								
								
								<?php if($config[ConfigNames::ShowKegCol]){ ?>
									<td class="keg">
										<h3></h3>
										<div class="keg-container">
											<div class="keg-indicator"><div class="keg-full keg-empty" style="height:0%"></div></div>
										</div>
										<h2>0 fl oz left</h2>
									</td>
								<?php } ?>
							</tr>
						<?php } ?>
					<?php } ?>
				</tbody>
			</table>
		<?php


$utconfig = array(
    'clientId'     => $config[ClientID],
    'clientSecret' => $config[ClientSecret],
    'redirectUri'  => '',
    'accessToken'  => '',
);


$buntappd = new Pintlabs_Service_Untappd($utconfig);
try {
    $bfeed = $buntappd->breweryFeed($config[BreweryID], '','', '5');
} catch (Exception $e) {
    die($e->getMessage());
}

echo "<table width=95%><tr>";

foreach ($bfeed->response->checkins->items as $i) {
    

        echo "<td width=20%><table width=95%><tr><td><div class='beerfeed'>";
        echo "<center><div class=circular style='width: 50px;height: 50px;background-image: url(". $i->user->user_avatar .");background-size: cover;display: block;border-radius: 100px;-webkit-border-radius:  100px;-moz-border-radius: 100px;'></div>";
      echo "".$i->user->user_name."<br />";

      echo "Is drinking a <br />". $i->beer->beer_name ."<br />";

      echo "</td></tr></table>";
      echo "</div></td>";

}

echo "</tr></table>";

?>
		</div>
<div class="copyright">Data provided by <a href="http://untappd.com">Untappd</a>.</div>
	</body>
</html>
