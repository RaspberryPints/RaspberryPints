<?php
function redirect($url){
	echo "<script>window.location = '$url';</script>";
	exit();
}

function encode($string){
	//$string = str_replace(array("\n", "\r"), '', $string);
	$string = htmlentities ($string, ENT_QUOTES);
	return $string;
}
