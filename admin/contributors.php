<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
header("location:index.php");
}

require 'includes/conn.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>RaspberryPints</title>
<link href="styles/layout.css" rel="stylesheet" type="text/css" />
<link href="styles/wysiwyg.css" rel="stylesheet" type="text/css" />
<!-- Theme Start -->
<link href="styles.css" rel="stylesheet" type="text/css" />
<!-- Theme End -->
<link href='http://fonts.googleapis.com/css?family=Fredoka+One' rel='stylesheet' type='text/css'>
</head>
	<!-- Start Header  -->
<?php
include 'header.php';
?>
	<!-- End Header -->
		
	<!-- Top Breadcrumb Start -->
	<div id="breadcrumb">
		<ul>	
			<li><img src="img/icons/icon_breadcrumb.png" alt="Location" /></li>
			<li><strong>Location:</strong></li>
			<li class="current">Contributors</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End --> 
	
	<!-- Right Side/Main Content Start -->
	<div id="rightside">


		<div class="contentcontainer med left" style="width:900px">
			<div class="headings alt">
				<h2>Contributors</h2>
			</div>
			<br><br>
			<h3>Project Staffers:</h3><br>
			<div class="contentbox">
				<table style="width: 800px;">
					<thead>
						<tr style="color: #000000;">
							<td style="width: 25%;"><b><u>Name</u></b></td>
							<td style="width: 25%;"><b><u>Role</u></b></td>
							<td style="width: 25%;"><b><u>HBT Username</u></b></td>
							<td style="width: 25%;"><b><u>Untappd Username</u></b></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><b>Thadius D. Miller</b></td>
							<td>Project Manager</td>
							<td><a href="http://www.homebrewtalk.com/members/thadius856" target="_blank">thadius856</a></td>
							<td><a href="https://untappd.com/user/thadius856" target="_blank">thadius856</a></td>
						</tr>
						<tr>
							<td><b>Jason S. Unterman</b></td>
							<td>Application Developer</td>
							<td><a href="http://www.homebrewtalk.com/members/jayunt" target="_blank">JayUnt</a></td>
							<td><a href="https://untappd.com/user/jayunt" target="_blank">Jayunt</a></td>
						</tr>
						<tr>
							<td><b>Shawn M. Kemp</b></td>
							<td>Application Developer</td>
							<td><a href="http://www.homebrewtalk.com/members/skemp45" target="_blank">Skemp45</a></td>
							<td><a href="https://untappd.com/user/Shawnkemp" target="_blank">Shawn Kemp</a></td>
						</tr>
						<tr>
							<td><b>Seven Johnson</b></td>
							<td>Application Developer</td>
							<td><a href="http://www.homebrewtalk.com/members/Seven" target="_blank">Seven</a></td>
							<td><a href="https://untappd.com/user/SevenXXX" target="_blank">SevenXXX</a></td>
						</tr>						
					</tbody>
				</table>
			</div>
			<br><br>
			<h3>Special Thanks To:</h3>
			<div class="contentbox">
				<table style="width: 800px;">
					<thead>
						<tr style="color: #000000;">
							<td style="width: 25%;"><b><u>GH Username</u></b></td>
							<td style="width: 25%;"><b><u>HBT Username</u></b></td>
							<td style="width: 75%;"><b><u>Contribution</u></b></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><b><a href="https://github.com/thesehands" target="_blank">thesehands</a></b></td>
							<td><a href="http://www.homebrewtalk.com/members/unknown" target="_blank">?unknown?</a></td>
							<td>
								· Built initial SQL schema<br>
								· Converted initial CSV file to SQL database (now test_data.sql)<br>
								· Rewrote front end to poll SQL database
							</td>
						</tr>
						<tr>
							<td><b><a href="https://github.com/mtnbound" target="_blank">mtnbound</a></b></td>
							<td><a href="http://www.homebrewtalk.com/members/sloescher)" target="_blank">sloescher</a></td>
							<td>
								· Wrote installation wizard (install/install.php)<br>
								· Helped write installation instructions (on official website)
							</td>
						</tr>
						<tr>
							<td><b><a href="https://github.com/raysmithtx" target="_blank">raysmithtx</a></b></td>
							<td><a href="http://www.homebrewtalk.com/members/raysmithtx" target="_blank">raysmithtx</a></td>
							<td>
								· Added PDF/print functionality (to official website)<br>
								· Spruced up official website front page
							</td>
						</tr>
					</tbody>
				</table>
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
