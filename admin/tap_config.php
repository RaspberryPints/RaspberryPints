<?php
session_start();
if(!isset( $_SESSION['myusername'] )){
	header("location:index.php");
}

require_once __DIR__.'/includes/conn.php';
require_once __DIR__.'/includes/functions.php';
require_once __DIR__.'/includes/html_helper.php';

require_once __DIR__.'/includes/models/tap.php';
require_once __DIR__.'/includes/models/beer.php';
require_once __DIR__.'/includes/models/keg.php';

require_once __DIR__.'/includes/managers/beer_manager.php';
require_once __DIR__.'/includes/managers/keg_manager.php';
require_once __DIR__.'/includes/managers/tap_manager.php';


$htmlHelper = new HtmlHelper();
$tapManager = new TapManager();

if( isset($_POST['updateNumberOfTaps'])) {
	$tapManager->updateTapNumber($_POST['numberOfTaps']);

}else if( isset($_POST['saveTapConfig'])){
	$tapNumber=$_POST['tapNumber'];
	$flowpin=$_POST['flowpin'];
	$valvepin=$_POST['valvepin'];
	$valveon=$_POST['valveon'];
	$tapManager->saveTapConfig($tapNumber, $flowpin, $valvepin, $valveon);
	file_get_contents('http://' . $_SERVER['SERVER_NAME'] . '/admin/trigger.php?value=valve');
	
}else if( isset($_POST['fanConfig'])){
	$useFanPin=$_POST['useFanPin'];
	$fanInterval=$_POST['fanInterval'];
	$fanOnTime=$_POST['fanOnTime'];
	$sql = "UPDATE config SET configValue = " . $useFanPin ." WHERE configName = \"useFanPin\"";
	mysql_query($sql);
	$sql = "UPDATE config SET configValue = " . $fanInterval ." WHERE configName = \"fanInterval\"";
	mysql_query($sql);
	$sql = "UPDATE config SET configValue = " . $fanOnTime ." WHERE configName = \"fanOnTime\"";
	mysql_query($sql);
	file_get_contents('http://' . $_SERVER['SERVER_NAME'] . '/admin/trigger.php?value=fan');
	
}else if( isset($_POST['enableTap'])){
	$tapManager->enableTap($_POST['tapNumber']);
	file_get_contents('http://' . $_SERVER['SERVER_NAME'] . '/admin/trigger.php?value=valve');

}else if( isset($_POST['disableTap'])){
	$tapManager->disableTap($_POST['tapNumber']);
	file_get_contents('http://' . $_SERVER['SERVER_NAME'] . '/admin/trigger.php?value=valve');
}

$numberOfTaps = $tapManager->getTapNumber();

// Code to get config values
$config = array();
$sql = "SELECT * FROM config";
$qry = mysql_query($sql);
while($c = mysql_fetch_array($qry)){
	$config[$c['configName']] = $c['configValue'];
}

// Code to get tap config values
$tapsconfig = array();
$sql = "SELECT * FROM tapconfig";
$qry = mysql_query($sql);
while($c = mysql_fetch_array($qry)){
	$tapsconfig[$c['tapNumber']] = $c;
}

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
			<li class="current">Tap Config</li>            
		</ul>
	</div>
	<!-- Top Breadcrumb End --> 
	
	<!-- Right Side/Main Content Start -->
	<div id="rightside">
		<div class="contentcontainer med left">
	<p>
	<!-- Set Tap Number Form -->
		<form method="POST" name="taplimit">
			<b>Number Of Taps:</b> &nbsp <input type="text" name="numberOfTaps" class="smallbox" value="<?php echo $numberOfTaps ?>"> &nbsp <input type="submit" name="updateNumberOfTaps" class="btn" value="Update Number of Taps" />
		</form>
	</p>
	<!-- End Tap Number Form -->
