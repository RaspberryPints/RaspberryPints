<?php

function db(){
	$link = mysql_connect("localhost", "beer", "beer");
	mysql_select_db("raspberrypints");
}


?>