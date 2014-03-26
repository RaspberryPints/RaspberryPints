<?php

class Untappd extends UntappdPHP 
{


	public static function utBreweryFeed($options) {

	$client_id = $options[OptionNames::ClientID];
    $client_secret =$options[OptionNames::ClientSecret];
    $redirect_uri  = '';
	$ut = new UntappdPHP($client_id,$client_secret,$redirect_uri);
	$bfeed = $ut->get("/brewery/checkins/".$options[OptionNames::BreweryID]."", array( 'limit' => '4'));
	
	return $bfeed;
} 
	 
  

Public static function beerINFO($options,$untID) {
// This section calls for the rating from Untappd
                                                       
   $beerImg = '';																				
  $client_id = $options[OptionNames::ClientID];
    $client_secret =$options[OptionNames::ClientSecret];
    $redirect_uri  = '';
	$ut = new UntappdPHP($client_id,$client_secret,$redirect_uri);
	$feed = $ut->get("/beer/info/".$untID."");
    return $feed; 
}

	

}