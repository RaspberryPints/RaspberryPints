<?php
require_once __DIR__.'/header.php';
if (isset ( $_POST ['reboot'] )) {
	//echo ("rebooting system: ");	
    triggerPythonAction("restart");
}
if (isset ( $_POST ['shutdown'] )) {
	//echo ("shutting down system");	
    triggerPythonAction("shutdown");
}
if (isset ( $_POST ['restartservice'] )) {
	//echo ("restarting flowmon service: ");	
    triggerPythonAction("restartservice");
}
?>
<body id="homepage">
	<!-- Start Header  -->
<?php
include 'top_menu.php';
?>
	<!-- End Header -->
		
	<!-- Top Breadcrumb Start -->
	<div id="breadcrumb">
		<ul>	
			<li><img src="img/icons/icon_breadcrumb.png" alt="Location" /></li>
			<li><strong>Location:</strong></li>
			<li class="current">Control Panel</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End -->
	
	<!-- Right Side/Main Content Start -->
	<div id="rightside">
	<h1>Welcome To The RaspberryPints Management Portal</h1>
	<p> Feel free to explore around and see what all we provide through your admin. Here in the admin you will be able <br/>to do a list of useful things, which include
	Adding and the removal of beer along with checking the stats on the<br/> activity of your tap.</p>
		
				<br/>
				<br/>
			<?php $config = getAllConfigs(); if( $config[ConfigNames::UseFlowMeter] ){ ?>
			<form method="POST">
				<table style="width:300;border:0;cellspacing:1;cellpadding:0;">
					<thead>
						<tr>
							<th colspan="99"><b>Reboot / Shutdown:</b></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><input type="submit" name="reboot" class="btn"
								value="Reboot System" onclick="return confirm('Are you sure you want to Restart the system?')"/></td>
							<td><input type="submit" name="shutdown" class="btn"
								value="Shut System Down" onclick="return confirm('Are you sure you want to Shutdown the system?')"/></td>
							<td><input type="submit" name="restartservice" class="btn"
								value="Restart Flowmeter Service" onclick="return confirm('Are you sure you want to Restart the Service?')"/></td>
						</tr>
					</tbody>
				</table>
			</form>
			<?php }?>

	<!-- Start Footer -->   
<?php 
include 'footer.php';
?>

	<!-- End Footer -->
		</div>
<!-- Right Side/Main Content End -->
	
	
	<!-- Start Left Bar Menu -->   
<?php
include 'left_bar.php';
?>
	<!-- End Left Bar Menu -->  
	<!-- Start Js  -->
<?php
include 'scripts.php';
?>
	<!-- End Js -->
	<!--[if IE 6]>
	<script type='text/javascript' src='scripts/png_fix.js'></script>
	<script type='text/javascript'>
	DD_belatedPNG.fix('img, .notifycount, .selected');
	</script>
	<![endif]--> 
</body>
</html>
