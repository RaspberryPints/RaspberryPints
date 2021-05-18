<?php
	session_start();
	if(!isset( $_SESSION['myusername'] )){
		header("location:index.php");
	}
	
	$MCAST_PORT = 0xBEE2;
	$HOST = "localhost";
	$errno = 0;
	$errstr = "";

	$echoOn = false;
	$received = "RPNAK";
	/** @var mixed $value **/
	if(!isset($value))	{
	    $value = htmlspecialchars($_GET["value"]);
	    $echoOn = true;
	}

	$data = "";

	if ($value == "all"  ||
	    $value == "valve"||
	    $value == "fan"  ||
	    $value == "flow" ||
	    $value == "config" ||
	    $value == "alamode" ||
	    $value == "tare" ||
	    $value == "tempProbe"||
	    $value == "shutdown"||
	    $value == "restart"||
	    $value == "restartservice"||
	    $value == "upgrade"||
	    $value == "upgradeForce")
	{
		$data = "RPC:".$value."\n";
	} 
	else 
	{
	    if( $echoOn )echo $received;
		exit();
	}
	
	$fp = fsockopen($HOST, $MCAST_PORT, $errno, $errstr, 10);
    if($fp){
    	fwrite($fp, $data);
    	$received = fread($fp, 1024);
    	fclose($fp);
    	if( $echoOn )echo $received;
    }
?>