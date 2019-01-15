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
        //TODO figure out units on weight
        
        $tap = $tapManager->GetByID($TAPID);
        if($tap && $tap->get_kegId()){
            $keg = new Keg();
            $beer = new Beer();
            $keg = $kegManager->GetByID($tap->get_kegId());
            $keg->set_weight($NEW_WEIGHT);
            $kegManager->Save($keg);
            
            $beer = $beerManager->GetByID($keg->get_BeerId());
            if($beer){ 
                $temperature = (!$config[ConfigNames::UseDefWeightSettings] && $tap->get_keggingTemp() && $tap->get_keggingTemp() != ''?$tap->get_keggingTemp():$config[ConfigNames::DefaultKeggingTemp]);
                $beerCO2PSI = (!$config[ConfigNames::UseDefWeightSettings] && $tap->get_fermentationPSI() && $tap->get_fermentationPSI() != ''?$tap->get_fermentationPSI():$config[ConfigNames::DefaultFermPSI]);
                $convertToMetric = true; //TODO when units are working change
                $finalGravity = $beer->get_fg()?$beer->get_fg():'';
                $convertToGravity = false; //TODO if able to apply brix or plato set to true
    			$vol = getVolumeByWeight($NEW_WEIGHT, $keg->get_emptyWeight(), $temperature, $config[ConfigNames::BreweryAltitude], $beerCO2PSI, $convertToMetric, $finalGravity, $convertToGravity);
    			if($vol && !is_nan($vol)){
        			$tap->set_currentAmount($vol);
        			$tapManager->Save($tap);
        			// Refreshes connected pages
        			if(isset($config[ConfigNames::AutoRefreshLocal]) && $config[ConfigNames::AutoRefreshLocal]){
        			    exec(__DIR__."/../includes/refresh.sh");
        			}
    			}
            }
        }
    }    
}



function getVolumeByWeight($weight, $emptyWeight, $temperature, $altitude, $beerCO2PSI, $convertToMetric, $finalGravity, $convertToGravity)
{
    //convertToMetric means the values given are imperial and not metric already.
    //convertToGravity means the values given are Plato and not gravity already.
    if($convertToMetric) $weight =  ($weight/2.2046226218);											    //Convert to kg if in lb
    if($convertToMetric) $emptyWeight =  ($emptyWeight/2.2046226218);									//Convert to kg if in lb
    $actGrav = $finalGravity;
    if($convertToGravity) $actGrav = 259/(259-$actGrav);												//Convert to gravity if in Plato
    if(!$convertToMetric) $beerCO2PSI = $beerCO2PSI*.145038;		   									//Convert to PSI if in kPa
    
    $actLocalPress = estPressureAtAltitude($altitude, $convertToMetric);								//Barometric pressure based on altitude in PSI
    $actPress = (($actLocalPress+$beerCO2PSI)*0.0680459639);											//Actual absolute pressure in atmospheres
    $actH2OMass = estWaterDensity(getTempCelsius($temperature, $convertToMetric));						//Estimated mass of pure water at temp supplied
    $actH2OMassPress = (($actH2OMass/(1-(($actPress*101325)-101325)/215e7)));							//Actual mass of pure water adjusted for pressure
    $actCO2Vol = deLangeEquation($actLocalPress, $beerCO2PSI, $temperature, $convertToMetric);			//Estimated Volumes of CO2 in the beer
    $actBeerWeight = (($weight-$emptyWeight)/$actGrav);													//Estimated weight of beer based on final gravity
    $actBeerVol = ($actBeerWeight/$actH2OMassPress);													//Estimated volume of beer based on final gravity
    $actGravVar = ((($actGrav-1.015)*1000)/3);														    //Actual CO2 variance for final gravity
    $actCO2Grav = ($actCO2Vol*($actGravVar/100));														//Actual CO2 adjusted for garvity variance
    $actCO2GPL = (($actCO2Vol-$actCO2Grav)*1.96);														//Actual grams per litre of CO2
    $actCO2 = (($actCO2GPL*$actBeerVol)*0.001);														    //Actual weight of CO2 in kilograms
    $actBeerWeightCO2 = ((($weight-$actCO2)-$emptyWeight)/$actGrav);									//Actual weight of beer adjusted for CO2
    $actVolume = (($actBeerWeightCO2/$actH2OMassPress)*(!$convertToMetric?0.264172052:1));	            //Actual volume of beer in units requested
    
    //if we need to convert the arguments to metric then we need to convert metric to imperial in the return value
    return $actVolume*($convertToMetric?0.264172052:1);
}

function estPressureAtAltitude($altitude, $convertToMetric){
    if($convertToMetric) $altitude = ($altitude)*0.3048;										//Convert altitude to meters if in feet
    return ((pow((288.15/((288.15+(-65e-4)*($altitude)))),((9.80665*0.0289644)/(8.3144598*(-65e-4)))))*14.6959487755142);
}
function deLangeEquation($localPsi, $beerPsi, $temperature, $convertToMetric){
    return ($localPsi+$beerPsi)*(0.01821+(0.090115*(exp(-(getTempImperial($temperature, $convertToMetric)-32)/43.11))))-3342e-6;
}
function estWaterDensity($tempCel){
    return (0.99984+$tempCel*(6.7715e-5-$tempCel*(9.0735e-6-$tempCel*(1.015e-7-$tempCel*(1.3356e-9-$tempCel*(1.4421e-11-$tempCel*(1.0896e-13-$tempCel*(4.9038e-16-9.7531e-19*$tempCel))))))));
}

function getTempImperial($temp, $convertToMetric){
    //if needing convert to metric we are in farenheit return as is
    if($convertToMetric) return $temp;
    return (($temp*9)/5)+32;
}
function getTempCelsius($temp, $convertToMetric){
    //if NOT needing convert to metric we are in metric return as is
    if(!$convertToMetric) return $temp;
    return (($temp-32)*5)/9;
}
?>
