<?php

require_once __DIR__.'/UntappdPHP/lib/untappdPHP.php';

function utBreweryFeed($config) {
	
	if(!isset($untID) || $untID == 0)return;
	$cachefile = "cache/bfeed";
	$filetimemod = 0;
	if(file_exists($cachefile)) {
		$filetimemod = filemtime($cachefile)+600;
	}
	if (time()<$filetimemod) {
		include $cachefile;
	} else {
		ob_start();
		
		$client_id = 'F991DC82D5A3CD53E49DBE4B8AB36DD4052A881D';
		$client_secret = '0B632BB937A7D1D809CE06005318112BE4257916';
		$redirect_uri  = '';
		$ut = new UntappdPHP($client_id,$client_secret,$redirect_uri);
		$bfeed = $ut->get("/brewery/checkins/51594", array( 'limit' => '4'));
		
		$bfeeds .="<table width=95%><tr>";

		foreach ($bfeed->response->checkins->items as $i) {
			
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


function beerRATING($config,$untID) {

	if(!isset($untID) || $untID == 0)return;
	$cachefile = "cache/rating".$untID."";
	$filetimemod = 0;
	if(file_exists($cachefile)) {
		$filetimemod = filemtime($cachefile)+86400;
	}
	if (time()<$filetimemod) {
		include $cachefile;
	} else {
		ob_start();
		// This section calls for the rating from Untappd
		//echo $untID;
		$beerImg = '';																				
		if($config[ConfigNames::ClientID] && $beer->untID!='0'){ 
	  
			$client_id = $config[ConfigNames::ClientID];
			$client_secret =$config[ConfigNames::ClientSecret];
			$redirect_uri  = '';
			$ut = new UntappdPHP($client_id,$client_secret,$redirect_uri);
			$feed = $ut->get("/beer/info/".$untID."");
			$feed = $feed->response->beer;

			$rs = $feed->rating_score;
			$rs = .5*floor($rs/.5);
			$img = "<span class=\"rating small\" style=\"background-position: 0 ".(-48*$rs)."px;\"></span><span class=\"num\">(".$rs.")</span>";
		} else {
			$img = "";
		}
		
		if($img != "")
		{
			$img = '<p class="rating">'.$img.'</p>';
		
			$fp = false;
			try{ $fp = fopen($cachefile, 'w'); } catch(Exception $e){}
			if($fp)
			{
				fwrite($fp, $img);
				fclose($fp);
				ob_end_flush();
				if (file_exists($cachefile))include $cachefile;
			}
			else
			{
				echo $img;
			}
		}
	}
 
 }

 function beerIMG($config,$untID) {
	 
	if(!isset($untID) || $untID == 0)return;
	$cachefile = "cache/img".$untID."";
	$filetimemod = 0;
	if(file_exists($cachefile)) {
		$filetimemod = filemtime($cachefile)+86400;
	}
	if (time()<$filetimemod) {
		include $cachefile;
	} else {
		ob_start();
		// This section calls for the beerIMG from Untappd
		//echo $untID;
		if($config[ConfigNames::ClientID] && $beer->untID!='0'){ 
			$beerImg = '';																				
			$client_id = $config[ConfigNames::ClientID];
			$client_secret =$config[ConfigNames::ClientSecret];
			$redirect_uri  = '';
			$ut = new UntappdPHP($client_id,$client_secret,$redirect_uri);
			$feed = $ut->get("/beer/info/".$untID."");
			$feed = $feed->response->beer;
			//return $feed;
			//print_r ($feed);	
			$img = $feed->beer_label;
			$imgs = "<img src=".$img." border=0 width=75 height=75>";
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
			if (file_exists($cachefile))include $cachefile;
		}
		else
		{
			echo $imgs;
		}
	}

}


?>
