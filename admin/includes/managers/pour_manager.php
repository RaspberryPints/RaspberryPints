<?php
require_once __DIR__.'/config_manager.php';
require_once __DIR__.'/tap_manager.php';
require_once __DIR__.'/keg_manager.php';
require_once __DIR__.'/beer_manager.php';
require_once __DIR__.'/user_manager.php';
require_once __DIR__.'/manager.php';
require_once __DIR__.'/../models/pour.php';
require_once __DIR__.'/../../../includes/Pintlabs/Service/Untappd.php';

class PourManager extends Manager{
	
	protected function getPrimaryKeys(){
		return ["id"];
	}
	protected function getColumns(){
	    return ["tapId", "amountPoured", "amountPouredUnit", "pinId", "pulses", "beerId", "conversion", "userId"];
	}
	protected function getTableName(){
		return "pours";
	}
	protected function getViewName(){
		return "vwPours";
	}
	protected function getDBObject(){
		return new Pour();
	}
		
	function getLastPours($page, $limit, &$totalRows){
	    return $this->getLastPoursFiltered($page, $limit, $totalRows, null, null, null, null, null);
	}

	function getLastPoursFiltered($page, $limit, &$totalRows, $startTime, $endTime, $tapId, $beerId, $userId){
		$sql="SELECT * FROM ".$this->getViewName()." ";
		$where = "";
		if($startTime && $startTime != "") $where = $where.($where != ""?"AND ":"")."createdDate >= '$startTime' ";
		if($endTime && $endTime != "") $where = $where.($where != ""?"AND ":"")."createdDate < '$endTime' ";
		if($tapId)  $where = $where.($where != ""?"AND ":"")."tapId = $tapId ";
		if($beerId) $where = $where.($where != ""?"AND ":"")."beerId = $beerId ";
		if($userId) $where = $where.($where != ""?"AND ":"")."userId = $userId ";
		if($where != "") $sql = $sql."WHERE $where ";
		$sql = $sql."ORDER BY createdDate DESC ";
		$totalRows = 0;
		if($results = $this->executeQueryWithResults($sql)){
		    $totalRows = count($results);
		}
		$limitClause = $this->getLimitClause($limit, $page);
		if($limitClause == "") return $results;
		$sql = $sql.$limitClause;
		return $this->executeQueryWithResults($sql);
	}
	
	function getPoursByDrinker($page, $limit, &$totalRows, $groupBy){
	    return $this->getPoursByDrinkerFiltered($page, $limit, $totalRows, $groupBy, null, null, null, null, null, null);
	}	
	function getPoursByDrinkerFiltered($page, $limit, &$totalRows, $groupBy, $startTime, $endTime, $tapId, $beerId, $userId, $style){
	    $sql="SELECT (@row_number:=@row_number + 1) AS id, userName, ";
	    $sql .= "SUM(CASE WHEN amountPouredUnit IN ('oz', 'gal', 'Imperial') THEN amountPoured ELSE amountPoured* 0.2641720000000005 END) as amountPoured ";
	    $sql .= ", 'gal' AS amountPouredUnit ";
	    if($groupBy)  {
	        $sql = $sql.", ";
	        switch ($groupBy){
	            case 'tapId':
	                $sql = $sql."MAX(tapNumber) as tapNumber";
	                break;
	            case 'beerId':
	                $sql = $sql."MAX(beerName) as beerName";
	                break;
	            case 'beerStyle':
	                $sql = $sql."CASE WHEN beerStyle = '' OR beerStyle IS NULL THEN 'undefined' ELSE beerStyle END as beerName";
	                break;
	            default:
	                $tempGroupBy = $groupBy;
	                $groupBy = "CASE WHEN ".$groupBy." IS NULL THEN -1 ELSE ".$groupBy." END";
	                $sql = $sql.$groupBy." AS ".$tempGroupBy;
	        }
	        $sql = $sql." ";
	    }
	    $sql = $sql."FROM ".$this->getViewName().",(SELECT @row_number:=0) AS t ";
	    $where = "";
	    if($startTime && $startTime != "") $where = $where.($where != ""?"AND ":"")."createdDate >= '$startTime' ";
	    if($endTime && $endTime != "") $where = $where.($where != ""?"AND ":"")."createdDate < '$endTime' ";
	    if($tapId)  $where = $where.($where != ""?"AND ":"")."tapId = $tapId ";
	    if($beerId) $where = $where.($where != ""?"AND ":"")."beerId = $beerId ";
	    if($userId) $where = $where.($where != ""?"AND ":"")."userId = $userId ";
	    if($style) $where = $where.($where != ""?"AND ":"")."beerStyle = '$style' ";
	    if($where != "") $sql = $sql."WHERE $where ";
	    $sql = $sql."GROUP BY userName";
	    if($groupBy) $sql = $sql.", ".$groupBy;
	    $totalRows = 0;
	    if($results = $this->executeQueryWithResults($sql)){
	        $totalRows = count($results);
	    }
	    $limitClause = $this->getLimitClause($limit, $page);
	    if($limitClause == "") return $results;
	    $sql = $sql.$limitClause;
	    return $this->executeQueryWithResults($sql);
	}
	
