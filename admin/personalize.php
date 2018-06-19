<?php
require_once __DIR__.'/header.php';
$configs = getAllConfigs();
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
		<form method="post" action="includes/update_columnConfig.php">
			<?php
			    $result = getConfigurableConfigs();
				foreach($result as $row) {
				echo '<h3>' . $row['displayName'] . ":" . '</h3>' . 
					'On<input type="radio" ' . ($row['configValue']?'checked':'') . ' name="' . $row['configName'] . '" value="1">' .
					'Off<input type="radio" ' . (!$row['configValue']?'checked':'') . ' name="' . $row['configName'] . '" value="0"><br>' .
					'<br>';
			} ?>
			<input type="submit" class="btn" value="Save" />
		</form>

		<hr />

	<?php
		$headerText=$configs[ConfigNames::HeaderText];
		$headerTextTruncLen=$configs[ConfigNames::HeaderTextTruncLen];
		$Client_ID=$configs[ConfigNames::ClientID];
		$Client_Secret=$configs[ConfigNames::ClientSecret];
		$BreweryID=$configs[ConfigNames::BreweryID];
	?>
	<a name="header"></a> 
		<h2>Taplist Header</h2><br><br>
		<p><b>Text to Display:</b></p>
			<form method="post" action="includes/config_update.php">
				<input type="text" class="largebox" value="<?php echo $headerText; ?>" name="configValue"> &nbsp 
				<?php echo '<input type="hidden" name="configName" value="'.ConfigNames::HeaderText.'"/>'; ?>
				<?php echo '<input type="hidden" name="jumpto" value="#header"/>'; ?>
				<input type="submit" class="btn" name="Submit" value="Submit">
			</form><br><br>
		<p><b>Truncate To:</b> (# characters)</p>
			<form method="post" action="includes/config_update.php">
				<input type="text" class="smallbox" value="<?php echo $headerTextTruncLen; ?>" name="configValue"> &nbsp 
				<?php echo '<input type="hidden" name="configName" value="'.ConfigNames::HeaderTextTruncLen.'"/>'; ?>
				<?php echo '<input type="hidden" name="jumpto" value="#header"/>'; ?>
				<input type="submit" class="btn" name="Submit" value="Submit">
			</form>
			<hr />
		<a name="untappd"></a>
		<h2>Untappd Settings</h2>
		<p><b>Untappd ClientID:</b> </p>
		<form method="post" action="includes/config_update.php">
			<input type="text" class="largebox" value="<?php echo $Client_ID; ?>" name="configValue"> &nbsp 
				<?php echo '<input type="hidden" name="configName" value="'.ConfigNames::ClientID.'"/>'; ?>
				<?php echo '<input type="hidden" name="jumpto" value="#untappd"/>'; ?>
			<input type="submit" class="btn" name="Submit" value="Submit">
		</form>
		<p><b>Untappd Client Secret:</b> </p>
		<form method="post" action="includes/config_update.php">
			<input type="text" class="largebox" value="<?php echo $Client_Secret; ?>" name="configValue"> &nbsp 
				<?php echo '<input type="hidden" name="configName" value="'.ConfigNames::ClientSecret.'"/>'; ?>
				<?php echo '<input type="hidden" name="jumpto" value="#untappd"/>'; ?>
			<input type="submit" class="btn" name="Submit" value="Submit">
		</form>
		<p><b>Untappd Brewery ID:</b> </p>
			<form method="post" action="includes/config_update.php">
				<input type="text" class="largebox" value="<?php echo $BreweryID; ?>" name="configValue"> &nbsp 
				<?php echo '<input type="hidden" name="configName" value="'.ConfigNames::BreweryID.'"/>'; ?>
				<?php echo '<input type="hidden" name="jumpto" value="#untappd"/>'; ?>
				<input type="submit" class="btn" name="Submit" value="Submit">
			</form>
		<hr />
	<a name="tapListLogo"></a> 
		<h2>Taplist Logo</h2>
		<p>This logo appears on the taplist.</p>
			<b>Current image:</b><br /><br />
			<img src="../img/logo.png<?php echo "?" . time(); ?>" height="100" alt="Brewery Logo" style="border-style: solid; border-width: 2px; border-color: #d6264f;" />
			<form enctype="multipart/form-data" action="includes/upload_image.php" method="POST"><br />
				<input name="uploaded" type="file" accept="image/gif, image/jpg, image/png"/>
				<?php echo '<input type="hidden" name="target" value="../../img/logo.png"/>'; ?>
				<?php echo '<input type="hidden" name="jumpto" value="#untappd"/>'; ?>
				<?php echo '<input type="hidden" name="jumpto" value="#tapListLogo"/>'; ?>
				<input type="submit" class="btn" value="Upload" />
			</form> 
			<hr />
	<a name="adminLogo"></a> 
		<h2>Admin Logo</h2>
		<p>This logo appears on the admin panel.</p>
			<b>Current image:</b><br /><br />
			<img src="img/logo.png<?php echo "?" . time(); ?>" height="100" alt="Brewery Logo" style="border-style: solid; border-width: 2px; border-color: #d6264f;" />
			<form enctype="multipart/form-data" action="includes/upload_image.php" method="POST"><br />
				<input name="uploaded" type="file" accept="image/gif, image/jpg, image/png"/>
				<?php echo '<input type="hidden" name="target" value="../img/logo.png"/>'; ?>
				<?php echo '<input type="hidden" name="jumpto" value="#adminLogo"/>'; ?>
				<input type="submit" class="btn" value="Upload" />
			</form> 

		<hr />
	<a name="tapListBackground"></a> 
		<h2>Background Image</h2>
		<p>This background appears on the taplist.</p>
			<b>Current image:</b><br /><br />
				<img src="../img/background.jpg<?php echo "?" . time(); ?>" width="200" alt="Background" style="border-style: solid; border-width: 2px; border-color: #d6264f;" />
			<form enctype="multipart/form-data" action="includes/upload_image.php" method="POST">
				<input name="uploaded" type="file" accept="image/gif, image/jpg, image/png"/>
				<?php echo '<input type="hidden" name="target" value="../../img/background.jpg"/>'; ?>
				<?php echo '<input type="hidden" name="jumpto" value="#tapListBackground"/>'; ?>
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
