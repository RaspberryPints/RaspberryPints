<?php
require_once __DIR__.'/header.php';
?>
	<!-- Start Header  -->
<?php
include 'top_menu.php';

$sql="SELECT * FROM `users` WHERE id='$_SESSION[myuserid]'";
/** @var mixed $mysqli */
$result = $mysqli->query($sql);
if($result) $user = $result->fetch_array();
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
			<form method="POST" id="user-form" action="user_form.php">
				<table style="width:800px" id="tableList">
					<tr>
						<td style="width:80px">User Name:</td>
						<td><?php  echo $user?$user['username']:$_SESSION['myusername'];?></td>
					</tr>
					<tr>
						<td>Name:</td>
						<td><?php if($user && isset($user['name'])) echo $user['name'];?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?php if($user) echo $user['email'];?></td>
					</tr>
					
					<tr>
					<?php if($user){?>
						<td style="text-align: left; vertical-align: middle; margin: 0; padding: 0; padding-right:5px" colspan="2">
							<input type="hidden" name="id" value="<?php echo $user["id"]?>">
							<input class="btn" style="text-align: center; margin: 0;" name="changeToken" type="submit" value="Change Password" onClick="window.location='user_form.php'" />
						</td>
					<?php }?>
					</tr>
				</table>
			</form>
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
