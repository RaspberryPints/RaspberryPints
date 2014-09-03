<?php

include ("../lib/untappdPHP.php");

// add your client_id, client_secret, redirect_uri available at https://untappd.com/api
//$client_id = "CLIENT_ID";
//$client_secret = "CLIENT_SECRET";
$redirect_uri = "";
 $client_id = "F991DC82D5A3CD53E49DBE4B8AB36DD4052A881D";
    $client_secret = "0B632BB937A7D1D809CE06005318112BE4257916";

// create your UT instance
$ut = new UntappdPHP($client_id, $client_secret, $redirect_uri);

// get the basic call without authetnication
$info = $ut->get("/user/info/gregavola");
// Pass params in the array as a second value
// $info = $ut->get("/user/info/gregavola", array("limit" => 5));

// fly away!
print_r($info);

?>
