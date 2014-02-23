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
	<a href="../index.php"><img src="img/logo.png" width="120" height="120" class="hoverimg" alt="Avatar" /></a>
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
			<li><a href="beer_list.php">My Beers</a></li>
			<li><a href="keg_list.php">My Kegs</a></li>
			<li><a href="tap_list.php">My Taps</a></li>
		</ul>
	</li>
		<li>
		<a class="expanded heading">Personalization</a>
		<ul class="navigation">
			<li><a href="personalize.php#columns">Show/Hide Columns</a></li>
			<li><a href="personalize.php#header">Headers</a></li>
			<li><a href="personalize.php#logo">Brewery Logo</a></li>
			<li><a href="personalize.php#background">Background Image</a></li>
		</ul>
	</li>
	<li>
		<a class="expanded heading">Help!</a>
		<ul class="navigation">
			<li><a href="http://raspberrypints.com/report-bug-make-a-suggestion/" target="_blank">Report a Bug</a></li>
			<li><a href="http://raspberrypints.com/report-bug-make-a-suggestion/" target="_blank">Request a Feature</a></li>
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

<!-- End Navagation -->
<!-- Left Dark Bar End --> 
