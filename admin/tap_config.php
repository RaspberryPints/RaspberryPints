<?php
session_start ();
if (! isset ( $_SESSION ['myusername'] )) {
	header ( "location:index.php" );
}

require_once __DIR__ . '/includes/conn.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/html_helper.php';

require_once __DIR__ . '/includes/models/tap.php';
require_once __DIR__ . '/includes/models/beer.php';
require_once __DIR__ . '/includes/models/keg.php';

require_once __DIR__ . '/includes/managers/beer_manager.php';
require_once __DIR__ . '/includes/managers/keg_manager.php';
require_once __DIR__ . '/includes/managers/tap_manager.php';

$htmlHelper = new HtmlHelper ();
$tapManager = new TapManager ();

if (isset ( $_POST ['updateNumberOfTaps'] )) {
	$oldTapNumber = $tapManager->getTapNumber();
	$newTapNumber = $_POST ['numberOfTaps'];
	$tapManager->updateTapNumber ( $_POST ['numberOfTaps'] );
	if( $newTapNumber < $oldTapNumber) {
		file_get_contents ( 'http://' . $_SERVER ['SERVER_NAME'] . '/admin/trigger.php?value=alamode' );
	}

} else if (isset ( $_POST ['saveTapConfig'] )) {
	$tapNumber = $_POST ['tapNumber'];
	$flowpin = $_POST ['flowpin'];
	$valvepin = $_POST ['valvepin'];
	$valveon = $_POST ['valveon'];
	$tapManager->saveTapConfig ( $tapNumber, $flowpin, $valvepin, $valveon );
	file_get_contents ( 'http://' . $_SERVER ['SERVER_NAME'] . '/admin/trigger.php?value=valve' );
	file_get_contents ( 'http://' . $_SERVER ['SERVER_NAME'] . '/admin/trigger.php?value=alamode' );
	
} else if (isset ( $_POST ['flowMeterConfig'] )) {
	$pourCountConversion = $_POST ['pourCountConversion'];
	$pourShutOffCount = $_POST ['pourShutOffCount'];
	$sql = "UPDATE config SET configValue = " . $pourCountConversion . " WHERE configName = \"pourCountConversion\"";
	mysql_query ( $sql );
	$sql = "UPDATE config SET configValue = " . $pourShutOffCount . " WHERE configName = \"pourShutOffCount\"";
	mysql_query ( $sql );
	file_get_contents ( 'http://' . $_SERVER ['SERVER_NAME'] . '/admin/trigger.php?value=flow' );
	
} else if (isset ( $_POST ['alamodeConfig'] )) {
	$alamodePourMessageDelay = $_POST ['alamodePourMessageDelay'];
	$sql = "UPDATE config SET configValue = " . $alamodePourMessageDelay . " WHERE configName = \"alamodePourMessageDelay\"";
	mysql_query ( $sql );
	$alamodePourTriggerCount = $_POST ['alamodePourTriggerCount'];
	$sql = "UPDATE config SET configValue = " . $alamodePourTriggerCount . " WHERE configName = \"alamodePourTriggerCount\"";
	mysql_query ( $sql );
	$alamodeKickTriggerCount = $_POST ['alamodeKickTriggerCount'];
	$sql = "UPDATE config SET configValue = " . $alamodeKickTriggerCount . " WHERE configName = \"alamodeKickTriggerCount\"";
	mysql_query ( $sql );
	$alamodeUpdateTriggerCount = $_POST ['alamodeUpdateTriggerCount'];
	$sql = "UPDATE config SET configValue = " . $alamodeUpdateTriggerCount . " WHERE configName = \"alamodeUpdateTriggerCount\"";
	mysql_query ( $sql );
	file_get_contents ( 'http://' . $_SERVER ['SERVER_NAME'] . '/admin/trigger.php?value=alamode' );
	
} else if (isset ( $_POST ['fanConfig'] )) {
	$useFanPin = $_POST ['useFanPin'];
	$fanInterval = $_POST ['fanInterval'];
	$fanOnTime = $_POST ['fanOnTime'];
	$sql = "UPDATE config SET configValue = " . $useFanPin . " WHERE configName = \"useFanPin\"";
	mysql_query ( $sql );
	$sql = "UPDATE config SET configValue = " . $fanInterval . " WHERE configName = \"fanInterval\"";
	mysql_query ( $sql );
	$sql = "UPDATE config SET configValue = " . $fanOnTime . " WHERE configName = \"fanOnTime\"";
	mysql_query ( $sql );
	file_get_contents ( 'http://' . $_SERVER ['SERVER_NAME'] . '/admin/trigger.php?value=fan' );
	
} else if (isset ( $_POST ['enableTap'] )) {
	$tapManager->enableTap ( $_POST ['tapNumber'] );
	file_get_contents ( 'http://' . $_SERVER ['SERVER_NAME'] . '/admin/trigger.php?value=valve' );
} else if (isset ( $_POST ['disableTap'] )) {
	$tapManager->disableTap ( $_POST ['tapNumber'] );
	file_get_contents ( 'http://' . $_SERVER ['SERVER_NAME'] . '/admin/trigger.php?value=valve' );
}

