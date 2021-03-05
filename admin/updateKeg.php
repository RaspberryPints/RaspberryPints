<?php

//Includes the Database and config information
require_once __DIR__.'/includes/managers/config_manager.php';
require_once __DIR__.'/includes/managers/tap_manager.php';
require_once __DIR__.'/includes/managers/keg_manager.php';
require_once __DIR__.'/includes/managers/beer_manager.php';
require_once __DIR__.'/includes/conn.php';

$config = getAllConfigs();

$tapManager = new TapManager();
$kegManager = new KegManager();
$beerManager = new BeerManager();
$tap = new Tap();
if( isset($argv) && count($argv) >= 2 ){    
    //This will be used to choose between CSV or MYSQL DB
    $db = true;
    
    if($db){        
        $config = getAllConfigs();
        // Creates arguments from info passed by python script from Flow Meters
        $ii = 1;
        $TAPID = $argv[$ii++];
        $NEW_WEIGHT = $argv[$ii++];
        $NEW_WEIGHT_UNIT = $argv[$ii++];
        
        $tap = $tapManager->GetByID($TAPID);
        if($tap && $tap->get_kegId()){
            $keg = new Keg();
            $beer = new Beer();
            $keg = $kegManager->GetByID($tap->get_kegId());
            $keg->set_weight($NEW_WEIGHT);
            
            $beer = $beerManager->GetByID($keg->get_BeerId());
            if($beer){ 
                $keggingTemperature = (!$config[ConfigNames::UseDefWeightSettings] && $keg->get_keggingTemp() && $keg->get_keggingTemp() != ''?$keg->get_keggingTemp():$config[ConfigNames::DefaultKeggingTemp]);
                $keggingTemperatureUnit = (!$config[ConfigNames::UseDefWeightSettings] && $keg->get_keggingTemp() && $keg->get_keggingTemp() != ''?$keg->get_keggingTempUnit():$config[ConfigNames::DefaultKeggingTempUnit]);
                $beerCO2PSI = (!$config[ConfigNames::UseDefWeightSettings] && $keg->get_fermentationPSI() && $keg->get_fermentationPSI() != ''?$keg->get_fermentationPSI():$config[ConfigNames::DefaultFermPSI]);
                $beerCO2PSIUnit = (!$config[ConfigNames::UseDefWeightSettings] && $keg->get_fermentationPSI() && $keg->get_fermentationPSI() != ''?$keg->get_fermentationPSIUnit():$config[ConfigNames::DefaultFermPSIUnit]);
                $finalGravity = $beer->get_fg()?$beer->get_fg():'';
                $finalGravityUnit = $beer->get_fgUnit()?$beer->get_fgUnit():'';
                $vol = getVolumeByWeight($NEW_WEIGHT, $NEW_WEIGHT_UNIT, $keg->get_emptyWeight(), $keg->get_emptyWeightUnit(), $keggingTemperature, $keggingTemperatureUnit, $config[ConfigNames::BreweryAltitude], $config[ConfigNames::BreweryAltitudeUnit], $beerCO2PSI, $beerCO2PSIUnit, $finalGravity, $finalGravityUnit, $config[ConfigNames::DisplayUnitVolume]);
    			if($vol && !is_nan($vol)){
    			    $keg->set_currentAmount($vol);
        			// Refreshes connected pages
        			if(isset($config[ConfigNames::AutoRefreshLocal]) && $config[ConfigNames::AutoRefreshLocal]){
        			    exec(__DIR__."/../includes/refresh.sh");
        			}
    			}
            }
            if( !$kegManager->Save($keg) )
            {
                echo "Could not update Weight for ".$keg->get_id()."(".$keg->get_label().")" . ($mysqli->error != ""?' ['.$mysqli->error.']':'')."\n" ;
            }
        }
    }    
}



