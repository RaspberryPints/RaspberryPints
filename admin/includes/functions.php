<?php
function redirect($url){
	echo "<script>window.location = '" . $url . "';</script>";
	exit();
}

function encode($string){
	return htmlentities ($string, ENT_QUOTES);
}
