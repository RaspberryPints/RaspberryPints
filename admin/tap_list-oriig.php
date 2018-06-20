<?php
require_once __DIR__ . '/header.php';
$htmlHelper = new HtmlHelper();
$tapManager = new TapManager();
$beerManager = new BeerManager();
$kegManager = new KegManager();

if (isset($_POST['tapKeg'])) {
    $tapId = $_POST['tapId'];
    redirect("tap_form.php?tapId=$tapId");
}
if (isset($_POST['updateNumberOfTaps'])) {
    $oldTapNumber = $tapManager->getNumberOfTaps();
    $newTapNumber = $_POST['numberOfTaps'];
    $tapManager->updateNumberOfTaps($newTapNumber);
    if (! isset($oldTapNumber) || $newTapNumber != $oldTapNumber) {
        file_get_contents('http://' . $_SERVER['SERVER_NAME'] . '/admin/trigger.php?value=alamode');
    }
}

if (isset($_POST['closeTap'])) {
    $tapManager->closeTap($_POST['tapId']);
    file_get_contents('http://' . $_SERVER['SERVER_NAME'] . '/admin/trigger.php?value=config');
}
if (isset($_POST['enableTap'])) {
    $tapManager->enableTap($_POST['tapId']);
    file_get_contents('http://' . $_SERVER['SERVER_NAME'] . '/admin/trigger.php?value=valve');
}
if (isset($_POST['disableTap'])) {
    $tapManager->disableTap($_POST['tapId']);
    file_get_contents('http://' . $_SERVER['SERVER_NAME'] . '/admin/trigger.php?value=valve');
}
if (isset($_POST['saveTapConfig'])) {
    $id = $_POST['tapId'];
    $tapNumber = "";
    $flowpin = 0;
    $valveon = 0;
    $valvepin = 0;
    $countpergallon = 0;
    if (isset($_POST['tapNumber'])) {
        $tapNumber = $_POST['tapNumber'];
    }
    if (isset($_POST['flowpin'])) {
        $flowpin = $_POST['flowpin'];
    }
    if (isset($_POST['valvepin'])) {
        $valvepin = $_POST['valvepin'];
    }
    if (isset($_POST['countpergallon'])) {
        $countpergallon = $_POST['countpergallon'];
    }
    $tapManager->saveTapConfig($id, $tapNumber, $flowpin, $valvepin, $valveon, $countpergallon);
    file_get_contents('http://' . $_SERVER['SERVER_NAME'] . '/admin/trigger.php?value=valve');
    file_get_contents('http://' . $_SERVER['SERVER_NAME'] . '/admin/trigger.php?value=alamode');
}
// if (isset ( $_POST ['alamodeConfig'] )) {

// $sql = "UPDATE config SET configValue = " . $_POST ['alamodePourTriggerCount'] . " WHERE configName = \"" . $config[ConfigNames::AlamodePourTriggerCount] . "\"";

// $mysqli->query ( $sql );

// $sql = "UPDATE config SET configValue = " . $_POST ['alamodeKickTriggerCount'] . " WHERE configName = \"" . $config[ConfigNames::AlamodeKickTriggerCount] . "\"";

// $mysqli->query ( $sql );

// $sql = "UPDATE config SET configValue = " . $_POST ['alamodeUpdateTriggerCount'] . " WHERE configName = \"" . $config[ConfigNames::AlamodeUpdateTriggerCount] . "\"";

// $mysqli->query ( $sql );

// file_get_contents ( 'http://' . $_SERVER ['SERVER_NAME'] . '/admin/trigger.php?value=alamode' );

// }

// if (isset ( $_POST ['fanConfig'] )) {

// $sql = "UPDATE config SET configValue = " . $_POST ['useFanPin'] . " WHERE configName = \"" . $config[ConfigNames::UseFanPin] . "\"";

// $mysqli->query ( $sql );

