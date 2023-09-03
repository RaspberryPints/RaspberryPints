<?php

//Includes the Database and config information
require_once __DIR__.'/includes/managers/config_manager.php';
require_once __DIR__.'/includes/managers/beerBatch_manager.php';
require_once __DIR__.'/includes/conn.php';

$config = getAllConfigs();

$beerBatchManager = new BeerBatchManager();
/** @var mixed $argv  **/
if( isset($argv) && count($argv) >= 5 ){    
    //This will be used to choose between CSV or MYSQL DB
    $db = true;
    
    if($db){        
        $config = getAllConfigs();
        // Creates arguments from info passed by python script from Flow Meters
        $ii = 1;
        $ID = $argv[$ii++];
        $NEW_TEMP = $argv[$ii++];
        $NEW_TEMP_UNIT = $argv[$ii++];
        $NEW_GRAVITY = $argv[$ii++];
        $NEW_GRAVITY_UNIT = $argv[$ii++];
        
        
        $beerBatch = $beerBatchManager->GetByID($ID);
        if($beerBatch){
            $currentMinTemp = $beerBatch->get_fermentationTempMin()?convert_temperature($beerBatch->get_fermentationTempMin(), $beerBatch->get_fermentationTempMinUnit(), $NEW_TEMP_UNIT):null;
            $currentMaxTemp = $beerBatch->get_fermentationTempMax()?convert_temperature($beerBatch->get_fermentationTempMax(), $beerBatch->get_fermentationTempMaxUnit(), $NEW_TEMP_UNIT):null;
            
            if( $config[ConfigNames::iSUpdateMinTemp] && (!$currentMinTemp || $currentMinTemp == '' || $NEW_TEMP < $currentMinTemp))
            {
                $beerBatch->set_fermentationTempMin($NEW_TEMP);
                $beerBatch->set_fermentationTempMinUnit($NEW_TEMP_UNIT);
            }
            if( $config[ConfigNames::iSUpdateMaxTemp] && (!$currentMaxTemp || $currentMaxTemp == '' || $NEW_TEMP > $currentMaxTemp))
            {
                $beerBatch->set_fermentationTempMax($NEW_TEMP);
                $beerBatch->set_fermentationTempMaxUnit($NEW_TEMP_UNIT);
            }
            
            if($config[ConfigNames::iSUpdateOG] && (!$beerBatch->get_og() || $beerBatch->get_og() == '')) {
                $beerBatch->set_og($NEW_GRAVITY);
                $beerBatch->set_ogUnit($NEW_GRAVITY_UNIT);
            }
            
            if($config[ConfigNames::iSUpdateFG])
            {
                $beerBatch->set_fg($NEW_GRAVITY);
                $beerBatch->set_fgUnit($NEW_GRAVITY_UNIT);
            }
            $beerBatchManager->save($beerBatch);
        }
    }    
}

?>
