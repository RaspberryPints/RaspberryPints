<!-- Left Dark Bar Start -->
<div id="leftside">

<!-- Start User Echo -->
<div id="welcome"> &nbsp; Welcome, <br />
	&nbsp;
	<?php
		$sql="SELECT `name` FROM `users` WHERE username='$_SESSION[myusername]'";
		$result=mysql_query($sql);
		echo mysql_result($result, 0, 'name');
	?>
</div>

<!-- End User Echo -->
<div class="user">
	<a href="../"><img src="img/logo.png" width="120" height="120" class="hoverimg" alt="Avatar" /></a>
</div>

<!-- Start Navagation -->
<ul id="nav">
	<li>
		<ul class="navigation">
			<li class="heading selected">Welcome</li>
		</ul>
	<li>
	<li>
		<a class="expanded heading">Basic Setup</a>
		<ul class="navigation">
			<li><a href="beer_main.php" title="beer-list">Beer Recipes</a></li>
			<li><a href="#" title="keg-detail">Kegs Details <small>(coming soon)</small></a></li>
			<li><a href="tap_list.php" title="tap-list">Edit Taplist</a></li>
		</ul>
	</li>
		<li>
		<a class="expanded heading">Personalization</a>
		<ul class="navigation">
			<li><a href="personalize.php#columns" title="personalize">Show/Hide Columns</a></li>
			<li><a href="personalize.php#header" title="personalize">Headers</a></li>
			<li><a href="personalize.php#logo" title="personalize">Brewery Logo</a></li>
			<li><a href="personalize.php#background" title="personalize">Background Image</a></li>
			<li><a href="#" title="theme">Themes <small>(coming v3.0.0)</small></a></li>
			<li><a href="#" title="drinker-acct">Drinker Accounts <small>(coming v2.0.0)</small></a></li>
			<li><a href="#" title="personalize">Units of Measure <small>(coming v3.0.0)</small></a></li>
		</ul>
	</li>
	<li>
		<a class="collapsed heading">Advanced Hardware</a>
		<ul class="navigation">
			<li><a href="#" title="gpio-pin-layout">GPIO Pin Layout<small>(coming v2.0.0)</small></a></li>
			<li><a href="#" title="flow-calibration">Flow Meters <small>(coming v2.0.0)</small></a></li>
			<li><a href="#" title="rfid-reader">RFID Readers <small>(coming v2.0.0)</small></a></li>
			<li><a href="#" title="temp-probe">Temperature Probes <small>(coming v3.0.0)</small></a></li>
			<li><a href="#" title="solenoid">Solenoids <small>(coming v3.0.0)</small></a></li>
			<li><a href="#" title="motion-sensor">Motion Sensors <small>(coming v3.0.0)</small></a></li>
		</ul>
	</li>
	<li>
		<a class="collapsed heading">Analytics</a>
		<ul class="navigation">
			<li><a href="#" title="temperature-vs-time">Temperature vs Time <small>(coming v2.0.0)</small></a></li>
			<li><a href="#" title="pour-history">Pour history <small>(coming v2.0.0)</small></a></li>
			<li><a href="#" title="tap-history">Tap history <small>(coming v2.0.0)</small></a></li>
			<li><a href="#" title="rank">Beer statistics <small>(coming v2.0.0)</small></a></li>
			<li><a href="#" title="drinker-stats">Drinker statistics <small>(coming v2.0.0)</small></a></li>
			<li><a href="#" title="GPT">Tap statistics <small>(coming v2.0.0+)</small></a></li>
		</ul>
	</li>
	<li>
		<a class="expanded heading">Help</a>
		<ul class="navigation">
			<li><a href="#" title="faq">F.A.Q. <small>(coming soon)</small></a></li>
			<li><a href="report_bug.php" title="faq">Report a Bug</a></li>
			<li><a href="feedback.php" title="faq">Request a Feature</a></li>
		</ul>	
	</li>
	<li>
		<a class="expanded heading">Everything Else</a>
		<ul class="navigation">
			<li><a href="http://www.raspberrypints.com/" title="faq">Official Website <small>(coming soon)</small></a></li>
			<li><a href="#" title="about">About <small>(coming soon)</small></a></li>
			<li><a href="contributors.php" title="contributors">Contributors</a></li>
			<li><a href="#" title="licensing">Licensing <small>(coming soon)</small></a></li>
		</ul>
	</li>
</ul>

<!-- End Navagation -->
<!-- Left Dark Bar End --> 