	function getPoursByTap($page, $limit, &$totalRows, $groupBy){
	    return $this->getPoursByTapFiltered($page, $limit, $totalRows, $groupBy, null, null, null, null, null, null);
	}	
	function getPoursByTapFiltered($page, $limit, &$totalRows, $groupBy, $startTime, $endTime, $tapId, $beerId, $userId, $style){
	    $sql="SELECT (@row_number:=@row_number + 1) AS id, tapNumber, tapId, ";
	    $sql .= "SUM(CASE WHEN amountPouredUnit IN ('oz', 'gal', 'Imperial') THEN amountPoured ELSE amountPoured* 0.2641720000000005 END) as amountPoured ";
	    $sql .= ", 'gal' AS amountPouredUnit ";
	    if($groupBy)  {
	        $sql = $sql.", ";
	        switch ($groupBy){
	            case 'userId':
	                $sql = $sql."MAX(userName) as userName";
	                $groupBy = "CASE WHEN ".$groupBy." IS NULL THEN -1 ELSE ".$groupBy." END";
	                break;
	            case 'beerId':
	                $sql = $sql."MAX(beerName) as beerName";
	                break;
	            case 'beerStyle':
	                $sql = $sql."CASE WHEN beerStyle = '' OR beerStyle IS NULL THEN 'undefined' ELSE beerStyle END as beerName";
	                break;
	            default:
	                $tempGroupBy = $groupBy;
	                $groupBy = "CASE WHEN ".$groupBy." IS NULL THEN -1 ELSE ".$groupBy." END";
	                $sql = $sql.$groupBy." AS ".$tempGroupBy;
	        }
	        $sql = $sql." ";
	    }
	    $sql = $sql."FROM ".$this->getViewName().",(SELECT @row_number:=0) AS t ";
	    $where = "";
	    if($startTime && $startTime != "") $where = $where.($where != ""?"AND ":"")."createdDate >= '$startTime' ";
	    if($endTime && $endTime != "") $where = $where.($where != ""?"AND ":"")."createdDate < '$endTime' ";
	    if($tapId)  $where = $where.($where != ""?"AND ":"")."tapId = $tapId ";
	    if($beerId) $where = $where.($where != ""?"AND ":"")."beerId = $beerId ";
	    if($userId) $where = $where.($where != ""?"AND ":"")."userId = $userId ";
	    if($style) $where = $where.($where != ""?"AND ":"")."beerStyle = '$style' ";
	    if($where != "") $sql = $sql."WHERE $where ";
	    $sql = $sql."GROUP BY tapNumber, tapId";
	    if($groupBy) $sql = $sql.", ".$groupBy;
	    $totalRows = 0;
	    if($results = $this->executeQueryWithResults($sql)){
	        $totalRows = count($results);
	    }
	    $limitClause = $this->getLimitClause($limit, $page);
	    if($limitClause == "") return $results;
	    $sql = $sql.$limitClause;
	    return $this->executeQueryWithResults($sql);
	}
	
