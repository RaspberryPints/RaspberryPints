<?php

require_once __DIR__.'/Pintlabs/Service/Untappd.php';


function utBreweryFeed($config, $breweryId) {
	
    if(!isset($breweryId))return;
	$cachefile = "cache/bfeed";
	$filetimemod = 0;
	if(file_exists($cachefile)) {
		$filetimemod = filemtime($cachefile)+600;
	}
	if (time()<$filetimemod) {
		include $cachefile;
	} else {
		ob_start();
		
		$ut = new Pintlabs_Service_Untappd($config);
		$bfeed = $ut->breweryFeed($breweryId, '', '', 4)->response->checkins;
	
		$bfeeds .="<table width=95%><tr>";

		foreach ($bfeed->items as $i) {
			
			$j = $i->beer->beer_name;
			$bfeeds .="<td width=20%><table width=95%><tr><td><div class='beerfeed'>";
			$bfeeds .="<center><div class=circular style='width: 50px;height: 50px;background-image: url(". $i->user->user_avatar .");background-size: cover;display: block;border-radius: 100px;-webkit-border-radius:  100px;-moz-border-radius: 100px;'></div>";
			$bfeeds .="".$i->user->user_name."<br />";

			$bfeeds .=$i->beer->beer_name;

			$bfeeds .="</td></tr></table>";
			$bfeeds .="</div></td>";
		 
	}

		$bfeeds .="</tr></table>";
		$fp = false;
		try{ $fp = fopen($cachefile, 'w'); } catch(Exception $e){}
		if($fp)
		{
			fwrite($fp, $bfeeds);
			fclose($fp);
			ob_end_flush();
			if (file_exists($cachefile))include $cachefile;
		}
		else
		{
			echo $bfeeds;
		}
	}
}


function beerRATING($config, $untID, $rating=NULL, $displayOnly=TRUE ) {

    
    if(isset($untID)){
    	$cachefile = __DIR__."/cache/rating/".$untID."";
    	
    	$filetimemod = 0;
    	if(file_exists($cachefile)) {
    	    $filetimemod = filemtime($cachefile)+86400;
    	}
    	//If display then only use the cache file otherwise we are saving the beer and want to update the cache
    	if ($displayOnly && $filetimemod > 0) {
    		include $cachefile;
    	} elseif($filetimemod == 0 || time()<$filetimemod){
    	    $img = "";
    		ob_start();
    		// This section calls for the rating from Untappd																		
    		if($config[ConfigNames::ClientID] && $untID!='0'){ 
    			$ut = new Pintlabs_Service_Untappd($config);
    			$rs = 0;
    			try{
        			$feed = $ut->beerInfo($untID)->response->beer;
        			$rs = $feed->rating_score;
        			$rs = .5*floor($rs/.5);
        			$img = "<span class=\"rating small\" style=\"background-position: 0 ".(-48*$rs)."px;\"></span><span class=\"num\">(".$rs.")</span>";
    			}catch(Exception $e){
    			    
    			}
    		}
    		if($img != "")
    		{
    			$img = '<p class="rating">'.$img.'</p>';
    			try{ $fp = fopen($cachefile, 'w'); } catch(Exception $e){}
    			if($fp)
    			{
    				fwrite($fp, $img);
    				fclose($fp);
    				ob_end_flush();
    			}
    			//Dont let the local rating be displayed
    			return;
    		}
    	}
    }
    //untappd not set or could not get use local rating
    if(isset($rating) && NULL !== $rating){
        $rs = .5*floor($rating/.5);
        echo "<p class=\"rating\"><span class=\"rating small\" style=\"background-position: 0 ".(-48*$rs)."px;\"></span><span class=\"num\">(".$rs.")</span></p>";
    }
 
 }

 function beerIMG($config, $untID, $beerId, $displayOnly=TRUE) {
	 
     if(!isset($untID) && !isset($beerId))return;
	$cachefile = __DIR__."/cache/img/".$untID."";
	$filetimemod = 0;
	if(file_exists($cachefile)) {
	    //update 1 time per year
	    $filetimemod = filemtime($cachefile)+31536000;
	}
	
	if( isset($beerId) ) $imgFiles = glob ( 'img/beer/beer'.$beerId.'.*' );
	if( isset($beerId) && count($imgFiles) > 0 ){
	    $imgs = "<img src=".$imgFiles[0]." style=\"border:0;width:100px\">";
	    echo $imgs;
	}
	//If display then only use the cache file otherwise we are saving the beer and want to update the cache
	else if ($displayOnly && $filetimemod > 0) {
		include $cachefile;
	}else if($filetimemod == 0 || time()<$filetimemod) {
		ob_start();
		$img = 'https://d1c8v1qci5en44.cloudfront.net/site/assets/images/temp/badge-beer-default.png';
		if($config[ConfigNames::ClientID] && $untID!='0'){ 
			$ut = new Pintlabs_Service_Untappd($config);
			try {
    			$feed = $ut->beerInfo($untID)->response->beer;
    			$img = $feed->beer_label;
			} catch (Exception $e) {
			    //echo 'N/A';
			    ob_end_flush();
			    return;
			}
		} 
        $imgs = "<img src=".$img." style=\"border:0;width:100px\">";
		$fp = false;
		try{ $fp = fopen($cachefile, 'w'); } catch(Exception $e){}
		if($fp)
		{
			fwrite($fp, $imgs);
			fclose($fp);
			ob_end_flush();
			include $cachefile;
		}
	}

}

?>
