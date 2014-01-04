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
		
		<!-- Tap 1 -->
		<div class="row-1st">
			<div class="SRMcolumn">
				<div class="OGnumber">
					<h3><?php echo $og['Beer1']; ?> OG</h3>
				</div>
				<div class="SRMimage">
					<?php
					if ($srm['Beer1'] > 30)
						echo "<img src=\"/img/srm/", "offthechart", ".png\" height=\"100\"  alt=\"\"><br>";
					else
						echo "<img src=\"/img/srm/", $srm['Beer1'], ".png\" height=\"100\"  alt=\"\"><br>";
					?>
				</div>
				<div class="SRMnumber">
					<h2><?php echo $srm['Beer1']; ?> SRM</h2>
				</div>
			</div>
			<div class="IBUcolumn">
				<div class="BUGUnumber">
					<h3><?php echo number_format((float)($ibu['Beer1']/(($og['Beer1']-1)*1000)), 2, '.', ''); ?> BU:GU</h3>
				</div>
				<div class="IBUimage">
					<?php
					if ($ibu['Beer1'] > 100)
						echo "<img src=\"/img/ibu/", "offthechart", ".png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/ibu/", $ibu['Beer1'], ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="IBUnumber">
					<h2><?php echo $ibu['Beer1'];?> IBU</h2>
				</div>
			</div>
			<div class="BeerNameColumn">
				<div class="BeerName">
					<?php echo "<h1>", $beername['Beer1'], "</h1>"; ?>
				</div>
				<div class="BeerStyle">
					<?php echo "<h2>", $style['Beer1'], "</h2>"; ?>
				</div>
				<div class="TastingNotes">
					<div>
						<?php echo "<p><b>&#8220;</b>",$notes['Beer1'], "<b>&#8221;</b></p>"; ?>
					</div>
				</div>
			</div>
			<div class="ABVcolumn">
				<div class="KCALnumber">
					<h3><?php echo $kcal['Beer1']; ?> kCal</h3>
				</div>
				<div class="ABVimage">
					<?php
					if ($abv['Beer1'] > 10)
						echo "<img src=\"/img/abv/", "offthechart", ".png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/abv/", (round(($abv['Beer1']*20*2), -1, PHP_ROUND_HALF_UP)/2), ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="ABVnumber">
					<h2><?php echo $abv['Beer1'], "%"; ?> ABV</h2>
				</div>
			</div>
			<div class="KegColumn">
				<div class="PouredNumber">
					<h3><?php echo number_format((float)($kegsize * 128 * (1 - $keglvl['Beer1'] / 100) / $avgpour),1, '.', ''); ?> poured</h3>
				</div>
				<div class="KegImage">
					<?php
					if ($keglvl['Beer1'] < 0)
						echo "<img src=\"/img/keg/0.png\" height=\"100\" alt=\"\"><br>";
					elseif ($keglvl['Beer1'] > 100)
						echo "<img src=\"/img/keg/100.png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/keg/", $keglvl['Beer1'], ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="LeftNumber">
					<h2><?php echo number_format((float)($kegsize * 128 * ($keglvl['Beer1'] / 100) / $avgpour),1, '.', ''); ?> left</h2>
				</div>
			</div>
		</div>
		<!-- Tap 1 end -->
		
		<!-- Tap 2 -->
		<div class="row-even">
			<div class="Shading">
			</div>		
			<div class="row-even-a">
			<div class="SRMcolumn">
				<div class="OGnumber">
					<h3><?php echo $og['Beer2']; ?> OG</h3>
				</div>
				<div class="SRMimage">
					<?php
					if ($srm['Beer2'] > 30)
						echo "<img src=\"/img/srm/", "offthechart", ".png\" height=\"100\"  alt=\"\"><br>";
					else
						echo "<img src=\"/img/srm/", $srm['Beer2'], ".png\" height=\"100\"  alt=\"\"><br>";
					?>
				</div>
				<div class="SRMnumber">
					<h2><?php echo $srm['Beer2']; ?> SRM</h2>
				</div>
			</div>
			<div class="IBUcolumn">
				<div class="BUGUnumber">
					<h3><?php echo number_format((float)($ibu['Beer2']/(($og['Beer2']-1)*1000)), 2, '.', ''); ?> BU:GU</h3>
				</div>
				<div class="IBUimage">
					<?php
					if ($ibu['Beer2'] > 100)
						echo "<img src=\"/img/ibu/", "offthechart", ".png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/ibu/", $ibu['Beer2'], ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="IBUnumber">
					<h2><?php echo $ibu['Beer2'];?> IBU</h2>
				</div>
			</div>
			<div class="BeerNameColumn">
				<div class="BeerName">
					<?php echo "<h1>", $beername['Beer2'], "</h1>"; ?>
				</div>
				<div class="clear"></div>
				<div class="BeerStyle">
					<?php echo "<h2>", $style['Beer2'], "</h2>"; ?>
				</div>
				<div class="TastingNotes">
					<div>
						<?php echo "<p><b>&#8220;</b>",$notes['Beer2'], "<b>&#8221;</b></p>"; ?>
					</div>
				</div>
			</div>
			<div class="ABVcolumn">
				<div class="KCALnumber">
					<h3><?php echo $kcal['Beer2']; ?> kCal</h3>
				</div>
				<div class="ABVimage">
					<?php
					if ($abv['Beer2'] > 10)
						echo "<img src=\"/img/abv/", "offthechart", ".png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/abv/", (round(($abv['Beer2']*20*2), -1, PHP_ROUND_HALF_UP)/2), ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="ABVnumber">
					<h2><?php echo $abv['Beer2'], "%"; ?> ABV</h2>
				</div>
			</div>
			<div class="KegColumn">
				<div class="PouredNumber">
					<h3><?php echo number_format((float)($kegsize * 128 * (1 - $keglvl['Beer2'] / 100) / $avgpour),1, '.', ''); ?> poured</h3>
				</div>
				<div class="KegImage">
					<?php
					if ($keglvl['Beer2'] < 0)
						echo "<img src=\"/img/keg/0.png\" height=\"100\" alt=\"\"><br>";
					elseif ($keglvl['Beer2'] > 100)
						echo "<img src=\"/img/keg/100.png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/keg/", $keglvl['Beer2'], ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="LeftNumber">
					<h2><?php echo number_format((float)($kegsize * 128 * ($keglvl['Beer2'] / 100) / $avgpour),1, '.', ''); ?> left</h2>
				</div>
			</div>
			</div>
		</div>
		<!-- Tap 2 end -->
		
		<!-- Tap 3 -->		
		<div class="row-odd">
			<div class="SRMcolumn">
				<div class="OGnumber">
					<h3><?php echo $og['Beer3']; ?> OG</h3>
				</div>
				<div class="SRMimage">
					<?php
					if ($srm['Beer3'] > 30)
						echo "<img src=\"/img/srm/", "offthechart", ".png\" height=\"100\"  alt=\"\"><br>";
					else
						echo "<img src=\"/img/srm/", $srm['Beer3'], ".png\" height=\"100\"  alt=\"\"><br>";
					?>
				</div>
				<div class="SRMnumber">
					<h2><?php echo $srm['Beer3']; ?> SRM</h2>
				</div>
			</div>
			<div class="IBUcolumn">
				<div class="BUGUnumber">
					<h3><?php echo number_format((float)($ibu['Beer3']/(($og['Beer3']-1)*1000)), 2, '.', ''); ?> BU:GU</h3>
				</div>
				<div class="IBUimage">
					<?php
					if ($ibu['Beer3'] > 100)
						echo "<img src=\"/img/ibu/", "offthechart", ".png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/ibu/", $ibu['Beer3'], ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="IBUnumber">
					<h2><?php echo $ibu['Beer3'];?> IBU</h2>
				</div>
			</div>
			<div class="BeerNameColumn">
				<div class="BeerName">
					<?php echo "<h1>", $beername['Beer3'], "</h1>"; ?>
				</div>
				<div class="clear"></div>
				<div class="BeerStyle">
					<?php echo "<h2>", $style['Beer3'], "</h2>"; ?>
				</div>
				<div class="TastingNotes">
					<div>
						<?php echo "<p><b>&#8220;</b>",$notes['Beer3'], "<b>&#8221;</b></p>"; ?>
					</div>
				</div>
			</div>
			<div class="ABVcolumn">
				<div class="KCALnumber">
					<h3><?php echo $kcal['Beer3']; ?> kCal</h3>
				</div>
				<div class="ABVimage">
					<?php
					if ($abv['Beer3'] > 10)
						echo "<img src=\"/img/abv/", "offthechart", ".png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/abv/", (round(($abv['Beer3']*20*2), -1, PHP_ROUND_HALF_UP)/2), ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="ABVnumber">
					<h2><?php echo $abv['Beer3'], "%"; ?> ABV</h2>
				</div>
			</div>
			<div class="KegColumn">
				<div class="PouredNumber">
					<h3><?php echo number_format((float)($kegsize * 128 * (1 - $keglvl['Beer3'] / 100) / $avgpour),1, '.', ''); ?> poured</h3>
				</div>
				<div class="KegImage">
					<?php
					if ($keglvl['Beer3'] < 0)
						echo "<img src=\"/img/keg/0.png\" height=\"100\" alt=\"\"><br>";
					elseif ($keglvl['Beer3'] > 100)
						echo "<img src=\"/img/keg/100.png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/keg/", $keglvl['Beer3'], ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="LeftNumber">
					<h2><?php echo number_format((float)($kegsize * 128 * ($keglvl['Beer3'] / 100) / $avgpour),1, '.', ''); ?> left</h2>
				</div>
			</div>
		</div>
		<!-- Tap 3 end -->

		<!-- Tap 4 -->
		<div class="row-even">
			<div class="Shading">
			</div>		
			<div class="row-even-a">
			<div class="SRMcolumn">
				<div class="OGnumber">
					<h3><?php echo $og['Beer4']; ?> OG</h3>
				</div>
				<div class="SRMimage">
					<?php
					if ($srm['Beer4'] > 30)
						echo "<img src=\"/img/srm/", "offthechart", ".png\" height=\"100\"  alt=\"\"><br>";
					else
						echo "<img src=\"/img/srm/", $srm['Beer4'], ".png\" height=\"100\"  alt=\"\"><br>";
					?>
				</div>
				<div class="SRMnumber">
					<h2><?php echo $srm['Beer4']; ?> SRM</h2>
				</div>
			</div>
			<div class="IBUcolumn">
				<div class="BUGUnumber">
					<h3><?php echo number_format((float)($ibu['Beer4']/(($og['Beer4']-1)*1000)), 2, '.', ''); ?> BU:GU</h3>
				</div>
				<div class="IBUimage">
					<?php
					if ($ibu['Beer4'] > 100)
						echo "<img src=\"/img/ibu/", "offthechart", ".png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/ibu/", $ibu['Beer4'], ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="IBUnumber">
					<h2><?php echo $ibu['Beer4'];?> IBU</h2>
				</div>
			</div>
			<div class="BeerNameColumn">
				<div class="BeerName">
					<?php echo "<h1>", $beername['Beer4'], "</h1>"; ?>
				</div>
				<div class="clear"></div>
				<div class="BeerStyle">
					<?php echo "<h2>", $style['Beer4'], "</h2>"; ?>
				</div>
				<div class="TastingNotes">
					<div>
						<?php echo "<p><b>&#8220;</b>",$notes['Beer4'], "<b>&#8221;</b></p>"; ?>
					</div>
				</div>
			</div>
			<div class="ABVcolumn">
				<div class="KCALnumber">
					<h3><?php echo $kcal['Beer4']; ?> kCal</h3>
				</div>
				<div class="ABVimage">
					<?php
					if ($abv['Beer4'] > 10)
						echo "<img src=\"/img/abv/", "offthechart", ".png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/abv/", (round(($abv['Beer4']*20*2), -1, PHP_ROUND_HALF_UP)/2), ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="ABVnumber">
					<h2><?php echo $abv['Beer4'], "%"; ?> ABV</h2>
				</div>
			</div>
			<div class="KegColumn">
				<div class="PouredNumber">
					<h3><?php echo number_format((float)($kegsize * 128 * (1 - $keglvl['Beer4'] / 100) / $avgpour),1, '.', ''); ?> poured</h3>
				</div>
				<div class="KegImage">
					<?php
					if ($keglvl['Beer4'] < 0)
						echo "<img src=\"/img/keg/0.png\" height=\"100\" alt=\"\"><br>";
					elseif ($keglvl['Beer4'] > 100)
						echo "<img src=\"/img/keg/100.png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/keg/", $keglvl['Beer4'], ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="LeftNumber">
					<h2><?php echo number_format((float)($kegsize * 128 * ($keglvl['Beer4'] / 100) / $avgpour),1, '.', ''); ?> left</h2>
				</div>
			</div>
			</div>
		</div>
		<!-- Tap 4 end -->

		<!-- Tap 5 -->
		<div class="row-odd">
			<div class="SRMcolumn">
				<div class="OGnumber">
					<h3><?php echo $og['Beer5']; ?> OG</h3>
				</div>
				<div class="SRMimage">
					<?php
					if ($srm['Beer5'] > 30)
						echo "<img src=\"/img/srm/", "offthechart", ".png\" height=\"100\"  alt=\"\"><br>";
					else
						echo "<img src=\"/img/srm/", $srm['Beer5'], ".png\" height=\"100\"  alt=\"\"><br>";
					?>
				</div>
				<div class="SRMnumber">
					<h2><?php echo $srm['Beer5']; ?> SRM</h2>
				</div>
			</div>
			<div class="IBUcolumn">
				<div class="BUGUnumber">
					<h3><?php echo number_format((float)($ibu['Beer5']/(($og['Beer5']-1)*1000)), 2, '.', ''); ?> BU:GU</h3>
				</div>
				<div class="IBUimage">
					<?php
					if ($ibu['Beer5'] > 100)
						echo "<img src=\"/img/ibu/", "offthechart", ".png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/ibu/", $ibu['Beer5'], ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="IBUnumber">
					<h2><?php echo $ibu['Beer5'];?> IBU</h2>
				</div>
			</div>
			<div class="BeerNameColumn">
				<div class="BeerName">
					<?php echo "<h1>", $beername['Beer5'], "</h1>"; ?>
				</div>
				<div class="clear"></div>
				<div class="BeerStyle">
					<?php echo "<h2>", $style['Beer5'], "</h2>"; ?>
				</div>
				<div class="TastingNotes">
					<div>
						<?php echo "<p><b>&#8220;</b>",$notes['Beer5'], "<b>&#8221;</b></p>"; ?>
					</div>
				</div>
			</div>
			<div class="ABVcolumn">
				<div class="KCALnumber">
					<h3><?php echo $kcal['Beer5']; ?> kCal</h3>
				</div>
				<div class="ABVimage">
					<?php
					if ($abv['Beer5'] > 10)
						echo "<img src=\"/img/abv/", "offthechart", ".png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/abv/", (round(($abv['Beer5']*20*2), -1, PHP_ROUND_HALF_UP)/2), ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="ABVnumber">
					<h2><?php echo $abv['Beer5'], "%"; ?> ABV</h2>
				</div>
			</div>
			<div class="KegColumn">
				<div class="PouredNumber">
					<h3><?php echo number_format((float)($kegsize * 128 * (1 - $keglvl['Beer5'] / 100) / $avgpour),1, '.', ''); ?> poured</h3>
				</div>
				<div class="KegImage">
					<?php
					if ($keglvl['Beer5'] < 0)
						echo "<img src=\"/img/keg/0.png\" height=\"100\" alt=\"\"><br>";
					elseif ($keglvl['Beer5'] > 100)
						echo "<img src=\"/img/keg/100.png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/keg/", $keglvl['Beer5'], ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="LeftNumber">
					<h2><?php echo number_format((float)($kegsize * 128 * ($keglvl['Beer5'] / 100) / $avgpour),1, '.', ''); ?> left</h2>
				</div>
			</div>
		</div>
		<!-- Tap 5 end -->

		<!-- Tap 6 -->
		<div class="row-even">
			<div class="Shading">
			</div>		
			<div class="row-even-a">
			<div class="SRMcolumn">
				<div class="OGnumber">
					<h3><?php echo $og['Beer6']; ?> OG</h3>
				</div>
				<div class="SRMimage">
					<?php
					if ($srm['Beer6'] > 30)
						echo "<img src=\"/img/srm/", "offthechart", ".png\" height=\"100\"  alt=\"\"><br>";
					else
						echo "<img src=\"/img/srm/", $srm['Beer6'], ".png\" height=\"100\"  alt=\"\"><br>";
					?>
				</div>
				<div class="SRMnumber">
					<h2><?php echo $srm['Beer6']; ?> SRM</h2>
				</div>
			</div>
			<div class="IBUcolumn">
				<div class="BUGUnumber">
					<h3><?php echo number_format((float)($ibu['Beer6']/(($og['Beer6']-1)*1000)), 2, '.', ''); ?> BU:GU</h3>
				</div>
				<div class="IBUimage">
					<?php
					if ($ibu['Beer6'] > 100)
						echo "<img src=\"/img/ibu/", "offthechart", ".png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/ibu/", $ibu['Beer6'], ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="IBUnumber">
					<h2><?php echo $ibu['Beer6'];?> IBU</h2>
				</div>
			</div>
			<div class="BeerNameColumn">
				<div class="BeerName">
					<?php echo "<h1>", $beername['Beer6'], "</h1>"; ?>
				</div>
				<div class="clear"></div>
				<div class="BeerStyle">
					<?php echo "<h2>", $style['Beer6'], "</h2>"; ?>
				</div>
				<div class="TastingNotes">
					<div>
						<?php echo "<p><b>&#8220;</b>",$notes['Beer6'], "<b>&#8221;</b></p>"; ?>
					</div>
				</div>
			</div>
			<div class="ABVcolumn">
				<div class="KCALnumber">
					<h3><?php echo $kcal['Beer6']; ?> kCal</h3>
				</div>
				<div class="ABVimage">
					<?php
					if ($abv['Beer6'] > 10)
						echo "<img src=\"/img/abv/", "offthechart", ".png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/abv/", (round(($abv['Beer6']*20*2), -1, PHP_ROUND_HALF_UP)/2), ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="ABVnumber">
					<h2><?php echo $abv['Beer6'], "%"; ?> ABV</h2>
				</div>
			</div>
			<div class="KegColumn">
				<div class="PouredNumber">
					<h3><?php echo number_format((float)($kegsize * 128 * (1 - $keglvl['Beer6'] / 100) / $avgpour),1, '.', ''); ?> poured</h3>
				</div>
				<div class="KegImage">
					<?php
					if ($keglvl['Beer6'] < 0)
						echo "<img src=\"/img/keg/0.png\" height=\"100\" alt=\"\"><br>";
					elseif ($keglvl['Beer6'] > 100)
						echo "<img src=\"/img/keg/100.png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/keg/", $keglvl['Beer6'], ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="LeftNumber">
					<h2><?php echo number_format((float)($kegsize * 128 * ($keglvl['Beer6'] / 100) / $avgpour),1, '.', ''); ?> left</h2>
				</div>
			</div>
			</div>
		</div>
		<!-- Tap 6 end -->

		<!-- Tap 7 -->
		<div class="row-odd">
			<div class="SRMcolumn">
				<div class="OGnumber">
					<h3><?php echo $og['Beer7']; ?> OG</h3>
				</div>
				<div class="SRMimage">
					<?php
					if ($srm['Beer7'] > 30)
						echo "<img src=\"/img/srm/", "offthechart", ".png\" height=\"100\"  alt=\"\"><br>";
					else
						echo "<img src=\"/img/srm/", $srm['Beer7'], ".png\" height=\"100\"  alt=\"\"><br>";
					?>
				</div>
				<div class="SRMnumber">
					<h2><?php echo $srm['Beer7']; ?> SRM</h2>
				</div>
			</div>
			<div class="IBUcolumn">
				<div class="BUGUnumber">
					<h3><?php echo number_format((float)($ibu['Beer7']/(($og['Beer7']-1)*1000)), 2, '.', ''); ?> BU:GU</h3>
				</div>
				<div class="IBUimage">
					<?php
					if ($ibu['Beer7'] > 100)
						echo "<img src=\"/img/ibu/", "offthechart", ".png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/ibu/", $ibu['Beer7'], ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="IBUnumber">
					<h2><?php echo $ibu['Beer7'];?> IBU</h2>
				</div>
			</div>
			<div class="BeerNameColumn">
				<div class="BeerName">
					<?php echo "<h1>", $beername['Beer7'], "</h1>"; ?>
				</div>
				<div class="clear"></div>
				<div class="BeerStyle">
					<?php echo "<h2>", $style['Beer7'], "</h2>"; ?>
				</div>
				<div class="TastingNotes">
					<div>
						<?php echo "<p><b>&#8220;</b>",$notes['Beer7'], "<b>&#8221;</b></p>"; ?>
					</div>
				</div>
			</div>
			<div class="ABVcolumn">
				<div class="KCALnumber">
					<h3><?php echo $kcal['Beer7']; ?> kCal</h3>
				</div>
				<div class="ABVimage">
					<?php
					if ($abv['Beer7'] > 10)
						echo "<img src=\"/img/abv/", "offthechart", ".png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/abv/", (round(($abv['Beer7']*20*2), -1, PHP_ROUND_HALF_UP)/2), ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="ABVnumber">
					<h2><?php echo $abv['Beer7'], "%"; ?> ABV</h2>
				</div>
			</div>
			<div class="KegColumn">
				<div class="PouredNumber">
					<h3><?php echo number_format((float)($kegsize * 128 * (1 - $keglvl['Beer7'] / 100) / $avgpour),1, '.', ''); ?> poured</h3>
				</div>
				<div class="KegImage">
					<?php
					if ($keglvl['Beer7'] < 0)
						echo "<img src=\"/img/keg/0.png\" height=\"100\" alt=\"\"><br>";
					elseif ($keglvl['Beer7'] > 100)
						echo "<img src=\"/img/keg/100.png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/keg/", $keglvl['Beer7'], ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="LeftNumber">
					<h2><?php echo number_format((float)($kegsize * 128 * ($keglvl['Beer7'] / 100) / $avgpour),1, '.', ''); ?> left</h2>
				</div>
			</div>
		</div>
		<!-- Tap 7 end -->

		<!-- Tap 8 -->
		<div class="row-even">
			<div class="Shading">
			</div>		
		<div class="row-even-a">
			<div class="SRMcolumn">
				<div class="OGnumber">
					<h3><?php echo $og['Beer8']; ?> OG</h3>
				</div>
				<div class="SRMimage">
					<?php
					if ($srm['Beer8'] > 30)
						echo "<img src=\"/img/srm/", "offthechart", ".png\" height=\"100\"  alt=\"\"><br>";
					else
						echo "<img src=\"/img/srm/", $srm['Beer8'], ".png\" height=\"100\"  alt=\"\"><br>";
					?>
				</div>
				<div class="SRMnumber">
					<h2><?php echo $srm['Beer8']; ?> SRM</h2>
				</div>
			</div>
			<div class="IBUcolumn">
				<div class="BUGUnumber">
					<h3><?php echo number_format((float)($ibu['Beer8']/(($og['Beer8']-1)*1000)), 2, '.', ''); ?> BU:GU</h3>
				</div>
				<div class="IBUimage">
					<?php
					if ($ibu['Beer8'] > 100)
						echo "<img src=\"/img/ibu/", "offthechart", ".png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/ibu/", $ibu['Beer8'], ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="IBUnumber">
					<h2><?php echo $ibu['Beer8'];?> IBU</h2>
				</div>
			</div>
			<div class="BeerNameColumn">
				<div class="BeerName">
					<?php echo "<h1>", $beername['Beer8'], "</h1>"; ?>
				</div>
				<div class="clear"></div>
				<div class="BeerStyle">
					<?php echo "<h2>", $style['Beer8'], "</h2>"; ?>
				</div>
				<div class="TastingNotes">
					<div>
						<?php echo "<p><b>&#8220;</b>",$notes['Beer8'], "<b>&#8221;</b></p>"; ?>
					</div>
				</div>
			</div>
			<div class="ABVcolumn">
				<div class="KCALnumber">
					<h3><?php echo $kcal['Beer8']; ?> kCal</h3>
				</div>
				<div class="ABVimage">
					<?php
					if ($abv['Beer8'] > 10)
						echo "<img src=\"/img/abv/", "offthechart", ".png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/abv/", (round(($abv['Beer8']*20*2), -1, PHP_ROUND_HALF_UP)/2), ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="ABVnumber">
					<h2><?php echo $abv['Beer8'], "%"; ?> ABV</h2>
				</div>
			</div>
			<div class="KegColumn">
				<div class="PouredNumber">
					<h3><?php echo number_format((float)($kegsize * 128 * (1 - $keglvl['Beer8'] / 100) / $avgpour),1, '.', ''); ?> poured</h3>
				</div>
				<div class="KegImage">
					<?php
					if ($keglvl['Beer8'] < 0)
						echo "<img src=\"/img/keg/0.png\" height=\"100\" alt=\"\"><br>";
					elseif ($keglvl['Beer8'] > 100)
						echo "<img src=\"/img/keg/100.png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/keg/", $keglvl['Beer8'], ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="LeftNumber">
					<h2><?php echo number_format((float)($kegsize * 128 * ($keglvl['Beer8'] / 100) / $avgpour),1, '.', ''); ?> left</h2>
				</div>
			</div>
			</div>
		</div>
		<!-- Tap 8 end -->

		<!-- Tap 9 -->
		<div class="row-odd">
			<div class="SRMcolumn">
				<div class="OGnumber">
					<h3><?php echo $og['Beer9']; ?> OG</h3>
				</div>
				<div class="SRMimage">
					<?php
					if ($srm['Beer9'] > 30)
						echo "<img src=\"/img/srm/", "offthechart", ".png\" height=\"100\"  alt=\"\"><br>";
					else
						echo "<img src=\"/img/srm/", $srm['Beer9'], ".png\" height=\"100\"  alt=\"\"><br>";
					?>
				</div>
				<div class="SRMnumber">
					<h2><?php echo $srm['Beer9']; ?> SRM</h2>
				</div>
			</div>
			<div class="IBUcolumn">
				<div class="BUGUnumber">
					<h3><?php echo number_format((float)($ibu['Beer9']/(($og['Beer9']-1)*1000)), 2, '.', ''); ?> BU:GU</h3>
				</div>
				<div class="IBUimage">
					<?php
					if ($ibu['Beer9'] > 100)
						echo "<img src=\"/img/ibu/", "offthechart", ".png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/ibu/", $ibu['Beer9'], ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="IBUnumber">
					<h2><?php echo $ibu['Beer9'];?> IBU</h2>
				</div>
			</div>
			<div class="BeerNameColumn">
				<div class="BeerName">
					<?php echo "<h1>", $beername['Beer9'], "</h1>"; ?>
				</div>
				<div class="clear"></div>
				<div class="BeerStyle">
					<?php echo "<h2>", $style['Beer9'], "</h2>"; ?>
				</div>
				<div class="TastingNotes">
					<div>
						<?php echo "<p><b>&#8220;</b>",$notes['Beer9'], "<b>&#8221;</b></p>"; ?>
					</div>
				</div>
			</div>
			<div class="ABVcolumn">
				<div class="KCALnumber">
					<h3><?php echo $kcal['Beer9']; ?> kCal</h3>
				</div>
				<div class="ABVimage">
					<?php
					if ($abv['Beer9'] > 10)
						echo "<img src=\"/img/abv/", "offthechart", ".png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/abv/", (round(($abv['Beer9']*20*2), -1, PHP_ROUND_HALF_UP)/2), ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="ABVnumber">
					<h2><?php echo $abv['Beer9'], "%"; ?> ABV</h2>
				</div>
			</div>
			<div class="KegColumn">
				<div class="PouredNumber">
					<h3><?php echo number_format((float)($kegsize * 128 * (1 - $keglvl['Beer9'] / 100) / $avgpour),1, '.', ''); ?> poured</h3>
				</div>
				<div class="KegImage">
					<?php
					if ($keglvl['Beer9'] < 0)
						echo "<img src=\"/img/keg/0.png\" height=\"100\" alt=\"\"><br>";
					elseif ($keglvl['Beer9'] > 100)
						echo "<img src=\"/img/keg/100.png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/keg/", $keglvl['Beer9'], ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="LeftNumber">
					<h2><?php echo number_format((float)($kegsize * 128 * ($keglvl['Beer9'] / 100) / $avgpour),1, '.', ''); ?> left</h2>
				</div>
			</div>
		</div>
		<!-- Tap 9 end -->

		<!-- Tap 10 -->
		<div class="row-even">
			<div class="Shading">
			</div>		
			<div class="row-even-a">
			<div class="SRMcolumn">
				<div class="OGnumber">
					<h3><?php echo $og['Beer10']; ?> OG</h3>
				</div>
				<div class="SRMimage">
					<?php
					if ($srm['Beer10'] > 30)
						echo "<img src=\"/img/srm/", "offthechart", ".png\" height=\"100\"  alt=\"\"><br>";
					else
						echo "<img src=\"/img/srm/", $srm['Beer10'], ".png\" height=\"100\"  alt=\"\"><br>";
					?>
				</div>
				<div class="SRMnumber">
					<h2><?php echo $srm['Beer10']; ?> SRM</h2>
				</div>
			</div>
			<div class="IBUcolumn">
				<div class="BUGUnumber">
					<h3><?php echo number_format((float)($ibu['Beer10']/(($og['Beer10']-1)*1000)), 2, '.', ''); ?> BU:GU</h3>
				</div>
				<div class="IBUimage">
					<?php
					if ($ibu['Beer10'] > 100)
						echo "<img src=\"/img/ibu/", "offthechart", ".png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/ibu/", $ibu['Beer10'], ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="IBUnumber">
					<h2><?php echo $ibu['Beer10'];?> IBU</h2>
				</div>
			</div>
			<div class="BeerNameColumn">
				<div class="BeerName">
					<?php echo "<h1>", $beername['Beer10'], "</h1>"; ?>
				</div>
				<div class="clear"></div>
				<div class="BeerStyle">
					<?php echo "<h2>", $style['Beer10'], "</h2>"; ?>
				</div>
				<div class="TastingNotes">
					<div>
						<?php echo "<p><b>&#8220;</b>",$notes['Beer10'], "<b>&#8221;</b></p>"; ?>
					</div>
				</div>
			</div>
			<div class="ABVcolumn">
				<div class="KCALnumber">
					<h3><?php echo $kcal['Beer10']; ?> kCal</h3>
				</div>
				<div class="ABVimage">
					<?php
					if ($abv['Beer10'] > 10)
						echo "<img src=\"/img/abv/", "offthechart", ".png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/abv/", (round(($abv['Beer10']*20*2), -1, PHP_ROUND_HALF_UP)/2), ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="ABVnumber">
					<h2><?php echo $abv['Beer10'], "%"; ?> ABV</h2>
				</div>
			</div>
			<div class="KegColumn">
				<div class="PouredNumber">
					<h3><?php echo number_format((float)($kegsize * 128 * (1 - $keglvl['Beer10'] / 100) / $avgpour),1, '.', ''); ?> poured</h3>
				</div>
				<div class="KegImage">
					<?php
					if ($keglvl['Beer10'] < 0)
						echo "<img src=\"/img/keg/0.png\" height=\"100\" alt=\"\"><br>";
					elseif ($keglvl['Beer10'] > 100)
						echo "<img src=\"/img/keg/100.png\" height=\"100\" alt=\"\"><br>";
					else
						echo "<img src=\"/img/keg/", $keglvl['Beer10'], ".png\" height=\"100\" alt=\"\"><br>";
					?>
				</div>
				<div class="LeftNumber">
					<h2><?php echo number_format((float)($kegsize * 128 * ($keglvl['Beer10'] / 100) / $avgpour),1, '.', ''); ?> left</h2>
				</div>
			</div>
			</div>
		</div>
		<!-- Tap 10 end -->
	</body>
</html>