// Code to get config values
$config = array ();
$sql = "SELECT * FROM config";
$qry = mysql_query ( $sql );
while ( $c = mysql_fetch_array ( $qry ) ) {
	$config [$c ['configName']] = $c ['configValue'];
}

// Code to get tap config values
$tapsconfig = array ();
$sql = "SELECT * FROM tapconfig";
$qry = mysql_query ( $sql );
while ( $c = mysql_fetch_array ( $qry ) ) {
	$tapsconfig [$c ['tapNumber']] = $c;
}

$numberOfTaps = $tapManager->getTapNumber();
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
	rel='stylesheet' type='text/css'>

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
				<b>Number Of Taps:</b> &nbsp <input type="text" name="numberOfTaps"
					class="smallbox" value="<?php echo $numberOfTaps ?>"> &nbsp <input
					type="submit" name="updateNumberOfTaps" class="btn"
					value="Update Number of Taps" />
			
			</form>
		</p>
		<!-- End Tap Number Form -->
		<br />	
	<?php
	?>	
	
			<form method="POST">
			<input type="hidden" name="numberOfTaps"
				value="<?php echo $numberOfTaps ?>" />

			<table width="800" border="0" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<th>Tap #</th>
							<?php if($config[ConfigNames::UseFlowMeter]) { ?>
							<th>Flow Pin (Alamode)</th>
							<?php } ?>
							<?php if($config[ConfigNames::UseTapValves]) { ?>
							<th>Valve Pin (GPIO)</th>
			<!--   <th>Valve</th> -->
							<?php } ?>
							<th colspan="3"></th>
					</tr>
				</thead>
				<tbody>
						<?php for($c = 1; $c <= $numberOfTaps; $c++ ){ ?>
						<form method="POST">
						<?php
							if (array_key_exists ( $c, $tapsconfig )) {
								$tapconfig = $tapsconfig [$c];
						?>
						<input type="hidden" name="tapNumber" value="<?php echo $c?>" />
						<tr>
							<td>
							<?php echo $c?>
							</td>
							<?php 
							if($config[ConfigNames::UseFlowMeter]) { ?>
								<td><input type="text" id="flowpin" class="mediumbox"
								name="flowpin" value="<?php echo $tapconfig["flowPin"]; ?>" /></td>
							<?php } ?>
											
							<?php
							if ($config [ConfigNames::UseTapValves]) {
							?>
								<td><input type="text" id="valvepin" class="mediumbox"
								name="valvepin" value="<?php echo $tapconfig["valvePin"]; ?>" />
							</td>
							<?php } ?>
											
							<td>
								<input name="saveTapConfig" type="submit" class="btn" value="Save Tap Config" />
							</td>
							<?php if($config[ConfigNames::UseTapValves]) {
								$kegOn = "";
								$kegOnSay = "";
								if ( $tapconfig["valveOn"] < 1 ) {
									$kegOn = "enableTap";
									$kegOnSay = "Let it flow";
								} else {
									$kegOn = "disableTap";
									$kegOnSay = "Stop this";
								}
							?>
							<td>
								<input name="<?php echo $kegOn?>" type="submit" class="btn" value="<?php echo $kegOnSay?>" />
							</td>
							<?php } ?>
						</tr>
							<?php } else { ?>
							<input type="hidden" name="tapNumber" value="<?php echo $c?>" />
						<tr>
							<td>
								<?php echo $c?>
							</td>
								<?php if($config[ConfigNames::UseFlowMeter]) { ?>
							<td>
								<input type="text" id="flowpin" class="mediumbox" name="flowpin" value="0" />
							</td>
							<?php } ?>
											
							<?php if ($config [ConfigNames::UseTapValves]) { ?>
							<td>
								<input type="text" id="valvepin" class="mediumbox" name="valvepin" value="0" />
							</td>
							<?php } ?>
											
							<td colspan="99"><input name="saveTapConfig" type="submit"
								class="btn" value="Save Tap Config" />
							</td>
						</tr>								
							<?php } ?>	
						</form>						
						<?php } ?>
					</tbody>
			</table>
			<div align="right">&nbsp &nbsp</div>
		</form>

			<?php if($config[ConfigNames::UseFlowMeter]) { ?>
		<p>
			<form method="POST" name="flowMeterConfig">
				<table width="300" border="0" cellspacing="0" cellpadding="0">
					<thead>
						<tr>
							<th colspan="99"><b>Flow Meters Setup:</b></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><b>Pour Count per Gallon:</b><br/>How many flow meter counts per gallon</td>
							<td><input type="text" name="pourCountConversion"
								class="smallbox"
								value="<?php echo ($config[ConfigNames::PourCountConversion]) ?>"></td>
						</tr>
						<tr>
							<td><b>Pour Shutoff Count:</b><br/>The flow meter count in one pour after which a tap is shutoff<br/>(only with solenoids installed) </td>
							<td><input type="text" name="pourShutOffCount" class="smallbox"
								value="<?php echo ($config[ConfigNames::PourShutOffCount]) ?>"></td>
						</tr>
						<tr>
							<td><input type="submit" name="flowMeterConfig" class="btn"
								value="Update Flow Meter Config" /></td>
						</tr>
					</tbody>
				</table>
			</form>
		</p>
		<br>
		<p>
			<form method="POST" name="alamodeConfig">
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
								value="<?php echo ($config[ConfigNames::AlamodePourMessageDelay]) ?>"></td>
						</tr>
						<tr>
							<td><b>Pour Trigger Count:</b><br/> The minimum flow meter count to start a pour</td>
							<td><input type="text" name="alamodePourTriggerCount" class="smallbox"
								value="<?php echo ($config[ConfigNames::AlamodePourTriggerCount]) ?>"></td>
						</tr>
						<tr>
							<td><b>Kick Trigger Count:</b><br/> The flow meter count within one millisecond that indicates a kick</td>
							<td><input type="text" name="alamodeKickTriggerCount"
								class="smallbox"
								value="<?php echo ($config[ConfigNames::AlamodeKickTriggerCount]) ?>"></td>
						</tr>
						<tr>
							<td><b>Update Trigger Count:</b><br/>The flow meter count after which a internal update is reported</td>
							<td><input type="text" name="alamodeUpdateTriggerCount" class="smallbox"
								value="<?php echo ($config[ConfigNames::AlamodeUpdateTriggerCount]) ?>"></td>
						</tr>
						<tr>
							<td><input type="submit" name="alamodeConfig" class="btn"
								value="Update Alamode Config" /></td>
						</tr>
					</tbody>
				</table>
			</form>
		</p>
		<?php } ?>
			
			<?php if($config[ConfigNames::UseFanControl]) { ?>
			<br />
		<p>
			<form method="POST">
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