	function getPoursByBeer($page, $limit, &$totalRows, $groupBy){
	    return $this->getPoursByBeerFiltered($page, $limit, $totalRows, $groupBy, null, null, null, null, null, null);
	}
	function getPoursByBeerFiltered($page, $limit, &$totalRows, $groupBy, $startTime, $endTime, $tapId, $beerId, $userId, $style){
	    $sql="SELECT (@row_number:=@row_number + 1) AS id, ";
	    $sql .= "SUM(CASE WHEN amountPouredUnit IN ('oz', 'gal', 'Imperial') THEN amountPoured ELSE amountPoured* 0.2641720000000005 END) as amountPoured ";
	    $sql .= ", 'gal' AS amountPouredUnit ";
	    if($groupBy != 'beerStyle')$sql = $sql.", beerName, beerId";
	    if($groupBy)  {
	        $sql = $sql.", ";
	        switch ($groupBy){
	            case 'tapId':
	                $sql = $sql."MAX(tapNumber) as tapNumber";
	                break;
	            case 'userId':
	                $sql = $sql."MAX(userName) as userName";
	                $groupBy = "CASE WHEN ".$groupBy." IS NULL THEN -1 ELSE ".$groupBy." END";
	                break;
	            case 'beerId':
	                $sql = $sql."MAX(beerName) as beerName";
	                break;
	            case 'beerStyle':
	                $sql = $sql."CASE WHEN beerStyle = '' OR beerStyle IS NULL THEN 'undefined' ELSE beerStyle END as beerName";
	                $sql = $sql.", MAX(beerId) as beerId";
	                break;
	            default:
	                $tempGroupBy = $groupBy;
	                $groupBy = "CASE WHEN ".$groupBy." IS NULL THEN -1 ELSE ".$groupBy." END";
	                $sql = $sql.$groupBy." AS ".$tempGroupBy;
	        }
	        $sql = $sql." ";
	    }
	    $sql = $sql."FROM ".$this->getViewName().",(SELECT @row_number:=0) AS t ";
	    $where = "";
	    if($startTime && $startTime != "") $where = $where.($where != ""?"AND ":"")."createdDate >= '$startTime' ";
	    if($endTime && $endTime != "") $where = $where.($where != ""?"AND ":"")."createdDate < '$endTime' ";
	    if($tapId)  $where = $where.($where != ""?"AND ":"")."tapId = $tapId ";
	    if($beerId) $where = $where.($where != ""?"AND ":"")."beerId = $beerId ";
	    if($userId) $where = $where.($where != ""?"AND ":"")."userId = $userId ";
	    if($style) $where = $where.($where != ""?"AND ":"")."beerStyle = '$style' ";
	    if($where != "") $sql = $sql."WHERE $where ";
	    $sql = $sql."GROUP BY ";
	    if(!$groupBy || $groupBy != 'beerStyle'){
	        $sql = $sql."beerName, beerId";
	    }else if($groupBy){
	        $sql = $sql.($groupBy == 'beerStyle'?"":", ").$groupBy;
	    }
	    $totalRows = 0;
	    if($results = $this->executeQueryWithResults($sql)){
	        $totalRows = count($results);
	    }
	    $limitClause = $this->getLimitClause($limit, $page);
	    if($limitClause == "") return $results;
	    $sql = $sql.$limitClause;
	    return $this->executeQueryWithResults($sql);
	}
	
	function getDisplayAmount($value, $currentUnit, $useLargeUnits = FALSE){ 
	    $ret = convert_volume($value, $currentUnit, getConfigValue(ConfigNames::DisplayUnitVolume), $useLargeUnits);
		return number_format($ret, 2);
	}
	
