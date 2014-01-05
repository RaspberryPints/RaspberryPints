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
		<div class="TitleBarBack">
		</div>
		
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
		
		
		<?php
		for( $i = 1; $i < count($srm); $i++){ 
			$rowIsEven = false;
			if( $i == 1 ){
				$containerClass = 'row-1st';
			}else if( $i % 2 == 0 ){
				$containerClass = 'row-even';
				$rowIsEven = true;
			}else{
				$containerClass = 'row-odd';
			}
		
		?>
			
			<div class="<?php echo $containerClass ?>">
			
				<?php 
					if( $rowIsEven ){
						echo '<div class="Shading"></div>';
						echo '<div class="row-even-a">';
					}
				?>
			
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
						<?php
						if ($ibu['Beer'.$i] > 100)
							echo "<img src=\"/img/ibu/", "offthechart", ".png\" height=\"100\" alt=\"\"><br>";
						else
							echo "<img src=\"/img/ibu/", $ibu['Beer'.$i], ".png\" height=\"100\" alt=\"\"><br>";
						?>
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
						if ($abv['Beer'.$i] > 10)
							echo "<img src=\"/img/abv/", "offthechart", ".png\" height=\"100\" alt=\"\"><br>";
						else
							echo "<img src=\"/img/abv/", (round(($abv['Beer'.$i]*20*2), -1, PHP_ROUND_HALF_UP)/2), ".png\" height=\"100\" alt=\"\"><br>";
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
						if ($keglvl['Beer'.$i] < 0)
							echo "<img src=\"/img/keg/0.png\" height=\"100\" alt=\"\"><br>";
						elseif ($keglvl['Beer'.$i] > 100)
							echo "<img src=\"/img/keg/100.png\" height=\"100\" alt=\"\"><br>";
						else
							echo "<img src=\"/img/keg/", $keglvl['Beer'.$i], ".png\" height=\"100\" alt=\"\"><br>";
						?>
					</div>
					<div class="LeftNumber">
						<h2><?php echo number_format((float)($kegsize * 128 * ($keglvl['Beer'.$i] / 100) / $avgpour),1, '.', ''); ?> left</h2>
					</div>
				</div>
				
				<?php 
					if( $rowIsEven ){
						echo '</div>';
					}
				?>
			</div>
		<?php } ?>
	</body>
</html>
