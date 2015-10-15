<?php
function redirect($url){
	echo "<script>window.location = '$url';</script>";
	exit();
}

function encode($string){
#	return htmlentities ($string, ENT_QUOTES);
	$string = str_replace(array("\n", "\r"), '', $string);
	return json_encode ($string, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
}