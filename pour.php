<?php
        require_once __DIR__.'/includes/config.php';
        require_once __DIR__.'/admin/includes/models/tap.php';
        require_once __DIR__.'/admin/includes/managers/tap_manager.php';


        parse_str($_SERVER['QUERY_STRING']);

        $tapManager = new TapManager();

        db();

        if (isset($building) and isset($pin) and isset($pulses)){
                
                $tapNum = 0;
                if ($building == "5k" and $pin == 8) $tapNum = 1;
                elseif ($building == "5k" and $pin == 9) $tapNum = 2;
                elseif ($building == "5k" and $pin == 10) $tapNum = 0;
                elseif ($building == "5k" and $pin == 11) $tapNum = 0;
                elseif ($building == "3k" and $pin == 8) $tapNum = 3;
                elseif ($building == "3k" and $pin == 9) $tapNum = 4;
                elseif ($building == "3k" and $pin == 10) $tapNum = 0;
                elseif ($building == "3k" and $pin == 11) $tapNum = 0;

                $tap = $tapManager->GetByNumber($tapNum);
                $tapId = $tap->get_id();

                $pulsesPerLitre = 5400;
                $galonsPerLitre = 0.264172;

                $amountPoured = $pulses / $pulsesPerLitre * $galonsPerLitre;

                $sql = "INSERT INTO pours (tapId, amountPoured, createdDate, modifiedDate) values ($tapId,$amountPoured,NOW(),NOW())";

                if(mysql_query($sql)) {
                        echo "Recorded Pour";
                } else {
                
                }
        }       
?>