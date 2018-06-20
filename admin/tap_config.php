<?php
session_start ();
if (! isset ( $_SESSION ['myusername'] )) {
	header ( "location:index.php" );
}

require_once __DIR__.'/header.php';

$htmlHelper = new HtmlHelper ();
$tapManager = new TapManager ();

if (isset ( $_POST ['updateNumberOfTaps'] )) {
	$oldTapNumber = $tapManager->getNumberOfTaps();
	$newTapNumber = $_POST ['numberOfTaps'];
	$tapManager->updateNumberOfTaps ( $_POST ['numberOfTaps'] );
	if( !isset($oldTapNumber) || $newTapNumber != $oldTapNumber) {
		file_get_contents ( 'http://' . $_SERVER ['SERVER_NAME'] . '/admin/trigger.php?value=alamode' );
	}

} else if (isset ( $_POST ['saveTapConfig'] )) {
	$tapId = $_POST ['tapId'];
	$valveon = 0;
	$flowpin = 0;
	if (isset ( $_POST ['flowpin'] )) {
		$flowpin = $_POST ['flowpin'];
	}
	$valvepin = 0;
	if (isset ( $_POST ['valvepin'] )) {
		$valvepin = $_POST ['valvepin'];
	}
	$countpergallon = 0;
	if (isset ( $_POST ['countpergallon'] )) {
		$countpergallon = $_POST ['countpergallon'];
	}
	$tapManager->saveTapConfig ( $tapId, $flowpin, $valvepin, $valveon, $countpergallon );
	file_get_contents ( 'http://' . $_SERVER ['SERVER_NAME'] . '/admin/trigger.php?value=valve' );
	file_get_contents ( 'http://' . $_SERVER ['SERVER_NAME'] . '/admin/trigger.php?value=alamode' );
	
} else if (isset ( $_POST ['flowMeterConfig'] )) {
	saveConfigValue(ConfigNames::PourShutOffCount, $_POST ['pourShutOffCount']);
	file_get_contents ( 'http://' . $_SERVER ['SERVER_NAME'] . '/admin/trigger.php?value=flow' );
	
} else if (isset ( $_POST ['alamodeConfig'] )) {
	saveConfigValue(ConfigNames::AlamodePourMessageDelay, $_POST ['alamodePourMessageDelay']);
	saveConfigValue(ConfigNames::AlamodePourTriggerCount, $_POST ['alamodePourTriggerCount']);
	saveConfigValue(ConfigNames::AlamodeKickTriggerCount, $_POST ['alamodeKickTriggerCount']);
	saveConfigValue(ConfigNames::AlamodeUpdateTriggerCount, $_POST ['alamodeUpdateTriggerCount']);
	file_get_contents ( 'http://' . $_SERVER ['SERVER_NAME'] . '/admin/trigger.php?value=alamode' );
	
} else if (isset ( $_POST ['fanConfig'] )) {
	saveConfigValue(ConfigNames::UseFanPin, $_POST ['useFanPin']);
	saveConfigValue(ConfigNames::FanInterval, $_POST ['fanInterval']);
	saveConfigValue(ConfigNames::FanOnTime, $_POST ['fanOnTime']);
	file_get_contents ( 'http://' . $_SERVER ['SERVER_NAME'] . '/admin/trigger.php?value=fan' );
	
} else if (isset ( $_POST ['enableTap'] )) {
	$tapManager->enableTap ( $_POST ['tapId'] );
	file_get_contents ( 'http://' . $_SERVER ['SERVER_NAME'] . '/admin/trigger.php?value=valve' );
} else if (isset ( $_POST ['disableTap'] )) {
	$tapManager->disableTap ( $_POST ['tapId'] );
	file_get_contents ( 'http://' . $_SERVER ['SERVER_NAME'] . '/admin/trigger.php?value=valve' );
}

// Code to get config values
$config = getAllConfigs();

// Code to get tap config values
$tapsconfig = array ();
$sql = "SELECT * FROM tapconfig";
$qry = $mysqli->query ( $sql );
while ( $c = $qry->fetch_array ( ) ) {
	$tapsconfig [$c ['tapId']] = $c;
}

$numberOfTaps = $tapManager->getNumberOfTaps();
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
<link href='http://fonts.googleapis.com/css?family=Fredoka+One'
	rel='stylesheet' type='text/css'/>

