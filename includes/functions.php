<?php

require_once __DIR__.'/UntappdPHP/lib/untappdPHP.php';

function utBreweryFeed($config) {
	
	$cachefile = "cache/bfeed";
$filetimemod = filemtime($cachefile)+600;
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
    $fp = fopen($cachefile, 'w');
    fwrite($fp, $bfeeds);
    fclose($fp);

ob_end_flush();
include $cachefile;
}
}


function beerRATING($config,$untID) {

$cachefile = "cache/rating.".$untID."";
$filetimemod = filemtime($cachefile)+86400;
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
	if ($rs >= '0' && $rs<'.5') {
 $img = "<span class=\"rating small r00\"></span>";
} else if ($rs=='.5') {
$img = "<span class=\"rating small r05\"></span>";
} else if ($rs >'.5' && $rs<'1.5') {
$img = "<span class=\"rating small r10\"></span>";
} else if ($rs=='1.5') {
$img = "<span class=\"rating small r15\"></span>";
} else if ($rs >'1.5' && $rs <'2.5') {
$img = "<span class=\"rating small r20\"></span>";
} else if ($rs =='2.5' ) {
$img = "<span class=\"rating small r25\"></span>";
} else if ($rs >'2.5' && $rs < '3.5') {
$img = "<span class=\"rating small r30\"></span>";
} else if ($rs=='3.5') {
 $img = "<span class=\"rating small r35\"></span>";
}  else if ($rs > '3.5' && $rs< '4.5') {
 $img = "<span class=\"rating small r40\"></span>";
} else if ($rs =='4.5') {
$img = "<span class=\"rating small r45\"></span>";
} else if ($rs>'4.5') {
$img = "<span class=\"rating small r50\"></span>";
} 
} else {
 $img = "<span class=\"rating small r00\"></span>";
 }

	
	$fp = fopen($cachefile, 'w');
    fwrite($fp, $img);
    fclose($fp);

ob_end_flush();
include $cachefile;
}
 
 }

 function beerIMG($config,$untID) {

$cachefile = "cache/img.".$untID."";
$filetimemod = filemtime($cachefile)+86400;
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
	$fp = fopen($cachefile, 'w');
    fwrite($fp, $imgs);
    fclose($fp);

ob_end_flush();
include $cachefile;
}
 
 }


?>
