<?php
require_once __DIR__.'/header.php';
?>
<body id="homepage">
<!-- Start Header -->
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
	<p><h1>Welcome To The RaspberryPints Management Portal</h1></p>
	<p> Feel free to explore around and see what all we provide through your admin. Here in the admin you will be able <br/>to do a list of useful things, which include
	Adding and the removal of beer along with checking the stats on the<br/> activity of your tap.</p>
		
				<br/>
				<br/>
				<br/>
				<br/>

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
