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

	<body>
    	<div class="bodywrapper">
        	<!-- Heade Bar with Logo and Date -->
            <div class="header clearfix">
                <div class="HeaderLeft">
                   <a href="admin"><img src="img/cryptid.png" height="100" alt=""></a>
                </div>
                <div class="HeaderCenter">
                    <h1 id="HeaderTitle">BEERS ON TAP</h1>
                </div>
                <div class="HeaderRight">
                    <?php echo date('F jS Y'); ?><br />
					<?php echo date("g:i a"); ?>
					
                    <!--
                    <?php
                        $date=getdate(date("U"));
                        print("$date[month] <br> $date[mday], $date[year]");
                    ?>
                    -->
                </div>
            </div>
            <!-- End Header Bar -->
			
			<table>
				<thead>
					<tr>
						<th>
							Tap #
						</th>
						<th>
							GRAVITY<hr>COLOR
						</th>
						<th>
							BALANCE<hr>BITTERNESS
						</th>
						<th>
							BEER NAME &nbsp; / &nbsp; STYLE<hr>TASTING NOTES
						</th>
						<th>				
							CALORIES<hr>ALCOHOL
						</th>
						<th>
							POURED<hr>REMAINING
						</th>
					</tr>
                </thead>
				<tbody>
					<?php for($i = 0; $i < count($beers); $i++) { ?>
						<tr class="<?php if($i%2 > 0){ echo 'altrow'; }?>" id="<?php echo $beers[$i]['id']; ?>">
							<td class="tap-num">
								<span class="tapcircle"><?php echo $beers[$i]['tapnumber']; ?></span>
				            </td>
							<td class="srm">
								<h3><?php echo $beers[$i]['gravity']; ?> OG</h3>
								<?php
								if ($beers[$i]['srm'] > 30)
									echo "<img src=\"img/srm/", "offthechart", ".png\" height=\"100\"  alt=\"\">";
								else
									echo "<img src=\"img/srm/", $beers[$i]['srm'], ".png\" height=\"100\"  alt=\"\">";
								?>
								<h2><?php echo $beers[$i]['srm']; ?> SRM</h2>
							</td>
							<td class="ibu">
								<h3><?php echo $beers[$i]['balance']; ?> BU:GU</h3>					
								<div class="ibu-container">
									<?php
										$numHops = 0;
										$remaining = $beers[$i]['ibu'];
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
								<h2><?php echo $beers[$i]['ibu']; ?> IBU</h2>
							</td>
							<td class="name">
								<h1><?php echo $beers[$i]['beername']; ?></h1>
								<h2 class="subhead"><?php echo $beers[$i]['style']; ?></h2>
								<p><?php echo $beers[$i]['notes']; ?></p>
							</td>
							<td class="abv">
								<h3><?php echo $beers[$i]['calories']; ?> kCal</h3>
								<div class="abv-container">
									<?php
										$numCups = 0;
										$remaining = round(($beers[$i]['abv']*20*2), -1, PHP_ROUND_HALF_UP)/2;
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
								<h2><?php echo $beers[$i]['abv']."%"; ?> ABV</h2>
							</td>
							<td class="keg">
								<h3><?php echo $beers[$i]['poured']; ?> poured</h3>
								<?php 
									$total = $beers[$i]['poured'] + $beers[$i]['remaining'];
									if( $total > 0 ){
										$percentRemaining = $beers[$i]['remaining'] / $total * 100;
									}else{
										$percentRemaining = 0;
									}
									$kegImgClass = "";
									if( $percentRemaining < 15 )
										$kegImgClass = "keg-red";
									else if( $percentRemaining < 25 )
										$kegImgClass = "keg-orange";
									else if( $percentRemaining < 45 )
										$kegImgClass = "keg-yellow";
									else
										$kegImgClass = "keg-green"
								?>
								<div class="keg-indicator"><div class="keg-full <?php echo $kegImgClass ?>" style="height:<?php echo $percentRemaining; ?>%"></div></div>
								
								<h2><?php echo $beers[$i]['remaining']; ?> left</h2>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</body>
</html>