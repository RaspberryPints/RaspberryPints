
        <table>
        	<tr>
        	<?php
require_once __DIR__.'/../admin/includes/managers/config_manager.php';
require_once __DIR__.'/../admin/includes/managers/tempProbe_manager.php';
require_once __DIR__.'/../admin/includes/managers/pour_manager.php';
require_once __DIR__.'/../admin/includes/managers/fermenter_manager.php';
require_once __DIR__.'/../admin/includes/managers/gasTank_manager.php';
require_once __DIR__.'/../admin/includes/managers/iSpindelDevice_manager.php';
require_once __DIR__.'/config.php';


session_start();
$config = getAllConfigs();

$plaatoPins = array(
    "style" => 'v64',
    "abv" => 'v68',
    "og" => 'v65',
    "fg" => 'v66',
    "remainAmount" => 'v51',
    "lastPour" => 'v47',
    "temp" => 'v69'
);
$plaatoTemps = array();

// Connect to the database
$mysqli = db();
$config = getAllConfigs();

$index = 0;
$maxIndex = $config[ConfigNames::ShowTempOnMainPage]+$config[ConfigNames::ShowLastPour]+$config[ConfigNames::ShowRPLogo];
$tempIndex = 0;
$lastPourIndex = $config[ConfigNames::ShowTempOnMainPage];
$logoIndex = $config[ConfigNames::ShowTempOnMainPage]+$config[ConfigNames::ShowLastPour];
if( $config[ConfigNames::ShowFermOnMainPage]){
    $fermenterStart = $maxIndex;
    $fermenters = (new FermenterManager())->GetAllWithBeer();
    $maxIndex += count($fermenters);
    $fermenterEnd = $fermenterStart + count($fermenters);
}
if( $config[ConfigNames::ShowGTOnMainPage]){
    $gasTankStart = $maxIndex;
    if( $config[ConfigNames::ShowAllGTOnMainPage]){
        $gasTanks = (new gasTankManager())->GetAllActive();
    } else {
        $gasTanks = (new gasTankManager())->GetAllDispensing();
    }
    $maxIndex += count($gasTanks);
    $gasTankEnd = $gasTankStart + count($gasTanks);
}
if(isset($_SESSION['HomePageIndex']))
{
    $_SESSION['HomePageIndex'] = (($_SESSION['HomePageIndex']+1)%$maxIndex);
    $index =  $_SESSION['HomePageIndex'];
}
else
{
    $_SESSION['HomePageIndex'] = 0;
}
//Set Index for debugging
//$index = 3;

if( $config[ConfigNames::InfoTime] < 0) $index = -1;
$temp = null;
$tempDisplay = "";
$date = null;
if ($config[ConfigNames::ShowTempOnMainPage] && ($index == $tempIndex || $index < 0)) {
    
    $sql =  "SELECT * FROM vwGetActiveTaps";
    $qry = $mysqli->query($sql);
    while($b = mysqli_fetch_array($qry))
    {
        if($config[ConfigNames::UsePlaato]) {
            if(isset($b['plaatoAuthToken']) && $b['plaatoAuthToken'] !== NULL && $b['plaatoAuthToken'] != '')
            {
                foreach( $plaatoPins as $value => $pin)
                {
                    $plaatoValue = file_get_contents("http://plaato.blynk.cc/".$b['plaatoAuthToken']."/get/".$pin);
                    $plaatoValue = substr($plaatoValue, 2, strlen($plaatoValue)-4);
                    if( $value == 'fg' || $value == 'og' ) $plaatoValue = $plaatoValue/1000;
                    if( $value == "temp"){
                        if($config[ConfigNames::UsePlaatoTemp])
                        {
                            $tempInfo["tempUnit"] = (strpos($plaatoValue,"C")?UnitsOfMeasure::TemperatureCelsius:UnitsOfMeasure::TemperatureFahrenheight);
                            $tempInfo["temp"] = substr($plaatoValue, 0, strpos($plaatoValue, '°'));
                            $tempInfo["probe"] = $b['id'];
                            $tempInfo["takenDate"] = date('Y-m-d H:i:s');
                            array_push($plaatoTemps, $tempInfo);
                        }
                        //echo $value."=http://plaato.blynk.cc/".$b['plaatoAuthToken']."/get/".$pin."-".$plaatoTemp.'-'.$plaatoValue.'<br/>';
                    }else{
                        //echo $value."=http://plaato.blynk.cc/".$b['plaatoAuthToken']."/get/".$pin."-".$beeritem[$value].'-'.$plaatoValue.'<br/>';
                    }
                    
                }
            }
        }
    }
    
    if (! isset($plaatoTemps) || count($plaatoTemps) == 0) {
        $tempProbeManager = new TempProbeManager();
        $tempInfos = $tempProbeManager->get_lastTemp();
    } else {
        $tempInfos = $plaatoTemps;
    }
    foreach ($tempInfos as $tempInfo) {
        $temp = $tempInfo["temp"];
        $tempUnit = $tempInfo["tempUnit"];
        $probe = $tempInfo["probe"];
        $date = MAX($tempInfo["takenDate"], $date);
        $tempDisplay .= sprintf('%s:%0.1f%s<br/>', $probe, convert_temperature($temp, $tempUnit, $config[ConfigNames::DisplayUnitTemperature]), $config[ConfigNames::DisplayUnitTemperature]);
    }
    if (isset($date) && isset($tempDisplay))
        $tempDisplay .= sprintf('%s', str_replace(' ', "<br/>", $date));
    echo '<td class="HeaderRightSub" style="width:15%;text-align:right;vertical-align:middle">' . $tempDisplay . '</td>';
}