<br />	
	<?php 
	?>	
	
			<form method="POST">
				<input type="hidden" name="numberOfTaps" value="<?php echo $numberOfTaps ?>" />
				
				<table width="800" border="0" cellspacing="0" cellpadding="0">
					<thead>
						<tr>
							<th>Tap #</th>
							<?php if($config[ConfigNames::UseFlowMeter]) { ?>
							<th>Flow Pin (Alamode)</th>
							<?php } ?>
							<?php if($config[ConfigNames::UseTapValves]) { ?>
							<th>Valve Pin (GPIO)</th>
							<th>Valve</th>
							<?php } ?>
							<th colspan="3"></th>
						</tr>
					</thead>
					<tbody>
						<?php for($c = 1; $c <= $numberOfTaps; $c++ ){ ?>
							<form method="POST">
								<?php if( array_key_exists($c, $tapsconfig) ){
										$tapconfig = $tapsconfig[$c];							

								?>
										<input type="hidden" name="tapNumber" value="<?php echo $c?>" />
										<tr>
											<td>
												<?php echo $c ?>
											</td>
											
											<?php if($config[ConfigNames::UseFlowMeter]) { ?>
											<td>
												<input type="text" id="flowpin" class="mediumbox" name="flowpin" value="<?php echo $tapconfig["flowPin"]; ?>" />
											</td>
											<?php } ?>
											
											<?php if($config[ConfigNames::UseTapValves]) { 
												?>
											<td>
												<input type="text" id="valvepin" class="mediumbox" name="valvepin" value="<?php echo $tapconfig["valvePin"]; ?>" />
											</td>
											<td>	
																	
											<?php echo 'On<input type="radio" ' . ($tapconfig["valveOn"]?'checked':'') . ' name="valveon" value="1">' .
					'									Off<input type="radio" ' . (!$tapconfig["valveOn"]?'checked':'') . ' name="valveon" value="0"><br>';
											?>
											</td>
											<?php } ?>
											
											<td>
												<input name="saveTapConfig" type="submit" class="btn" value="Save Tap Config" />												
											</td>
										</tr>
								<?php } else { ?>
										<input type="hidden" name="tapNumber" value="<?php echo $c?>" />
										<tr>
											<td>
												<?php echo $c ?>
											</td>
											<?php if($config[ConfigNames::UseFlowMeter]) { ?>
											<td>
												<input type="text" id="flowpin" class="mediumbox" name="flowpin" value="0" />
											</td>
											<?php } ?>
											
											<?php if($config[ConfigNames::UseTapValves]) { 
												?>
											<td>
												<input type="text" id="valvepin" class="mediumbox" name="valvepin" value="0" />
											</td>
											<td>							
												Off
											</td>
											<?php } ?>
											
											<td colspan="99">
												<input name="saveTapConfig" type="submit" class="btn" value="Save Tap Config" />												
											</td>
										</tr>								
								<?php } ?>	
							</form>						
						<?php } ?>
					</tbody>
				</table>
				<br />
				<div align="right">			
					&nbsp &nbsp 
				</div>
			
			</form><br />
	<?php if($config[ConfigNames::UseFanControl]) { ?>
	<p>
	<form method="POST">
	<table width="300" border="0" cellspacing="0" cellpadding="0">
	<thead><tr><th colspan="99"><b>Fan Setup:</b></th></tr></thead>
	<tbody>
	<tr>
	<td><b>Fan Pin (GPIO):</b> </td> <td><input type="text" name="useFanPin" class="smallbox" value="<?php echo $config[ConfigNames::UseFanPin] ?>" /></td>
	</tr>
		<tr>
	<td><b>Fan Interval (mins):</b> </td> <td><input type="text" name="fanInterval" class="smallbox" value="<?php echo $config[ConfigNames::FanInterval] ?>" /></td>
	</tr>
		<tr>
	<td><b>Fan Duration (mins):</b> </td><td> <input type="text" name="fanOnTime" class="smallbox" value="<?php echo $config[ConfigNames::FanOnTime] ?>" /></td>
	</tr>
	<tr>
	<td><input type="submit" name="fanConfig" class="btn" value="Update Fan Config" /></td>
	</tr></tbody></table>
	</form>
	<br />
	Interval is the interval with which the fan will be triggered (every x minutes, turn the fan on). <br/>
	Duration is the time the fan will run after it has been triggered.<br>
	If Duration is bigger that Interval, the fan always runs, if Duration is zero or less, the fan never runs.
	</p>
	<?php } ?>
	</div>
	<!-- Start Footer -->   
<?php
include 'footer.php';
?>
	</div>
<?php
include 'left_bar.php';
?>
<?php
include 'scripts.php';
?>
</body>
</html>