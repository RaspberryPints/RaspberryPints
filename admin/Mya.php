<?php
require_once __DIR__.'/header.php';
?>
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
			<li class="current">My Account</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End --> 
	
	<!-- Right Side/Main Content Start -->
	<div id="rightside">

	
		<div class="contentcontainer med left">
			<div class="headings alt">
				<h2>Account Info</h2>
			</div>
			<div class="contentbox">
			<p style="padding:0px;margin:0px">
<font size="2" Color="Black" font-family="Impact">Name:</font>
<?php

$sql="SELECT `name` FROM `users` WHERE username='$_SESSION[myusername]'";
$result=mysql_query($sql);

echo mysql_result($result, 0, 'name');
?><br />
<font size="2" Color="Black" font-family="Impact">Username:</font>
<?php

$sql="SELECT `username` FROM `users` WHERE username='$_SESSION[myusername]'";
$result=mysql_query($sql);

echo mysql_result($result, 0, 'username');

?><br />
<font size="2" Color="Black" font-family="Impact"> Email:</font>
<?php

$sql="SELECT `email` FROM `users` WHERE username='$_SESSION[myusername]'";
$result=mysql_query($sql);

echo mysql_result($result, 0, 'email');

?>
<br />
<br />

	</div>

	<!-- Start Footer -->   
<?php 
include 'footer.php';
?>

	<!-- End Footer -->
		</div>
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
