<?php

include ("../lib/untappdPHP.php");

// Set your client ID, client secreet, redirect URI
//$client_id = "CLIENT_ID";
//$client_secret = "CLIENT_SECRET";
 $client_id="F991DC82D5A3CD53E49DBE4B8AB36DD4052A881D";
 $client_secret="0B632BB937A7D1D809CE06005318112BE4257916";
$redirect_uri="http:\/\/rp.skypainterbrewing.com/includes/UntappdPHP/oauth_examples/callback.php";

// create the basic constructor with 
$ut = new UntappdPHP($client_id, $client_secret, $redirect_uri);

// grab the CODE query string
$code = $_GET['code'];

// send POST back to server to get access token
$a = $ut->getAccessToken("DSADAS");

// parse the response
if ($a->meta->http_code == 200) {
	// grab the response and the access token
	$access_token = $a->response->access_token;

	// set the token the instance you created
	$ut->setToken($access_token);

	// back a call to the to user/info call
	$userInfo = $ut->get("/user/info");

	// print results
	print_r($userInfo);
}
else {
	// do error handling here
	echo $a->meta->error_detail;
}

?>
