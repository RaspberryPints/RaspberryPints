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
				"abv" => $b['abv'],
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
          <?php if($config[ConfigNames::ShowRPLogo]) { ?>
					  <?php if($config[ConfigNames::UseHighResolution]) { ?>
						  <a href="http://www.raspberrypints.com"><img src="img/RaspberryPints-4k.png" height="200" alt=""></a>
					  <?php } else { ?>
						  <a href="http://www.raspberrypints.com"><img src="img/RaspberryPints.png" height="100" alt=""></a>
					  <?php } ?>
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
                <?php if($config[ConfigNames::ShowGravity]){ ?>
								  GRAVITY<hr>
                <?php } ?>
                COLOR
							</th>
						<?php } ?>

						<?php if($config[ConfigNames::ShowIbuCol]){ ?>
              <th class="ibu">
                <?php if($config[ConfigNames::ShowBalance]){ ?>
                  BALANCE<hr>
                <?php } ?>
								BITTERNESS
							</th>
						<?php } ?>

						<th class="name">
							BEER NAME &nbsp; & &nbsp; STYLE<hr>TASTING NOTES
						</th>

						<?php if($config[ConfigNames::ShowAbvCol]){ ?>
							<th class="abv">
                <?php if($config[ConfigNames::ShowCalories]){ ?>
                  CALORIES<hr>
                <?php } ?>
								ALCOHOL
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
                    <?php if($config[ConfigNames::ShowGravity]){ ?>
                      <h3>Unknown OG</h3>
                    <?php } ?>

										<div class="srm-container">
											<div class="srm-indicator" style="background-color: rgb(<?php echo $beer['srmRgb'] != "" ? $beer['srmRgb'] : "0,0,0" ?>)"></div>
											<div class="srm-stroke"></div>
										</div>

										<h2><?php echo $beer['srm']; ?> SRM</h2>

									</td>
								<?php } ?>

								<?php if($config[ConfigNames::ShowIbuCol]){ ?>
									<td class="ibu">
                    <?php if($config[ConfigNames::ShowBalance]){ ?>
                      <h3>0.00 BU:GU</h3>
                    <?php } ?>

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
								<?php } ?>

								<td class="name">
									<h1><?php echo $beer['beername']; ?></h1>
									<h2 class="subhead"><?php echo $beer['style']; ?></h2>
									<p><?php echo $beer['notes']; ?></p>
								</td>

								<?php if(($config[ConfigNames::ShowAbvCol]) && ($config[ConfigNames::ShowAbvImg])){ ?>
									<td class="abv">
                    <?php if($config[ConfigNames::ShowCalories]){ ?>
                      <h3>
                        <?php
  											echo number_format(0), " kCal";
  											?>
                      </h3>
                    <?php } ?>
										<div class="abv-container">
											<?php
												$abv = $beer['abv'];
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
										<h2><?php echo number_format($abv, 1, '.', ',')."%"; ?></h2>
									</td>
								<?php } ?>

								<?php if(($config[ConfigNames::ShowAbvCol]) && ! ($config[ConfigNames::ShowAbvImg])){ ?>
									<td class="abv">
                    <?php if($config[ConfigNames::ShowCalories]){ ?>
                      <h3>
                        <?php
  											echo number_format(0), " kCal";
  											?>
                      </h3>
                    <?php } ?>
										<div class="abv">
											<?php
												$abv = $beer['abv'];
											?>
										</div>
										<h2><?php echo number_format($abv, 1, '.', ',')."%"; ?></h2>
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
		</div>
	</body>
</html>