</head>
<body>
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
		<!-- Set Tap Number Form -->
		<!-- <p>
			<form method="POST" name="taplimit">
				<b>Number Of Taps:</b> &nbsp; 
				    <input type="text" name="numberOfTaps"
					class="smallbox" value="<?php echo $numberOfTaps ?>"> &nbsp; 
					<input type="submit" name="updateNumberOfTaps" class="btn"
					value="Update Number of Taps" />
			
			</form>
		</p> -->
		<!-- End Tap Number Form -->
		<br />	
	<?php
	?>	
	
	<?php if($config[ConfigNames::UseFlowMeter]) { ?>
	
		<form method="post" name="flowMeterConfig">
			<table width="300" border="0" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<th colspan="99"><b>Flow Meters Setup:</b></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><b>Pour Shutoff Count:</b><br/>The flow meter count in one pour after which a tap is shutoff<br/>(only with solenoids installed) </td>
						<td><input type="text" name="pourShutOffCount" class="smallbox"
							value="<?php echo ($config[ConfigNames::PourShutOffCount]) ?>"/></td>
					</tr>
					<tr>
						<td><input type="submit" name="flowMeterConfig" class="btn"
							value="Update Flow Meter Config" /></td>
					</tr>
				</tbody>
			</table>
		</form>
		<br/>
		<form method="post" name="alamodeConfig">
			<table width="300" border="0" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<th colspan="99"><b>Alamode Setup:</b></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><b>Pour Message Delay:</b></td>
						<td><input type="text" name="alamodePourMessageDelay"
							class="smallbox"
							value="<?php echo ($config[ConfigNames::AlamodePourMessageDelay]) ?>"/></td>
					</tr>
					<tr>
						<td><b>Pour Trigger Count:</b><br/> The minimum flow meter count to start a pour</td>
						<td><input type="text" name="alamodePourTriggerCount" class="smallbox"
							value="<?php echo ($config[ConfigNames::AlamodePourTriggerCount]) ?>"/></td>
					</tr>
					<tr>
						<td><b>Kick Trigger Count:</b><br/> The flow meter count within one millisecond that indicates a kick</td>
						<td><input type="text" name="alamodeKickTriggerCount"
							class="smallbox"
							value="<?php echo ($config[ConfigNames::AlamodeKickTriggerCount]) ?>"/></td>
					</tr>
					<tr>
						<td><b>Update Trigger Count:</b><br/>The flow meter count after which a internal update is reported</td>
						<td><input type="text" name="alamodeUpdateTriggerCount" class="smallbox"
							value="<?php echo ($config[ConfigNames::AlamodeUpdateTriggerCount]) ?>"/></td>
					</tr>
					<tr>
						<td><input type="submit" name="alamodeConfig" class="btn"
							value="Update Alamode Config" /></td>
					</tr>
				</tbody>
			</table>
		</form>
		<?php } ?>
			
		<?php if($config[ConfigNames::UseFanControl]) { ?>
			<br/>
			<form method="post">
				<table width="300" border="0" cellspacing="0" cellpadding="0">
					<thead>
						<tr>
							<th colspan="99"><b>Fan Setup:</b></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><b>Fan Pin (GPIO):</b></td>
							<td><input type="text" name="useFanPin" class="smallbox"
								value="<?php echo $config[ConfigNames::UseFanPin] ?>" /></td>
						</tr>
						<tr>
							<td><b>Fan Interval (mins):</b><br/>The interval with which the fan will be triggered<br/>(every x minutes, turn the fan on).</td>
							<td><input type="text" name="fanInterval" class="smallbox"
								value="<?php echo $config[ConfigNames::FanInterval] ?>" /></td>
						</tr>
						<tr>
							<td><b>Fan Duration (mins):</b>The duration the fan will run after it has been triggered.</td>
							<td><input type="text" name="fanOnTime" class="smallbox"
								value="<?php echo $config[ConfigNames::FanOnTime] ?>" /></td>
						</tr>
						<tr>
							<td colspan="2">If Interval is less than Duration, the fan always runs. If Duration is zero or less, the fan never runs.</td> 
						</tr>
						<tr>
							<td><input type="submit" name="fanConfig" class="btn"
								value="Update Fan Config" /></td>
						</tr>
					</tbody>
				</table>
			</form>
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