// $sql = "UPDATE config SET configValue = " . $_POST ['fanInterval'] . " WHERE configName = \"" . $config[ConfigNames::FanInterval] . "\"";

// $mysqli->query ( $sql );

// $sql = "UPDATE config SET configValue = " . $_POST ['fanOnTime'] . " WHERE configName = \"" . $config[ConfigNames::FanOnTime] . "\"";

// $mysqli->query ( $sql );

// file_get_contents ( 'http://' . $_SERVER ['SERVER_NAME'] . '/admin/trigger.php?value=fan' );

// }

// if (isset ( $_POST ['tapValveConfig'] )) {

// $sql = "UPDATE config SET configValue = " . $_POST ['pourShutOffCount'] . " WHERE configName = \"" . $config[ConfigNames::PourShutOffCount] . "\"";

// $mysqli->query ( $sql );

// $sql = "UPDATE config SET configValue = " . $_POST ['valvesPowerPin'] . " WHERE configName = \"" . $config[ConfigNames::ValvesPowerPin] . "\"";

// $mysqli->query ( $sql );

// $sql = "UPDATE config SET configValue = " . $_POST ['valvesOnTime'] . " WHERE configName = \"" . $config[ConfigNames::ValvesOnTime] . "\"";

// $mysqli->query ( $sql );

// file_get_contents ( 'http://' . $_SERVER ['SERVER_NAME'] . '/admin/trigger.php?value=valve' );

// }
unset($_POST);

$activeTaps = $tapManager->getActiveTaps();
$numberOfTaps = count($activeTaps);
// Code to set config values
$tapsconfig = array();
$sql = "SELECT * FROM tapconfig";
$qry = $mysqli->query($sql);
while ($u = $qry->fetch_array()) {
    $tapsconfig[$u['tapId']] = $u;
};

$config = getAllConfigs();
?>
<body>
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
			<li class="current">Tap List</li>
		</ul>
	</div>
	<!-- Top Breadcrumb End -->

	<!-- Right Side/Main Content Start -->
	<div id="rightside">
		<div class="contentcontainer med left">
			<!-- Set Tap Number Form -->
			<form method="POST" name="taplimit">
			<b>Number Of Taps:</b> &nbsp;
			<input type="text" name="numberOfTaps" class="smallbox" value="<?php echo $numberOfTaps ?>" /> &nbsp;
			<input type="submit" name="updateNumberOfTaps" class="btn" value="Update Number of Taps" />
			</form>
			<!-- End Tap Number Form -->
			<br/>
			<!-- Start On Tap Section -->
	
	<?php
$tapsErrorMsg = "";
$beers = $beerManager->GetAll();
$kegs = $kegManager->GetAll();

if (count($beers) == 0) {
    $tapsErrorMsg .= "At least 1 beer needs to be created, before you can assign a tap. <a href='beer_form.php'>Click here to create a beer</a><br/>";
}

if (count($kegs) == 0) {
    $tapsErrorMsg .= "At least 1 keg needs to be created, before you can assign a tap. <a href='keg_form.php'>Click here to create a keg</a><br/>";
}

