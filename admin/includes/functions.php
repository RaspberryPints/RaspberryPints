<?php
function redirect($url){
	echo "<script>window.location = '$url';</script>";
	exit();
}