<?php

//Includes the Database and config information
require_once __DIR__.'/includes/managers/gasTank_manager.php';
require_once __DIR__.'/includes/conn.php';

$gasTankManager = new GasTankManager();
$gasTank = new gasTank();
/** @var mixed $argv */
if( isset($argv) && count($argv) >= 2 ){    
    //This will be used to choose between CSV or MYSQL DB
    $db = true;
    
    if($db){        
        // Creates arguments from info passed by python script from Flow Meters
        $ii = 1;
        $ID = $argv[$ii++];
        $NEW_WEIGHT = $argv[$ii++];
        $NEW_WEIGHT_UNIT = $argv[$ii++];
        
        $gasTank = $gasTankManager->GetByID($ID);
        if($gasTank && $gasTank->get_id()){
            $gasTank->set_weight($NEW_WEIGHT);
            $gasTank->set_weightUnit($NEW_WEIGHT_UNIT);
            if( !$gasTankManager->Save($gasTank) )
            {
                /** @var mixed $mysqli */
                echo "Could not update Weight for ".$gasTank->get_id()."(".$gasTank->get_label().")" . ($mysqli->error != ""?' ['.$mysqli->error.']':'')."\n" ;
            }
        }
    }    
}



?>