?>
          
<?php
if (null !== $temp) {
?>
		<td style="width:8%;border-left:none">
        <div class="temp-container">
        	<div class="temp-indicator">
        		<div class="temp-full" style="height:<?php echo convert_temperature($temp, $tempUnit, UnitsOfMeasure::TemperatureFahrenheight); ?>%; padding-right: 50px"></div>
        	</div>
        </div>
        </td>
<?php 
}
if($config[ConfigNames::ShowLastPour] && ($index == $lastPourIndex || $index < 0)) {
?>
        		<td class="poursbeername" colspan="2">
        			<h1 style="text-align: center">Last Pour</h1>
        		</td>
        		</tr>
        		<tr>
        <?php
        $totalRows = 0;
        $poursList = (new PourManager())->getLastPours(1, 1, $totalRows);
        $pour = count($poursList)>0?array_values($poursList)[0]:null;
        if(null !== $pour) {?>
        <?php if($pour->get_userName()){?>
        		<td class="poursuser">
        			<h1 style="font-size: 1em; text-align: right"><?php echo $pour->get_userName(); ?></h1>
        		</td>
        		<?php }?>
        		<td class="poursbeername">
        			<h1 style="font-size: 1em; text-align: right"><?php echo $pour->get_beerName(); ?></h1>
        		</td>
        		<td class="poursamount">
        			<h1><?php echo $pour->get_amountPouredDisplay(); ?></h1>
        		</td>
    	<?php } ?>
<?php 
}

if($config[ConfigNames::ShowRPLogo] && ($index == $logoIndex || $index < 0)) { 
?>
<td>
	<?php if($config[ConfigNames::UseHighResolution]) { ?>
        <a href="http://www.raspberrypints.com"><img
        	src="img/RaspberryPints-4k.png" height="200" alt=""></a>
    <?php } else { ?>
        <a href="http://www.raspberrypints.com"><img
        	src="img/RaspberryPints.png" height="100" alt=""></a>
    <?php } ?>
</td>
<?php 
}

if($config[ConfigNames::ShowFermOnMainPage] && ($index >= $fermenterStart && $index < $fermenterEnd)) {
    $fementer = $fermenters[$index-$fermenterStart+1];
    $iSpindel = (new iSpindelDeviceManager())->GetTopWithBeer($fementer->get_beerId(), $fementer->get_beerBatchId());
    ?>
    <td style="position:relative;text-align:center;color:white">
     <img height="65px" src="img/fermenter/fermenterSvg.php?container=conical&rgb=<?php echo $fementer->get_beerRgb();?>" />
     <div style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);-webkit-text-stroke:black .1px">
     <?php
     echo $fementer->get_label();
     if( $iSpindel && $iSpindel->get_currentTemperature() && $iSpindel->get_currentGravity()){
         echo "<br/>".$iSpindel->get_currentGravity().$iSpindel->get_currentGravityUnit()."<br/>".number_format($iSpindel->get_currentTemperature(),1);//.$iSpindel->get_currentTemperatureUnit();
     }
     ?>
    	</div>
	</td>
    </tr>
    <tr>
    <td class="poursbeername">
    	<h1 style="text-align: center"><?php echo $fementer->get_beerName().($fementer->get_beerBatchName()?"-Batch:".$fementer->get_beerBatchName():""); ?></h1>
    </td>
    </tr>
    <tr>
    <td>
    Filled:<?php echo (new DateTime($fementer->get_startDate()))->format('Y-m-d'); ?>
    </td>
<?php
}
?>

<?php
if($config[ConfigNames::ShowGTOnMainPage] && ($index >= $gasTankStart && $index < $gasTankEnd)) {
    $gasTank = $gasTanks[$index-$gasTankStart+1];
    $gtImgColor = "0,255,0";
    $percentRemaining = 0.0;
    $currentWeight = convert_weight($gasTank->get_currentWeight(), $gasTank->get_currentWeightUnit(), UnitsOfMeasure::WeightGrams);
    $maxWeight = convert_weight($gasTank->get_maxWeight(), $gasTank->get_maxWeightUnit(), UnitsOfMeasure::WeightGrams);
    $emptyWeight = convert_weight($gasTank->get_emptyWeight(), $gasTank->get_emptyWeightUnit(), UnitsOfMeasure::WeightGrams);
    if( $currentWeight && $gasTank->get_maxWeight() > 0)$percentRemaining = ($currentWeight / $maxWeight) * 100;
    if( $currentWeight <= $emptyWeight ) {
        $percentRemaining = 0;
    } else if( $percentRemaining < 15 ) {
        $gtImgColor = "255,0,0";
    } else if( $percentRemaining < 25 ) {
        $gtImgColor = "255,165,0";
    } else if( $percentRemaining < 45 ) {
        $gtImgColor = "255,255,0";
    } else if ( $percentRemaining < 100 ) {
        $gtImgColor = "0,255,0";
    } else if( $percentRemaining >= 100 ) {
        $gtImgColor = "0,255,0";
    }
    ?>
    <td>
     <img height="75px" src="img/gasTank/gasTankSvg.php?container=gasTank&fill=<?php echo $percentRemaining; ?>&rgb=<?php echo $gtImgColor?><?php echo $percentRemaining<=0?"&empty":""; ?>" />
	</td>
    </tr>
    <tr>
    <td>
    <?php echo $gasTank->get_label(); ?>
    </td>
<?php 
}
?>
    </tr>
</table> 