if (strlen($tapsErrorMsg) > 0) {
    echo $htmlHelper->CreateMessage('warning', $tapsErrorMsg);
} else {
    ?>	
				
							<form method="post">
				<table style="width: 75%; border: 0; cellspacing: 1; cellpadding: 0;">
					<thead>
						<tr>
							<th>Tap #</th>
							<th>Keg</th>
							<th style="width: 10%">Beer</th>
							<th>Start Amount</th>
							<th>Current Amount</th>
							<?php if($config[ConfigNames::UseFlowMeter]) { ?>
								<th>Flow Pin</th>
							<th>Count Per Gal</th>
							<?php } ?>
							<?php if($config[ConfigNames::UseTapValves]) { ?>
								<th>Tap Valve</th>
							<?php } ?>
							<th colspan="3"></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($activeTaps as $tap){ ?>
							<?php if(null == $tap)continue; ?>
									
							<tr>
							<?php
        $keg = null;
        $beer = null;
        if (null !== $tap->get_kegId())
            $keg = $kegManager->GetById($tap->get_kegId());
        if (null !== $keg)
            $beer = $beerManager->GetById($keg->get_beerId());
        if (null == $keg)
            unset($keg);
        if (null == $beer)
            unset($beer);
        ?>
							<?php
        echo '<input type="hidden" name="tapId" value="' . $tap->get_id() . '" />';
        ?>
                                <td>
                                    <?php if(isset($tap) ) { ?>
                                    	<input type="text" id="tapNumber" class="smallbox" name="tapNumber" value="<?php echo $tap->get_tapNumber(); ?>" />
                                    <?php } ?>
                                </td>

							<td>							
                                    <?php
        if (isset($tap) && isset($keg)) {
            echo $keg->get_label();
        } else {
            echo '<input name="tapKeg" type="submit" class="btn" value="Tap a Keg" />';
        }
        ?>
                                </td>

							<td style="width: 10%">							
                                    <?php if( isset($tap) && isset($beer) ) echo $beer->get_name() ?>
                                </td>

							<td>
                                    <?php if( isset($tap) ) echo $tap->get_startAmount() ?>
                                </td>

							<td>
                                    <?php if( isset($tap) ) echo $tap->get_currentAmount() ?>
                                </td>
                                    
                                <?php if($config[ConfigNames::UseFlowMeter]) { ?>
							<td>
                             	<input type="hidden" name="saveTapConfig" value="<?php echo $tap->get_id()?>" />
                                            <?php if( isset($tap) ) { ?>
                                                <input type="text" id="flowpin" class="smallbox" name="flowpin" value="<?php echo $tap->get_flowPinId(); ?>" />
                                            <?php } ?>
                                        </td>
							<td>
                                            <?php if( isset($tap) ) { ?>
                                                <input type="text" id="countpergallon" class="smallbox" name="countpergallon" value="<?php echo $tap->get_count(); ?>" />
                                            <?php } ?>
                                        </td>
                                <?php } ?>
                                
								<?php if($config[ConfigNames::UseTapValves]) { ?>
                                    <td>
                                    	<?php if(!$config[ConfigNames::UseFlowMeter]) { ?>
                                            <input type="hidden" name="saveTapConfig" value="<?php echo $tap->get_id()?>" />
                                        <?php } ?>
                                        <?php if( isset($tap) ) { ?>
                                           <input type="text" id="valvepin" class="smallbox" name="valvepin" value="<?php echo $tap->get_valvePinId(); ?>" />
										<?php } ?>
                                    </td>
                                <?php } ?>
                                <td>
									<input name="editTap" type="submit" class="btn" value="Update Tap Info" />
                                </td>
                                
                                <?php
        if ($config[ConfigNames::UseTapValves]) {
            $kegOn = "";
            $kegOnSay = "";
            if ($tap->get_valveOn() < 1) {
                $kegOn = "enableTap";
                $kegOnSay = "Let it flow";
            } else {
                $kegOn = "disableTap";
                $kegOnSay = "Stop this";
            }
            ?>
                                    <td>
                                        <?php if( isset($tap) ) { ?>
                                            <input name="<?php echo $kegOn?>" type="submit" class="btn" value="<?php echo $kegOnSay?>" />
										<?php } ?>
                                    </td>
                                <?php } ?>
                                
                                
                                <td>
									<input name="tapKeg" type="submit" class="btn" value="New Keg" />
                                </td>

							<td>
								<input name="closeTap" type="submit" class="btn" value="Kick Keg" />
                           	</td>
						</tr>					
						<?php } ?>
					</tbody>
				</table>
			</form>
			<br />
			<div align="right">&nbsp; &nbsp;</div>
			<?php } ?>
	</div>
		<!-- End On Tap Section -->

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