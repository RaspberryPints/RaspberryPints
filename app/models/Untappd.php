<?php
include __DIR__."/../includes/Untappd.php";

class Untappd extends Eloquent 
{


	public static function utBreweryFeed($options) {
//Only checkins if $BreweryID is set
		if($options[OptionNames::ClientID]){ 

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
} else {

echo "";
}
}

	

}