<?php
	session_start();
	if(!isset( $_SESSION['myusername'] )){
		header("location:index.php");
	}
	
	$MCAST_PORT = 0xBEE2;
	$HOST = "localhost";
	$errno = 0;
	$errstr = "";

	$received = "RPNAK";
	$value = htmlspecialchars($_GET["value"]);

	$data = "";

	if ($value == "all"  ||
	    $value == "valve"||
	    $value == "fan"  ||
	    $value == "flow" ||
	    $value == "config" ||
	    $value == "alamode")
	{
		$data = "RPC:".$value."\n";
	} 
	else 
	{
		echo $received;
		exit();
	}
	
	$fp = fsockopen($HOST, $MCAST_PORT, $errno, $errstr, 10);
    if($fp){
    	fwrite($fp, $data);
    	$received = fread($fp, 1024);
    	fclose($fp);
    	echo $received;
    }
?>