	function pour($USERID, $PIN, $PULSE_COUNT){
		$config = getAllConfigs();	
		$tapManager = new TapManager();
		$kegManager = new KegManager();
		$userManager = new UserManager();
		$user = null;
		if ($USERID > 0) {
			$user = $userManager->GetByID($USERID);
		}
		
		$tap = $tapManager->GetByFlowPin($PIN);
		if (!$tap) {
			echo "pours.php: No Active Tap Config for pin " .$PIN. "\n";
			exit();
		}
		$tapId = $tap->get_id();
		$keg = $kegManager->GetByID($tap->get_kegId());
		$beerId = 0;
		if($keg) $beerId = $keg->get_beerId();
		$pourCountConversion = $tap->get_count();
		
		// Sets the amount to be a fraction of a gallon/Liter
		$amount = 0;
		if( $pourCountConversion > 0 ) {
		    $amount = $PULSE_COUNT / $pourCountConversion;
		}else{
		    echo "pours.php: No Count Per ".is_unit_imperial($tap->get_countUnit())?"Gallon":"Liter"." Configured for pin " .$PIN. " Please update from Admin->Taps\n";
		}
		
		echo "pour on pin: " . $PIN . ", count: " . $PULSE_COUNT . 
		    ", conversion: " . $pourCountConversion . ", amount: " . $amount . ", amountUnit: " . $tap->get_countUnit() .
			", user: " . ($user?$user->get_id():'N/A') . "\n" ;
		// Inserts in to the pours table 
		$pour = new Pour();
		$pour->set_tapId($tapId);
		$pour->set_pinId($PIN);
		$pour->set_amountPoured($amount);
		$pour->set_amountPouredUnit($tap->get_countUnit());
		$pour->set_pulses($PULSE_COUNT);
		$pour->set_conversion($pourCountConversion);
		$pour->set_userId(($user?$user->get_id():(new UserManager)->getUnknownUserId()));
		$pour->set_beerId($beerId);
		$this->save($pour);
		
		if($keg){
    		$keg->set_currentAmount($keg->get_currentAmount() - $amount);
    		$kegManager->save($keg);
		}
	
		if ($beerId && $beerId != '' && $beerId != '0' && $user) {
			$access_token = ($user?$user->get_unTapAccessToken():null);
			$beer = null;
			if ($access_token) {
			    $beerManager = new BeerManager();
			    $beer = $beerManager->GetByID($beerId);
			}
			//echo $access_token;
			if ($access_token && $beer && $beer->get_untID()) {
				// create your UT instance		
			    $ut = new Pintlabs_Service_Untappd(getAllConfigs());
			    //          $access_token, $gmtOffset, $timezone, $beerId, 			    
			    $ut->checkin($access_token, date('Z')/60/60, date('T'), $beer->get_untID(), 
			        //$foursquareId, $userLat, $userLong, 
			        '', '', '', 
			        //$shout, 
			        'Poured with love by @raspberrypints', 
			        //$facebook, $twitter, $foursquare , $rating
			        false, false, false, '');
			}
		}
	}	
	
	function pourSample($tapId){
		$config = getAllConfigs();	
		$tapManager = new TapManager();
		$kegManager = new KegManager();
		
		$tap = $tapManager->GetByID($tapId);
		if (!$tap) {
			echo "pours.php: No Active Tap Config for id " .$tapId. "\n";
			exit();
		}
		$keg = $kegManager->GetByID($tap->get_kegId());
		$beerId = 0;
		if($keg) $beerId = $keg->get_beerId();
		$pourCountConversion = $tap->get_count();
		
		// Sets the amount to be a fraction of a gallon/liter
		if( is_unit_imperial($tap->get_countUnit()) ){
		  $amount = 1/128; //1/128 gallon = 1 oz
		  $amountUnit = UnitsOfMeasure::VolumeGallon;
		}else{
		    $amount = 30/1000; //ml
		    $amountUnit = UnitsOfMeasure::VolumeLiter;
		}
		echo "pour on tap: " . $tap->get_tapNumber() . ", count: " . 'Sample' . 
		     ", conversion: " . $pourCountConversion . 
		     ", amount: " . $amount . ", amountUnit: " . $tap->get_countUnit() . "\n" ;
		// Inserts in to the pours table 
		$pour = new Pour();
		$pour->set_tapId($tapId);
		$pour->set_pinId($tap->get_flowPinId());
		$pour->set_amountPoured($amount);
		$pour->set_amountPouredUnit($amountUnit);
		$pour->set_pulses(-1);
		$pour->set_conversion($pourCountConversion);
		$pour->set_beerId($beerId);
		$pour->set_userId((new UserManager)->getUnknownUserId());
		if(!$this->save($pour)){
		    global $mysqli;
		    $_SESSION['errorMessage'] = 'Unable To Save Pour:'.$mysqli->error;
		} else{
    		if($keg){
        		$keg->set_currentAmount($keg->get_currentAmount() - $amount);
        		$kegManager->save($keg);
    		}
		}
	}
}