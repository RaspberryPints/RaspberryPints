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
			<div class="TitleBarTap LeadEdge">
		         Tap &nbsp; <hr># &nbsp;
		        </div>
                <div class="TitleBarSRM">
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
			<div class="TapColumn clearfix">
                <div class="TapNum">
                     <?php echo $beers[$i]['tapnumber']; ?>
			    </div>
			</div>
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
	</body>
</html>
