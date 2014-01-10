<?php
	require("includes/php/config.php");
	
	//This can be used to choose between CSV or MYSQL DB
	$db = true;
	
	// Setup array for all the beers that will be contained in the list
	$beers = array();
	
	if($db){
		// Connect to the database
		db();
		$sql = "SELECT * FROM beer WHERE active = true ORDER BY tapnumber";
		$qry = mysql_query($sql);
		while($b = mysql_fetch_array($qry))
		{
			$beeritem = array(
				"beername" => $b['name'],
				"style" => $b['style'],
				"notes" => $b['notes'],
				"gravity" => $b['gravity'],
				"srm" => $b['srm'],
				"balance" => $b['balance'],
				"ibu" => $b['ibu'],
				"calories" => $b['calories'],
				"abv" => $b['abv'],
				"poured" => $b['poured'],
				"remaining" => $b['remaining'],
				"tapnumber" => $b['tapnumber'],
				"id" => $b['beerid']
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
		<title>Kegerface v0.5</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

		<!-- Set location of Cascading Style Sheet -->
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
<<<<<<< HEAD
	
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
=======

	<body>
    	<div class="bodywrapper">
        	<!-- Heade Bar with Logo and Date -->
            <div class="header clearfix">
                <div class="HeaderLeft">
                    <img src="img/cryptid.png" height="100" alt="">
                </div>
                <div class="HeaderCenter">
                    <h1 id="HeaderTitle">BEERS ON TAP</h1>
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
            <!-- End Header Bar -->
            <!-- Begin Title Bar -->	
            <div class="TitleBarWrapper clearfix">
                <div class="TitleBarSRM LeadEdge">
                	GRAVITY<hr>COLOR
                </div>
                <div class="TitleBarIBU">
                	BALANCE<hr>BITTERNESS
                </div>
                <div class="TitleBarBeerName">
                	BEER NAME &nbsp; / &nbsp; STYLE<hr>TASTING NOTES
                </div>
                <div class="TitleBarABV">
              		CALORIES<hr>ALCOHOL
                </div>
                <div class="TitleBarKeg TailEdge">
                	POURED<hr>REMAINING
                </div>
            </div>
            <!-- End Title Bar -->
            <!-- List the Beers -->
             <?php
				for($i = 0; $i < count($beers); $i++)
				{
			?>
			<div class="BeerWrapper clearfix <?php if($i%2 > 0){ echo 'altrow'; }?>" id="<?php echo $beers[$i]['id']; ?>">
				<div class="SRMcolumn  clearfix">
                    <h3><?php echo $beers[$i]['gravity']; ?> OG</h3>
                        <?php
                        if ($beers[$i]['srm'] > 30)
                            echo "<img src=\"img/srm/", "offthechart", ".png\" height=\"100\"  alt=\"\">";
                        else
                            echo "<img src=\"img/srm/", $beers[$i]['srm'], ".png\" height=\"100\"  alt=\"\">";
                        ?>
                        <h2><?php echo $beers[$i]['srm']; ?> SRM</h2>
                </div>
                <div class="IBUcolumn  clearfix">
                    <h3><?php echo $beers[$i]['balance']; ?> BU:GU</h3>
                        <?php
                        if ($beers[$i]['ibu'] > 100)
                            echo "<img src=\"img/ibu/", "offthechart", ".png\" height=\"100\" alt=\"\"><br>";
                        else
                            echo "<img src=\"img/ibu/", $beers[$i]['ibu'], ".png\" height=\"100\" alt=\"\"><br>";
                        ?>
                        <h2><?php echo $beers[$i]['ibu']; ?> IBU</h2>
                </div>
                <div class="BeerNameColumn clearfix">
                	<div class="Details">
                        <h1>
                            <?php echo $beers[$i]['beername']; ?>
                        </h1>
                        <h2 class="subhead">
                            <?php echo $beers[$i]['style']; ?>
                        </h2>
                        <p>
                        	<?php echo $beers[$i]['notes']; ?>
                        </p>
                    </div>
                </div>
                <div class="ABVcolumn">
                    <h3><?php echo $beers[$i]['calories']; ?> kCal</h3>
                        <?php
                        if ($beers[$i]['abv'] > 10)
                            echo '<img src="img/abv/offthechart.png" height="100" alt=""><br>';
                        else
                            echo '<img src="img/abv/'.(round(($beers[$i]['abv']), -1, PHP_ROUND_HALF_UP)/2).'.png" height="100" alt=""><br>';
                        ?>
                        <h2><?php echo $beers[$i]['abv']."%"; ?> ABV</h2>
                </div>
                <div class="KegColumn">
                    <h3>
						<?php echo $beers[$i]['poured']; ?> poured
                    </h3>
                        <?php
                        if ($beers[$i]['poured'] < 0)
                            echo "<img src=\"img/keg/0.png\" height=\"100\" alt=\"\"><br>";
                        elseif ($beers[$i]['poured'] > 100)
                            echo "<img src=\"img/keg/100.png\" height=\"100\" alt=\"\"><br>";
                        else
                            echo "<img src=\"img/keg/", (round(($beers[$i]['poured']), -1, PHP_ROUND_HALF_UP)), ".png\" height=\"100\" alt=\"\"><br>";
                        ?>
                        <h2><?php echo $beers[$i]['remaining']; ?> left</h2>
                </div>
          	</div>
			<?php
            }
            ?>
       </div>
>>>>>>> CSS, SQL Change
	</body>
</html>
