<!-- Left Dark Bar Start -->
<div id="leftside">

<!-- Start User Echo -->
<div id="welcome"> &nbsp; Logged in as: <br />
	&nbsp;
	<?php
	if(isset($_SESSION['myusername']) )echo $_SESSION['myusername'];
	?>
</div>

<!-- End User Echo -->
<div class="user">
	<a href="../index.php"><img src="img/logo.png<?php echo "?" . time(); ?>" width="120" height="120" class="hoverimg" alt="Brewery Logo" /></a>
</div>

<!-- Start Navagation -->
<ul id="nav">
	<li>
		<ul class="navigation">
			<li class="heading selected">Welcome</li>
		</ul>
	</li>
	<li>
		<a class="expanded heading">Basic Setup</a>
		<ul class="navigation">
			<li><a href="beer_list.php">Beers</a></li>
			<li><a href="keg_list.php">Kegs</a></li>
			<li><a href="tap_list.php">Taps</a></li>
			<li><a href="brewery_list.php">Breweries</a></li>
			<li><a href="bottle_list.php">Bottles</a></li>
			<li><a href="user_list.php" title="drinker-acct">Drinker Accounts</a></li>
		</ul>
	</li>
	<li>
		<a class="expanded heading">Ingredients</a>
		<ul class="navigation">
			<li><a href="hops_list.php">Hops</a></li>
			<li><a href="fermentables_list.php">Fermentables</a></li>
			<li><a href="yeasts_list.php">Yeasts</a></li>
			<li><a href="accolades_list.php">Accolades</a></li>
		</ul>
	</li>
    <li>
		<a class="expanded heading">Personalization</a>
		<ul class="navigation">
			<li><a href="personalize.php#columns">Configuration</a></li>
			<li><a href="personalize.php#header">Headers</a></li>
			<li><a href="personalize.php#tapListLogo">Brewery Logo</a></li>
			<li><a href="personalize.php#tapListBackground">Background Image</a></li>
			<li><a href="personalize.php#weightCalculation">Brewery Defaults</a></li>
			<li><a href="themes.php">Theme Options</a></li>
			<li><a href="units_of_measure.php" title="personalize">Units of Measure</a></li>
			<li><a href="customize_tap_display.php" title="personalize">Customize Tap Display</a></li>
		</ul>
	</li>
	<li>
		<a class="collapsed heading">Advanced Hardware</a>
		<ul class="navigation">
			<li><a href="rfid_reader_list.php" title="rfid-reader">RFID Readers</a></li>
			<li><a href="temp_probe_list.php" title="temp-probe">Temperature Probes</a></li>
			<li><a href="load_cell_list.php" title="loadCells">Load Cells</a></li>
<!-- 			<li><a href="valve_list.php" title="valves">Valves</a></li> -->
			<li><a href="motion_detector_list.php" title="motion-detectors">Motion Detectors</a></li>
			<li><a href="ioPins_list.php" title="io_pins">Hardware IO Display</a></li>
		</ul>
	</li>
	<li>
		<a class="collapsed heading">Analytics</a>
		<ul class="navigation">
			<li><a href="temp_log.php" title="temperature-vs-time">Temperature history</a></li>
			<li><a href="pour_list.php" title="pour-history">Pour history</a></li>
			<li><a href="stats_beer.php" title="rank">Beer statistics</a></li>
			<li><a href="stats_drinker.php" title="drinker-stats">Drinker statistics</a></li>
			<li><a href="stats_tap.php" title="GPT">Tap statistics</a></li>
			<li><a href="stats_tapHistory.php" title="tap-history">Tap history</a></li>
		</ul>
	</li>
	<?php if(isset($_SESSION['showadmin']) && $_SESSION['showadmin']){?>
    	<li>
    		<a class="expanded heading">Install</a>
    		<ul class="navigation">
    			<li><a href="manage_install.php" title="install">Install Page</a></li>
    			<li><a href="rpints_log.php" title="install">Log</a></li>
    		</ul>	
    	</li>
	<?php }?>
	<li>
		<a class="expanded heading">Help!</a>
		<ul class="navigation">
			<li><a href="http://raspberrypints.com/report-bug/" target="_blank">Report a Bug</a></li>
			<li><a href="http://raspberrypints.com/request-feature/" target="_blank">Suggest a Feature</a></li>
		</ul>	
	</li>
	<li>
		<a class="expanded heading">External Links</a>
		<ul class="navigation">
			<li><a href="http://www.raspberrypints.com/" target="_blank">Official Website</a></li>
			<li><a href="http://www.raspberrypints.com/faq" target="_blank">F.A.Q.</a></li>
			<li><a href="http://www.homebrewtalk.com/f51/initial-release-raspberrypints-digital-taplist-solution-456809" target="_blank">Visit Us on HBT</a></li>
			<li><a href="http://www.raspberrypints.com/contributors" target="_blank">Contributors</a></li>
			<li><a href="http://www.raspberrypints.com/licensing" target="_blank">Licensing</a></li>
		</ul>
	</li>
</ul>

<div>
	<?php
		require_once 'includes/managers/config_manager.php';
		echo "&nbsp;&nbsp;" . getConfigValue(ConfigNames::Version);
	?>
</div>

<!-- End Navagation -->
</div>
<!-- Left Dark Bar End --> 