function getVolumeByWeight($weight, $weightUnit, $emptyWeight, $emptyWeightUnit, $temperature, $temperatureUnit, $altitude, $altitudeUnit, $beerCO2PSI, $beerCO2PSIUnit, $finalGravity, $finalGravityUnit, $returnUnits)
{
    $weight = convert_weight($weight, $weightUnit, UnitsOfMeasure::WeightKiloGrams);                    //Convert to kg if in lb
    $emptyWeight = convert_weight($emptyWeight, $emptyWeightUnit, UnitsOfMeasure::WeightKiloGrams);     //Convert to kg if in lb
    $actGrav = $finalGravity;
    $actGrav = convert_gravity($actGrav, $finalGravityUnit, UnitsOfMeasure::GravitySG);                 //Convert to Specific Gravity
    $beerCO2PSI = convert_pressure($beerCO2PSI, $beerCO2PSIUnit, UnitsOfMeasure::PressurePSI);			//Convert to PSI
    
    $actLocalPress = estPressureAtAltitude($altitude, $altitudeUnit);			    					//Barometric pressure based on altitude in PSI
    $actPress = (($actLocalPress+$beerCO2PSI)*0.0680459639);											//Actual absolute pressure in atmospheres
    $actH2OMass = estWaterDensity(getTempCelsius($temperature, $temperatureUnit));						//Estimated mass of pure water at temp supplied
    $actH2OMassPress = (($actH2OMass/(1-(($actPress*101325)-101325)/215e7)));							//Actual mass of pure water adjusted for pressure
    $actCO2Vol = deLangeEquation($actLocalPress, $beerCO2PSI, $temperature, $temperatureUnit);			//Estimated Volumes of CO2 in the beer
    $actBeerWeight = (($weight-$emptyWeight)/$actGrav);													//Estimated weight of beer based on final gravity
    $actBeerVol = ($actBeerWeight/$actH2OMassPress);													//Estimated volume of beer based on final gravity
    $actGravVar = ((($actGrav-1.015)*1000)/3);														    //Actual CO2 variance for final gravity
    $actCO2Grav = ($actCO2Vol*($actGravVar/100));														//Actual CO2 adjusted for garvity variance
    $actCO2GPL = (($actCO2Vol-$actCO2Grav)*1.96);														//Actual grams per litre of CO2
    $actCO2 = (($actCO2GPL*$actBeerVol)*0.001);														    //Actual weight of CO2 in kilograms
    $actBeerWeightCO2 = ((($weight-$actCO2)-$emptyWeight)/$actGrav);									//Actual weight of beer adjusted for CO2
    $actVolume = ($actBeerWeightCO2/$actH2OMassPress);	                                                //Actual volume of beer in liters
    
 
    return convert_volume($actVolume, UnitsOfMeasure::VolumeLiter, $returnUnits);
}

function estPressureAtAltitude($altitude, $altitudeUnits){
    $altitude = convert_distance($altitude, $altitudeUnits, UnitsOfMeasure::DistanceMeter);
    return ((pow((288.15/((288.15+(-65e-4)*($altitude)))),((9.80665*0.0289644)/(8.3144598*(-65e-4)))))*14.6959487755142);
}
function deLangeEquation($localPsi, $beerPsi, $temperature, $temperatureUnit){
    return ($localPsi+$beerPsi)*(0.01821+(0.090115*(exp(-(getTempImperial($temperature, $temperatureUnit)-32)/43.11))))-3342e-6;
}
function estWaterDensity($tempCel){
    return (0.99984+$tempCel*(6.7715e-5-$tempCel*(9.0735e-6-$tempCel*(1.015e-7-$tempCel*(1.3356e-9-$tempCel*(1.4421e-11-$tempCel*(1.0896e-13-$tempCel*(4.9038e-16-9.7531e-19*$tempCel))))))));
}

function getTempImperial($temp, $tempUnit){
    return convert_temperature($temp, $tempUnit, UnitsOfMeasure::TemperatureFahrenheight);
}
function getTempCelsius($temp, $tempUnit){
    return convert_temperature($temp, $tempUnit, UnitsOfMeasure::TemperatureCelsius);
}
?>
