<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
header("location:index.php");
}

require 'includes/conn.php';
require '../includes/config_names.php';
require 'includes/configp.php';

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
		<li class="current">Configure Settings</li>
	</ul>
</div>
<!-- Top Breadcrumb End -->

<!-- Right Side/Main Content Start -->
<div id="rightside">
	<div class="contentcontainer lg left">
		<div class="headings alt">
			<h2>Personalize </h2>
		</div>
		<div class="contentbox">
		<a name="columns"></a> 
		<h2>Show/Hide Columns</h2><br /> 
		<form method="post" action="update_column.php">
			<?php
				foreach($result as $row) {
				echo '<h3>' . $row['displayName'] . ":" . '</h3>' . 
					'On<input type="radio" ' . ($row['configValue']?'checked':'') . ' name="' . str_replace(' ','',$row['id']) . '" value="1">' .
					'Off<input type="radio" ' . (!$row['configValue']?'checked':'') . ' name="' . str_replace(' ','',$row['id']) . '" value="0"><br>' .
					'<br>';
			} ?>
			<input type="submit" class="btn" value="Save" />
		</form>

		<hr />

	<a name="header"></a> 
		<h2>Taplist Header</h2><br><br>
		<?php
			$sql="SELECT configValue FROM config WHERE configName ='".ConfigNames::HeaderText."'";
			$result=mysql_query($sql);
			$headerText=mysql_fetch_array($result);
		?>
		<p><b>Text to Display:</b></p>
			<form method="post" action="update_header_text.php">
				<input type="text" class="largebox" value="<?php echo $headerText['configValue']; ?>" name="header_text"> &nbsp 
				<input type="submit" class="btn" name="Submit" value="Submit">
			</form><br><br>
		<?php
			$sql="SELECT configValue FROM config WHERE configName ='".ConfigNames::HeaderTextTruncLen."'";
			$result=mysql_query($sql);
			$headerTextTruncLen=mysql_fetch_array($result);
		?>
		<p><b>Truncate To:</b> (# characters)</p>
			<form method="post" action="update_header_text_trunclen.php">
				<input type="text" class="smallbox" value="<?php echo $headerTextTruncLen['configValue']; ?>" name="header_text_trunclen"> &nbsp 
				<input type="submit" class="btn" name="Submit" value="Submit">
			</form>
			<hr />
		<a name="untappd"></a>
			<h2>Untappd Settings</h2>
		<?php
			$sql="SELECT configValue FROM config WHERE configName ='".ConfigNames::ClientID."'";
			$result=mysql_query($sql);
			$Client_ID=mysql_fetch_array($result);
		?>
		<p><b>Untappd ClientID:</b> </p>
			<form method="post" action="update_clientid.php">
				<input type="text" class="largebox" value="<?php echo $Client_ID['configValue']; ?>" name="ClientID"> &nbsp 
				<input type="submit" class="btn" name="Submit" value="Submit">
			</form>
			<?php
			$sql="SELECT configValue FROM config WHERE configName ='".ConfigNames::ClientSecret."'";
			$result=mysql_query($sql);
			$Client_Secret=mysql_fetch_array($result);
		?>
		<p><b>Untappd Client Secret:</b> </p>
			<form method="post" action="update_clientsecret.php">
				<input type="text" class="largebox" value="<?php echo $Client_Secret['configValue']; ?>" name="ClientSecret"> &nbsp 
				<input type="submit" class="btn" name="Submit" value="Submit">
			</form>
			<?php
			$sql="SELECT configValue FROM config WHERE configName ='".ConfigNames::BreweryID."'";
			$result=mysql_query($sql);
			$BreweryID=mysql_fetch_array($result);
		?>
		<p><b>Untappd Brewery ID:</b> </p>
			<form method="post" action="update_breweryid.php">
				<input type="text" class="largebox" value="<?php echo $BreweryID['configValue']; ?>" name="BreweryID"> &nbsp 
				<input type="submit" class="btn" name="Submit" value="Submit">
			</form>
		<hr />
	<a name="logo"></a> 
		<h2>Taplist Logo</h2>
		<p>This logo appears on the taplist.</p>
			<b>Current image:</b><br /><br />
				<img src="../img/logo.png<?php echo "?" . time(); ?>" height="100" alt="Brewery Logo" style="border-style: solid; border-width: 2px; border-color: #d6264f;" />
			<form enctype="multipart/form-data" action="update_logo.php" method="POST"><br />
				<input name="uploaded" type="file" accept="image/gif, image/jpg, image/png"/>
				<input type="submit" class="btn" value="Upload" />
			</form> 
			<hr />
	<a name="logo"></a> 
		<h2>Admin Logo</h2>
		<p>This logo appears on the admin panel.</p>
			<b>Current image:</b><br /><br />
				<img src="img/logo.png<?php echo "?" . time(); ?>" height="100" alt="Brewery Logo" style="border-style: solid; border-width: 2px; border-color: #d6264f;" />
			<form enctype="multipart/form-data" action="updateAdminLogo.php" method="POST"><br />
				<input name="uploaded" type="file" accept="image/gif, image/jpg, image/png"/>
				<input type="submit" class="btn" value="Upload" />
			</form> 

		<hr />
	<a name="background"></a> 
		<h2>Background Image</h2>
		<p>This background appears on the taplist.</p>
			<b>Current image:</b><br /><br />
				<img src="../img/background.jpg<?php echo "?" . time(); ?>" width="200" alt="Background" style="border-style: solid; border-width: 2px; border-color: #d6264f;" />
			<form enctype="multipart/form-data" action="update_background.php" method="POST">
				<input name="uploaded" type="file" accept="image/gif, image/jpg, image/png"/>
				<input type="submit" class="btn" value="Upload" /><br /><br />
			</form>
			<form action="restore_background.php" method="POST">
				<input type="submit" class="btn" value="Restore Default Background" />
			</form> 

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
