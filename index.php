<?php
	require("includes/config_names.php");
	require("includes/config.php");
	
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
		while($b = mysql_fetch_array($qry))
		{
			$config[$b['configName']] = $b['configValue'];
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
			array_push($beers, $beeritem);
		}
	} else {
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
                    <h1 id="HeaderTitle"><? echo $config[ConfigNames::HeaderText]; ?></h1>
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
					<?php for($i = 0; $i < count($beers); $i++) { ?>
						<tr class="<?php if($i%2 > 0){ echo 'altrow'; }?>" id="<?php echo $beers[$i]['id']; ?>">
							<?php if($config[ConfigNames::ShowTapNumCol]){ ?>
								<td class="tap-num">
									<span class="tapcircle"><?php echo $beers[$i]['tapNumber']; ?></span>
								</td>
							<?php } ?>
						
							<?php if($config[ConfigNames::ShowSrmCol]){ ?>
								<td class="srm">
									<h3><?php echo $beers[$i]['og']; ?> OG</h3>
									
									<div class="srm-container">
										<div class="srm-indicator" style="background-color: rgb(<?php echo $beers[$i]['srmRgb'] ?>)"></div>
										<div class="srm-stroke"></div> 
									</div>
									
									<h2><?php echo $beers[$i]['srm']; ?> SRM</h2>
								</td>
							<?php } ?>
						
							<?php if($config[ConfigNames::ShowIbuCol]){ ?>
								<td class="ibu">
									<h3><?php echo number_format((($beers[$i]['ibu'])/(($beers[$i]['og']-1)*1000)), 2, '.', ''); ?> BU:GU</h3>
									<?php 
										$ibu = $beers[$i]['ibu'];
										if( $ibu > 100 )
											$ibu = 100;
									?>
									

									
									<div class="ibu-container">
										<div class="ibu-indicator"><div class="ibu-full" style="height:<?php echo $ibu; ?>%"></div></div>
											
										<?php 
											/*
											if( $remaining > 0 ){
												?><img class="ibu-max" src="img/ibu/offthechart.png" /><?php
											}
											*/
										?>
									</div>								
									<h2><?php echo $beers[$i]['ibu']; ?> IBU</h2>
								</td>
							<?php } ?>
						
							<td class="name">
								<h1><?php echo $beers[$i]['beername']; ?></h1>
								<h2 class="subhead"><?php echo $beers[$i]['style']; ?></h2>
								<p><?php echo $beers[$i]['notes']; ?></p>
							</td>
						
							<?php if($config[ConfigNames::ShowAbvCol]){ ?>
								<td class="abv">
									<h3><?php
										$calfromalc = (1881.22 * ($beers[$i]['fg'] * ($beers[$i]['og'] - $beers[$i]['fg'])))/(1.775 - $beers[$i]['og']);									
										$calfromcarbs = 3550.0 * $beers[$i]['fg'] * ((0.1808 * $beers[$i]['og']) + (0.8192 * $beers[$i]['fg']) - 1.0004);
										if ( ($beers[$i]['og'] == 1) && ($beers[$i]['fg'] == 1 ) ) {
											$calfromalc = 0;
											$calfromcarbs = 0;
											}
										echo number_format($calfromalc + $calfromcarbs), " kCal";
										?>
									</h3>
									<div class="abv-container">
										<?php
											$abv = ($beers[$i]['og'] - $beers[$i]['fg']) * 131;
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
						
							<?php if($config[ConfigNames::ShowKegCol]){ ?>
								<td class="keg">
									<h3><?php echo number_format((($beers[$i]['startAmount'] - $beers[$i]['remainAmount']) * 128)); ?> fl oz poured</h3>
									<?php 
										$kegImgClass = "";
										$percentRemaining = $beers[$i]['remainAmount'] / $beers[$i]['startAmount'] * 100;
										if( $beers[$i]['remainAmount'] <= 0 ) {
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
									<h2><?php echo number_format(($beers[$i]['remainAmount'] * 128)); ?> fl oz left</h2>
								</td>
							<?php } ?>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</body>
</html>
<!--TEST-->