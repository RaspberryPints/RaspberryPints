<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html>
	<head>
		<title>Kegerface v0.5</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		
		<!-- Set location of Cascading Style Sheet -->	
		<link rel="stylesheet" type="text/css" href="style.css">
		
		<?php
			// Set keezer specifics
			$kegsize = 5;     // (in gallons)
			$avgpour = 12;   // (in fluid ounces)
		
			// Define variables and arrays 
			$beername = array();
			$style = array();
			$notes = array();					
			$notes = array();					
			$abv = array();					
			$ibu = array();
			$srm = array();
			$keglvl = array();

			// Set location of CSV
			$beersurl = "beers.csv";
			
			// Write CSV information into arrays
			$handle = fopen($beersurl, "r");
				while (($data = fgetcsv($handle, 1000, "|")) !== FALSE) {
					if($data[0] != ""){
						$og[$data[0]] = $data[1];
						$srm[$data[0]] = $data[2];
						$ibu[$data[0]] = $data[3];
						$abv[$data[0]] = $data[4];
						$kcal[$data[0]] = $data[5];
						$keglvl[$data[0]] = $data[6];
						$beername[$data[0]] = $data[7];
						$style[$data[0]] = $data[8];
						$notes[$data[0]] = $data[9];
					}
				}
			fclose($handle);
		?>
	</head>
	
	<body>
		<div class="header">
			<div class="HeaderLeft">
				<img src="/img/cryptid.png" height="100" alt="">
			</div>
			<div class="HeaderCenter">
				<h1>BEERS ON TAP</h1>
			</div>
			<div class="HeaderRight">
				<?php /*
				<br>
				<?php echo date('l'); ?>
				<br>
				<?php echo date('F jS, Y'); ?>
				<!--
				<?php
					$date=getdate(date("U"));
					print("$date[month] <br> $date[mday], $date[year]");
				?>
				-->
				
				*/ ?>	
			</div>
		</div>	
		<br>
		
		<!-- Background div for column headers -->
		<div class="TitleBarRow">
			
			<div class="TitleBarSRM">
				GRAVITY
				<hr>
				COLOR
			</div>

			<div class="TitleBarIBU">
				BALANCE
				<hr>
				BITTERNESS
			</div>
			
			<div class="TitleBarBeerName">
				BEER NAME &nbsp; / &nbsp; STYLE
				<hr>
				TASTING NOTES
			</div>
			
			<div class="TitleBarABV">
				CALORIES
				<hr>
				ALCOHOL
			</div>

			<div class="TitleBarKeg">
				POURED
				<hr>
				REMAINING
			</div>
		</div>
		
		<?php
		for( $i = 1; $i < count($srm); $i++){ 
			if( $i == 1 ){
				$containerClass = 'row-1st';
			}else if( $i % 2 == 0 ){
				$containerClass = 'row-even';
			}else{
				$containerClass = 'row-odd';
			}
		?>
			<div class="<?php echo $containerClass ?>">		
			
				<div class="SRMcolumn">
					<div class="OGnumber">
						<h3><?php echo $og['Beer'.$i]; ?> OG</h3>
					</div>
					<div class="SRMimage">
						<?php
						if ($srm['Beer'.$i] > 30)
							echo "<img src=\"/img/srm/", "offthechart", ".png\" height=\"100\"  alt=\"\"><br>";
						else
							echo "<img src=\"/img/srm/", $srm['Beer'.$i], ".png\" height=\"100\"  alt=\"\"><br>";
						?>
					</div>
					<div class="SRMnumber">
						<h2><?php echo $srm['Beer'.$i]; ?> SRM</h2>
					</div>
				</div>
				<div class="IBUcolumn">
					<div class="BUGUnumber">
						<h3><?php echo number_format((float)($ibu['Beer'.$i]/(($og['Beer'.$i]-1)*1000)), 2, '.', ''); ?> BU:GU</h3>
					</div>
					<div class="IBUimage">
						<div class="ibu-container">
							<?php
								$numHops = 0;
								$remaining = $ibu['Beer'.$i];
								for( $h = 0; $h < 10; $h++){						
									if( $remaining < 10 ){
										$level = $remaining;
									}else{
										$level = 10;
									}
									?><div class="ibu-indicator ibu-element ibu-element-<?php echo $h ?>"><div class="ibu-full" style="height:<?php echo $level * 10; ?>%"></div></div><?php
									
									$remaining = $remaining - $level;
									$numHops++;
								}
								
								if( $remaining > 0 ){
									?><img class="ibu-max" src="/img/ibu-new/offthechart.png" /><?php
								}
							?>
						</div>
					</div>
					<div class="IBUnumber">
						<h2><?php echo $ibu['Beer'.$i];?> IBU</h2>
					</div>
				</div>
				<div class="BeerNameColumn">
					<div class="BeerName">
						<?php echo "<h1>", $beername['Beer'.$i], "</h1>"; ?>
					</div>
					<div class="BeerStyle">
						<?php echo "<h2>", $style['Beer'.$i], "</h2>"; ?>
					</div>
					<div class="TastingNotes">
						<div>
							<?php echo "<p><b>&#8220;</b>",$notes['Beer'.$i], "<b>&#8221;</b></p>"; ?>
						</div>
					</div>
				</div>
				<div class="ABVcolumn">
					<div class="KCALnumber">
						<h3><?php echo $kcal['Beer'.$i]; ?> kCal</h3>
					</div>
					<div class="ABVimage">
						<?php
							$numCups = 0;
							$remaining = round(($abv['Beer'.$i]*20*2), -1, PHP_ROUND_HALF_UP)/2;
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
								?><img class="abv-max" src="/img/abv-new/offthechart.png" /><?php
							}
						?>
					</div>
					<div class="ABVnumber">
						<h2><?php echo $abv['Beer'.$i], "%"; ?> ABV</h2>
					</div>
				</div>
				<div class="KegColumn">
					<div class="PouredNumber">
						<h3><?php echo number_format((float)($kegsize * 128 * (1 - $keglvl['Beer'.$i] / 100) / $avgpour),1, '.', ''); ?> poured</h3>
					</div>
					<div class="KegImage">
						<?php 
							$kegImgClass = "";
							if( $keglvl['Beer'.$i] < 15 )
								$kegImgClass = "keg-red";
							else if( $keglvl['Beer'.$i] < 25 )
								$kegImgClass = "keg-orange";
							else if( $keglvl['Beer'.$i] < 45 )
								$kegImgClass = "keg-yellow";
							else
								$kegImgClass = "keg-green"
						?>
						<div class="keg-indicator"><div class="keg-full <?php echo $kegImgClass ?>" style="height:<?php echo $keglvl['Beer'.$i]; ?>%"></div></div>
					
					</div>
					<div class="LeftNumber">
						<h2><?php echo number_format((float)($kegsize * 128 * ($keglvl['Beer'.$i] / 100) / $avgpour),1, '.', ''); ?> left</h2>
					</div>
				</div>
			</div>
		<?php } ?>
	</body>
</html>
