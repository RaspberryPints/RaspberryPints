<?php
require_once __DIR__.'/header.php';
?>
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
			<li class="current">Thank_You</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End -->
	
	<!-- Right Side/Main Content Start -->
	<div id="rightside">

	
		<div class="contentcontainer med left">
			<div class="headings alt">
				<h2>We Received Your Email</h2>
			</div>
			<div class="contentbox">
			<p>
Thank you for your assistance in making Raspberry pints a better tool!
			</div>
		</div>
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
require_once 'scripts.php';
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
