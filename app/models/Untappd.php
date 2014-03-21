<?php
include __DIR__."/../../vendor/Pintlabs/Untappd.php";

class Untappd extends Eloquent 
{


	public static function utBreweryFeed($options) {
//Only checkins if $BreweryID is set
		if($options[OptionNames::ClientID]){ 
if (!__DIR__."/../../cache/bfeed") {
$utconfig = array(
    'clientId'     => $options[OptionNames::ClientID],
    'clientSecret' => $options[OptionNames::ClientSecret],
    'redirectUri'  => '',
    'accessToken'  => '',
);
$cachefile = __DIR__."/../../cache/bfeed";

ob_start();
$buntappd = new Pintlabs_Service_Untappd($utconfig);
try {
    
    $bfeed = $buntappd->breweryFeed($options[OptionNames::BreweryID], '','', '4');
    
} catch (Exception $e) {
    die($e->getMessage());
} 

  
 $bfeeds ="<table width=95%><tr>";

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

} else {


$utconfig = array(
    'clientId'     => $options[OptionNames::ClientID],
    'clientSecret' => $options[OptionNames::ClientSecret],
    'redirectUri'  => '',
    'accessToken'  => '',
);
$cachefile = __DIR__."/../../cache/bfeed";
$filetimemod = filemtime($cachefile)+1800;
if (time()<$filetimemod) {
include $cachefile;
} else {
ob_start();
$buntappd = new Pintlabs_Service_Untappd($utconfig);
try {
    
    $bfeed = $buntappd->breweryFeed($options[OptionNames::BreweryID], '','', '4');
    
} catch (Exception $e) {
    die($e->getMessage());
} 

  
 $bfeeds ="<table width=95%><tr>";

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
}  } else {

echo "";
}
}

Public static function beerIMG($options,$untID) {
// This section calls for the rating from Untappd
                                                       
   $beerImg = '';																				
//Only Display rating if $Client[id] is set
if($options[OptionNames::ClientID] && $untID!='0'){ 
if (!__DIR__."/../../cache/".$untID.".img") {
$cachefile = __DIR__."/../../cache/".$untID.".img";
ob_start();	                                                                                      

$utconfig = array(
    'clientId'     => $options[OptionNames::ClientID],
    'clientSecret' => $options[OptionNames::ClientSecret],
    'redirectUri'  => '',
    'accessToken'  => '',
);


$untappd = new Pintlabs_Service_Untappd($utconfig);
try {
    $feed = $untappd->beerInfo($untID);
}  catch (Exception $e) {
    die($e->getMessage());
}
$beerImg = "<img src=".$feed->response->beer->beer_label." border=0 width=75 height=75>";
$fp = fopen($cachefile, 'w');
    fwrite($fp, $beerImg);
    fclose($fp);

ob_end_flush();
include $cachefile;

} else {
$cachefile = __DIR__."/../../cache/".$untID.".img";
$filetimemod = filemtime($cachefile)+86400;
if (time()<$filetimemod) {
include $cachefile;
} else {
ob_start();	                                                                                      

$utconfig = array(
    'clientId'     => $options[OptionNames::ClientID],
    'clientSecret' => $options[OptionNames::ClientSecret],
    'redirectUri'  => '',
    'accessToken'  => '',
);


$untappd = new Pintlabs_Service_Untappd($utconfig);
try {
    $feed = $untappd->beerInfo($untID);
}  catch (Exception $e) {
    die($e->getMessage());
}
$beerImg = "<img src=".$feed->response->beer->beer_label." border=0 width=75 height=75>";
$fp = fopen($cachefile, 'w');
    fwrite($fp, $beerImg);
    fclose($fp);

ob_end_flush();
include $cachefile;
}
} } else {

$beerImg = '';
} 
}

public static function BeerRating($options,$untID) {
// This section calls for the rating from Untappd
                                                       
   																
//Only Display rating if $Client[id] is set
if($options[OptionNames::ClientID] && $untID!='0'){ 
if (!__DIR__."/../../cache/".$untID.".rating") {
$cachefile = __DIR__."/../../cache/".$untID.".rating";
ob_start();		                                                                                      
$utconfig = array(
    'clientId'     => $options[OptionNames::ClientID],
    'clientSecret' => $options[OptionNames::ClientSecret],
    'redirectUri'  => '',
    'accessToken'  => '',
);

$untappd = new Pintlabs_Service_Untappd($utconfig);
try {
    $feed = $untappd->beerInfo($untID);
}  catch (Exception $e) {
    die($e->getMessage());
}


$rs = $feed->response->beer->rating_score;

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
$fp = fopen($cachefile, 'w');
    fwrite($fp, $img);
    fclose($fp);

ob_end_flush();
include $cachefile;
} else {
$cachefile = __DIR__."/../../cache/".$untID.".rating";
$filetimemod = filemtime($cachefile)+86400;
if (time()<$filetimemod) {
include $cachefile;
} else {
ob_start();		                                                                                      
$utconfig = array(
    'clientId'     => $options[OptionNames::ClientID],
    'clientSecret' => $options[OptionNames::ClientSecret],
    'redirectUri'  => '',
    'accessToken'  => '',
);

$untappd = new Pintlabs_Service_Untappd($utconfig);
try {
    $feed = $untappd->beerInfo($untID);
}  catch (Exception $e) {
    die($e->getMessage());
}


$rs = $feed->response->beer->rating_score;

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
$fp = fopen($cachefile, 'w');
    fwrite($fp, $img);
    fclose($fp);

ob_end_flush();
include $cachefile;
}
 } } else {
$img = '';



} 
}	

}