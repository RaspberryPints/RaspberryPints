<?php

require_once __DIR__.'/Pintlabs/Service/Untappd.php';


function utBreweryFeed($config, $breweryId) {
	
	if(!isset($untID))return;
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


function beerRATING($config, $untID, $display=TRUE ) {

	if(!isset($untID))return;
	$cachefile = __DIR__."/cache/rating/".$untID."";
	
	$filetimemod = 0;
	if(file_exists($cachefile)) {
		$filetimemod = filemtime($cachefile)+86400;
	}
	//If display then only use the cache file otherwise we are saving the beer and want to update the cache
	if ($display) {
		include $cachefile;
	} elseif($filetimemod == 0 || time()<$filetimemod){
		ob_start();
		// This section calls for the rating from Untappd																		
		if($config[ConfigNames::ClientID] && $beer->untID!='0'){ 
			$ut = new Pintlabs_Service_Untappd($config);
			$rs = 0;
			try{
    			$feed = $ut->beerInfo($untID)->response->beer;
    			$rs = $feed->rating_score;
    			$rs = .5*floor($rs/.5);
			}catch(Exception $e){
			    
			}
			$img = "<span class=\"rating small\" style=\"background-position: 0 ".(-48*$rs)."px;\"></span><span class=\"num\">(".$rs.")</span>";
		} else {
			$img = "";
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
		}
	}
 
 }

 function beerIMG($config, $untID, $display=TRUE) {
	 
	if(!isset($untID))return;
	$cachefile = __DIR__."/cache/img/".$untID."";
	$filetimemod = 0;
	if(file_exists($cachefile)) {
		$filetimemod = filemtime($cachefile)+86400;
	}
	//If display then only use the cache file otherwise we are saving the beer and want to update the cache
	if ($display && false) {
		include $cachefile;
	} elseif($filetimemod == 0 || time()<$filetimemod) {
		ob_start();
		if($config[ConfigNames::ClientID] && $beer->untID!='0'){ 
			$ut = new Pintlabs_Service_Untappd($config);
			try {
    			$feed = $ut->beerInfo($untID)->response->beer;
    			$img = $feed->beer_label;
    			$imgs = "<img src=".$img." style=\"border:0;width:100%\">";
			} catch (Exception $e) {
			    echo 'N/A';
			    ob_end_flush();
			    return;
			}
		} else {
			$imgs = "<img src='https:\/\/d1c8v1qci5en44.cloudfront.net/site/assets/images/temp/badge-beer-default.png' border=0 width=75 height=75>";
		}
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
